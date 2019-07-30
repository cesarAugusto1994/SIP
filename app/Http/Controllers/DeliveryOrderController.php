<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\{Client, People};
use App\Models\Delivery\Document;
use App\Models\Client\Address;
use App\Models\Department\Occupation;
use App\Models\DeliveryOrder\Documents as DeliveryOrderDocuments;
use App\Helpers\Constants;
use App\Notifications\DeliveryOrder as DeliveryOrderNotification;
use App\Mail\DeliveryOrder as DeliveryOrderMail;
use App\Jobs\DeliveryOrder as DeliveryOrderJob;
use Illuminate\Support\Facades\Validator;
use Notification;
use Auth;
use PDF;
use Mail;
use App\User;

class DeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.ordem.entrega')) {
            return abort(403, 'Unauthorized action.');
        }

        $orders = DeliveryOrder::where('id', '>', 0)->get();

        if($request->filled('q')) {
            $search = $request->get('q');
            $orders = $orders->where('id', $search);
        }

        if($request->filled('status')) {
            $status = $request->get('status');
            $orders = $orders->where('status_id', $status);
        }

        if(!$request->has('status')) {
            $orders = $orders->whereIn('status_id', [1,2]);
        }

        if($request->filled('date')) {
            $date = $request->get('date');
            $orders = $orders->filter(function($order, $key) use ($date) {

              $datePeriod = now()->subDays(0);

              if($date == 'hoje') {
                  return $order->created_at > now()->setTime(0,0,0) &&
                  $order->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ontem') {
                  return $order->created_at > now()->subDays(1)->setTime(0,0,0) &&
                  $order->created_at < now()->subDays(1)->setTime(23,59,59);
              } elseif($date == 'semana') {
                  return $order->created_at > now()->subDays(7)->setTime(0,0,0) &&
                  $order->created_at < now()->setTime(23,59,59);
              } elseif($date == 'mes') {
                  return $order->created_at > now()->subDays(30)->setTime(0,0,0) &&
                  $order->created_at < now()->setTime(23,59,59);
              } elseif($date == 'ano') {
                  return $order->created_at > now()->subDays(365)->setTime(0,0,0) &&
                  $order->created_at < now()->setTime(23,59,59);
              } elseif($date == 'recente') {
                  return $order->created_at > now()->subHours(2)->setTime(0,0,0) &&
                  $order->created_at < now()->setTime(23,59,59);
              }

            });
        }

        if($request->filled('user')) {
            $user = $request->get('user');
            $orders = $orders->where('user_id', $user);
        }

        if($request->filled('client')) {
            $client = $request->get('client');
            $orders = $orders->where('client_id', $client);
        }

        //$orders = DeliveryOrder::all();
        return view('delivery-order.index', compact('orders'));
    }

    public function printTags($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);

        $user = $request->user();

        //echo route('start_delivery', $delivery->uuid);

        $titulo = "etiquetas-".str_random();

        $file = \Storage::disk('local')->path($user->avatar);

        return view('pdf.tags', compact('delivery', 'file'));

        //$pdf = PDF::loadView('pdf.tags', compact('delivery', 'file'));
        //return $pdf->stream($titulo. ".pdf");
    }

    public function start($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);

        if($delivery->status_id == Constants::STATUS_DELIVERY_PENDENTE) {

            $delivery->status_id = Constants::STATUS_DELIVERY_EM_TRANSITO;
            $delivery->save();

            $message = 'Ordem de Entrega nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' está em Transito.';

            $users = User::where('id', 2)->get();

            $subject = 'Ordem de Entrega';

            //dispatch(new DeliveryOrderJob($delivery, $subject, $message))->onQueue('emails');

            DeliveryOrderJob::dispatch($delivery, 'Ordem de Entrega', $message)->onQueue('emails');

            return view('delivery-order.scan-transit', compact('message'));

        } elseif($delivery->status_id == Constants::STATUS_DELIVERY_EM_TRANSITO) {

            $message = 'Para confirmar a entrega da Ordem de Entrega de nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' é preciso enviar o comprovante.';

            return view('delivery-order.scan-delivered', compact('message', 'delivery'));

        } else {
            return abort(404);
        }

    }

    public function receipt($id, Request $request)
    {
        $data = $request->request->all();

        $validator = Validator::make($request->all(), [
            'document' => 'required|image|mimes:jpeg,png,jpg|max:5024',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $delivery = DeliveryOrder::uuid($id);

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $path = $request->document->store('receipt');
            $delivery->receipt = $path;
            $delivery->status_id = Constants::STATUS_DELIVERY_ENTREGUE;
            $delivery->delivered_at = now();
            $delivery->save();
        }

        return redirect()->route('delivery_done', $delivery->uuid);
    }

    public function done($id, Request $request)
    {
        $delivery = DeliveryOrder::uuid($id);
        $message = 'A Ordem de Entrega nº: '. str_pad($delivery->id, 6, "0", STR_PAD_LEFT) .' foi entregue.';
        return view('delivery-order.scan-done', compact('message', 'delivery'));
    }

    public function getReceipt($id)
    {
        $delivery = DeliveryOrder::uuid($id);

        $link = $delivery->receipt;

        $file = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$file) {
          $file = null;
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
/*
        if(!$request->has('document')) {

          notify()->flash('Documento não informado!', 'error', [
            'text' => 'Um documento deve ser informado para a geração da Ordem de entrega.'
          ]);

          return back();
        }
*/
        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $delivers = People::where('occupation_id', $occupation->id)->get();

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $clients = Client::all();
        $addresses = $documents = [];

        if($request->has('client')) {
            $client = Client::uuid($request->get('client'));
            $documents = $client->documents->where('status_id', 1);
            $addresses = $client->addresses;
        } elseif($request->has('document')) {
            $documents = Document::whereIn('uuid', $data['document'])->get();
        }

        return view('delivery-order.create', compact('documents', 'delivers', 'clients', 'addresses'));
    }

    public function conference(Request $request)
    {
        if(!$request->has('document')) {

          notify()->flash('Documento não informado!', 'error', [
            'text' => 'Um documento deve ser informado para a geração da Ordem de entrega.'
          ]);

          return back();
        }

        $data = $request->request->all();

        if(count($data) == 1) {

          $document = Document::uuid(current($data['document']));
          $hasDocument = DeliveryOrderDocuments::where('document_id', $document->id)->get();

          if($hasDocument->isNotEmpty()) {

            $string = 'O documento ' . $document->description . ' já está vinculado à Ordem de Entrega n. '. $hasDocument->first()->id ?? '';

            notify()->flash('Falha ao adicionar documento!', 'error', [
              'text' => $string,
            ]);

            return back();

          }

        }

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $delivers = People::where('occupation_id', $occupation->id)->get();

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $documents = Document::whereIn('uuid', $data['document'])->get();
/*
        foreach ($documents as $key => $document) {
            if(!$document->address) {
              notify()->flash('Endereço não informado!', 'error', [
                'text' => 'O documento ' . $document->description . ' não possui endereço de entrega, e é obrigatória essa informação.'
              ]);

              return back();
            }
        }
*/
        return view('delivery-order.conference', compact('documents', 'delivers'));
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

        $deliverUuid = $data['delivered_by'];

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        $address = Address::uuid($data['address_id']);
        $data['address_id'] = $address->id;

        $documents = Document::whereIn('uuid', $data['documents'])->get();

        $documentsGroupedByClients = [];

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;

        foreach ($documents as $key => $document) {

            $hasDocument = DeliveryOrderDocuments::where('document_id', $document->id)->get();

            if($hasDocument->isNotEmpty()) {

              $string = 'O documento ' . $document->description . ' já está vinculado à Ordem de Entrega n. '. $hasDocument->first()->id ?? '';

              notify()->flash('Falha ao adicionar documento!', 'error', [
                'text' => $string,
              ]);

              return back();

            }

            $documentsGroupedByClients[$document->client->id][] = $document;
        }

        foreach ($documentsGroupedByClients as $keyClient => $documentsGroupedByClient) {

            $deliveryOrder = DeliveryOrder::create([
              'client_id' => $keyClient,
              'status_id' => 1,
              'delivered_by' => $data['delivered_by'],
              'address_id' => $data['address_id'],
              'annotations' => $data['annotations'],
              'delivery_date' => $deliveryDate,
            ]);

            foreach ($documentsGroupedByClient as $key => $document) {

                DeliveryOrderDocuments::create([
                  'document_id' => $document->id,
                  'delivery_order_id' => $deliveryOrder->id,
                  'delivery_date' => $deliveryDate,
                  'annotations' => $data['annotations'],
                  'user_id' => $request->user()->id
                ]);
                $document->status_id = 2;
                $document->save();
            }

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Ordem de Entrega Gerada com sucesso.'
        ]);

        return redirect()->route('delivery-order.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          $order = DeliveryOrder::uuid($id);
          return view('delivery-order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data = $request->request->all();

        $occupation = Occupation::where('name', 'Entregador')->get();

        if($occupation->isEmpty()) {
          notify()->flash('Cargo de Entregador não existe.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário criar o cargo Entregador.'
          ]);

          return back();
        }

        $occupation = $occupation->first();

        $delivers = People::where('occupation_id', $occupation->id)->get();

        if($delivers->isEmpty()) {
          notify()->flash('Nenhum usuário com o cargo de Entregador.', 'warning', [
            'text' => 'Para que a entrega possa ser realizada é necessário ao menos um usuário com o cargo de Entregador.'
          ]);

          return back();
        }

        $delivery = DeliveryOrder::uuid($id);

        $client = $delivery->client;

        $documents = $client->documents;
        $addresses = $client->addresses;

        return view('delivery-order.edit', compact('documents', 'delivers', 'delivery', 'addresses'));
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
        $data = $request->request->all();

        $deliverUuid = $data['delivered_by'];

        $deliver = People::uuid($deliverUuid);
        $data['delivered_by'] = $deliver->id;

        $documents = Document::whereIn('uuid', $data['documents'])->get();

        $deliveryOrder = DeliveryOrder::uuid($id);

        $deliveryDate = $data['delivery_date'] ? \DateTime::createFromFormat('d/m/Y', $data['delivery_date']) : null;

        $deliveryOrder->documents->map(function($document) {
            $document->document->status_id = 1;
            $document->document->save();
            $document->delete();
        });

        foreach ($documents as $key => $document) {

            DeliveryOrderDocuments::create([
              'document_id' => $document->id,
              'delivery_order_id' => $deliveryOrder->id,
              'delivery_date' => $deliveryDate,
              'annotations' => $data['annotations'],
              'user_id' => $request->user()->id
            ]);

            $document->status_id = 2;
            $document->save();
        }

        $deliveryOrder->update([
          'delivered_by' => $data['delivered_by'],
          'delivery_date' => $deliveryDate,
          'annotations' => $data['annotations']
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Ordem de Entrega Atualizada com sucesso.'
        ]);

        return redirect()->route('delivery-order.index');
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
