<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Stock;
use App\Models\Stock\Stock\Transfer;
use App\Models\Stock\Stock\Transfer\Item;
use App\Models\Stock\Stock\Log;
use DateTime;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function signature($id)
    {
        $transfer = Transfer::uuid($id);

        $due = 1;

        if($transfer->returned_at) {
            $diff = $transfer->returned_at->diff($transfer->scheduled_to);

            $days = $diff->days;

            if($days > 0) {
              $due = $days;
            }
        }

        return view('transfer.term', compact('transfer', 'due'));
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
                $transfer->save();

                Log::create(
                  [
                    'stock_id' => $item->stock->id,
                    'user_id' => $user->id,
                    'message' => 'Item transferido, codigo tranferencia: ' . $transfer->id
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
                $transfer->save();

                Log::create(
                  [
                    'stock_id' => $item->stock->id,
                    'user_id' => $user->id,
                    'message' => 'Item devolvido, codigo tranferencia: ' . $transfer->id
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
        if(!$request->has('stock')) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Nenhum Ativo foi informado.'
          ]);

          return back();
        }

        $stock = Stock::uuid($request->get('stock'));

        $hasTransfer = Transfer::whereIn('status', ['Pendente', 'Autorizado', 'Em Uso'])
        ->whereHas('items', function($query) use($stock) {
            $query->where('stock_id', $stock->id);
        })->get();

        if($hasTransfer->isNotEmpty()) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Este ativo já esta vinculado a uma transferência.'
          ]);

          return back();

        }

        return view('transfer.create', compact('stock'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
