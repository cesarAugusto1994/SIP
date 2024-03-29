<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Stock;
use App\Models\Stock\Stock\Transfer;
use App\Models\Stock\Stock\Transfer\Item;
use App\Models\Stock\Stock\Log;
use App\Models\Ticket;
use DateTime;
use PDF;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers = Transfer::orderByDesc('id')->paginate();
        return view('transfer.index', compact('transfers'));
    }

    public function items($id, Request $request)
    {
        $transfer = Transfer::uuid($id);
        $stocks = Stock::where('status', 'Disponivel')->get();
        return view('transfer.items', compact('transfer', 'stocks'));
    }

    public function itemsStore($id, Request $request)
    {
        if(!$request->has('items')) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Nenhum ativo informado para adicionar à transferência.'
          ]);

          return back();

        }

        $transfer = Transfer::uuid($id);

        $items = $request->get('items');

        $stocks = Stock::whereIn('id', $items)->get();

        foreach ($stocks as $key => $stock) {

            if($stock->status != 'Disponível') {

              notify()->flash('Atenção!', 'info', [
                'text' => 'O Item #' . $stock->id . ' já se encontra adicionado à uma transferência.'
              ]);

              continue;

            }

            Item::updateOrcreate([
              'stock_id' => $stock->id,
              'transfer_id' => $transfer->id,
            ]);

            $stock->status = 'Reservado';
            $stock->save();
        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Itens adicionados à transferência #' . $transfer->id . ' com sucesso.'
        ]);

        return redirect()->route('transfer.show', $transfer->uuid);
    }

    public function itemsDestroy($id, $item)
    {
        try {

          $item = Item::uuid($item);

          $item->stock->status = 'Disponível';
          $item->stock->save();

          $item->delete();

          return response()->json([
            'success' => true,
            'message' => 'Item removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function signature($id)
    {
        $transfer = Transfer::uuid($id);

        $due = 0;

        if($transfer->returned_at) {
            $diff = $transfer->returned_at->diff($transfer->scheduled_to);

            $days = $diff->days;

            if($days > 0) {
              $due = $days;
            }
        }

        $id = str_pad($transfer->id, 6, "0", STR_PAD_LEFT);
        $title = "Transferencia:$id:";

        $pdf = PDF::loadView('transfer.term', compact('transfer', 'due'));

        $stylePdf = $pdf->getDomPDF();
        $canvas = $stylePdf ->get_canvas();
        $canvas->page_text(520, 2, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(255, 255, 255));

        return $pdf->stream($title. ".pdf");
    }

    public function transfer($id, Request $request)
    {
        if(!$request->has('action')) {

          return response()->json([
            'success' => false,
            'message' => 'Ação não informada.'
          ]);
        }

        $user = $request->user();

        $action = $request->get('action');

        $transfer = Transfer::uuid($id);

        if($action == 'approve') {
            $transfer->status = 'Autorizado';
        } elseif($action == 'deny') {
            $transfer->status = 'Negado';
        }

        $transfer->save();

        if($action == 'withdrawn') {

            $transfer->items->map(function($item) use($user) {

                $transfer = $item->transfer;
                $item->stock->localization = $transfer->localization;

                if($transfer->localization == 'Usuário') {
                    $item->stock->user_id = $item->transfer->target_id;
                } elseif($transfer->localization == 'Departamento') {
                    $item->stock->department_id = $item->transfer->target_id;
                } elseif($transfer->localization == 'Unidade') {
                    $item->stock->unity_id = $item->transfer->target_id;
                } elseif($transfer->localization == 'Fornecedor') {
                    $item->stock->vendor_id = $item->transfer->target_id;
                }

                $item->stock->status = 'Em Uso';
                $item->stock->save();

                $transfer->status = 'Em Uso';
                $transfer->withdrawn_at = now();
                $transfer->save();

                Log::create(
                  [
                    'stock_id' => $item->stock->id,
                    'user_id' => $user->id,
                    'message' => 'Item transferido, codigo transferência: ' . $transfer->id
                  ]
                );

            });

        }

        if($action == 'return') {

            $transfer->items->map(function($item) use($user) {

                $transfer = $item->transfer;
                $item->stock->localization = 'Almoxarifado';

                $item->stock->user_id == null;
                $item->stock->department_id = null;
                $item->stock->unity_id = null;
                $item->stock->vendor_id = null;

                $item->stock->status = 'Disponível';
                $item->stock->save();

                $transfer->status = 'Devolvido';
                $transfer->returned_to = $user->id;
                $transfer->save();

                Log::create(
                  [
                    'stock_id' => $item->stock->id,
                    'user_id' => $user->id,
                    'message' => 'Itens devolvidos com sucesso, código transferência: ' . $transfer->id
                  ]
                );

            });

        }

        return response()->json([
          'success' => true,
          'message' => 'O pedido de transferencia atualizado com sucesso.',
          'route' => route('transfer.show', $transfer->uuid)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $stocks = $stock = null;

        if($request->has('stock')) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Nenhum Ativo foi informado.'
          ]);

          $stock = Stock::uuid($request->get('stock'));

          if($stock->status != 'Disponível') {

            notify()->flash('Erro!', 'error', [
              'text' => 'Este ativo deve estar disponivel para uma transferência.'
            ]);

            return back();

          }

        } else {

              $stocks = Stock::where('status', 'Disponível')->get();

        }

        return view('transfer.create', compact('stocks', 'stock'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->request->all();

        if(!$request->filled('subject')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'O assunto/motivo deve ser informado.',
            'modal' => true
          ]);
          return back();
        }

        if(!$request->filled('description')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'A descrição deve ser informada.',
            'modal' => true
          ]);
          return back();
        }

        if(!$request->filled('scheduled_to')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'A Data de Agendamento deve ser informada.',
            'modal' => true
          ]);
          return back();
        }

        if(!$request->filled('withdrawn_at')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'A Data de Retirada deve ser informada.',
            'modal' => true
          ]);
          return back();
        }

        $ticket = null;

        if($request->filled('ticket_id')) {

            $ticket = Ticket::find($request->get('ticket_id'));

            if($ticket) {

              $ticket = $ticket->id;

            } else {

              notify()->flash('Erro!', 'error', [
                'text' => 'O chamado informado não foi encontrado.',
                'modal' => true
              ]);
              return back();

            }
        }

        $user = $request->user();

        $scheduledTo = $withdrawn = $returned = null;

        if($request->filled('scheduled_to')) {
            $scheduledTo = DateTime::createFromFormat('d/m/Y', $data['scheduled_to']);
        }

        if($request->filled('withdrawn_at')) {
            $withdrawn = DateTime::createFromFormat('d/m/Y', $data['withdrawn_at']);
        }

        if($request->filled('returned_at')) {
            $returned = DateTime::createFromFormat('d/m/Y', $data['returned_at']);
        }

        $target = null;

        if($request->filled('localization')) {

          $localization = $request->get('localization');

          if($localization == 'Usuário') {
              $target = $request->get('user_id');
          } elseif($localization == 'Departamento') {
              $target = $request->get('department_id');
          } elseif($localization == 'Unidade') {
              $target = $request->get('unity_id');
          } elseif($localization == 'Fornecedor') {
              $target = $request->get('vendor_id');
          }

        }

        $stock = Stock::uuid($request->get('stock_id'));

        $data['scheduled_to'] = $scheduledTo;
        $data['withdrawn_at'] = $withdrawn;
        $data['returned_at'] = $returned;
        $data['stock_id'] = $stock->id;
        $data['user_id'] = $user->id;
        $data['target_id'] = $target;
        $data['ticket_id'] = $ticket;

        $transfer = Transfer::create($data);

        Item::create([
          'stock_id' => $stock->id,
          'transfer_id' => $transfer->id,
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Solicitação de transferencia aberta com sucesso.'
        ]);

        return redirect()->route('transfer.show', $transfer->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer = Transfer::uuid($id);
        return view('transfer.show', compact('transfer'));
    }
}
