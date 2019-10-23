<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder\ServiceOrder;
use App\Models\ServiceOrder\ServiceOrder\Log as ServiceOrderLog;
use App\Models\ServiceOrder\Service;
use App\Models\ServiceOrder\ServiceOrder\{Item as ServiceOrderItem, Address as ServiceOrderAddress};
use App\Models\Client;
use App\Models\Client\{Address, Employee};
use App\Models\ServiceOrder\ServiceOrder\Ticket as ServiceOrderTicket;
use App\Models\ServiceOrder\ServiceOrder\Training\Course as ServiceOrderTrainingCourse;
use App\Helpers\Helper;
use PDF;

class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = ServiceOrder::orderByDesc('id');

        if($request->filled('search')) {
          $search = $request->get('search');
          $services->where('id', $search)
          ->orWhere('name', 'like', "%$search%")
          ->orWhere('description', 'like', "%$search%");
        }

        if($request->filled('service_type_id')) {
            $services->where('service_type_id', $request->get('service_type_id'));
        }

        $quantity = $services->count();
        $services = $services->paginate();
        return view('service-order.index', compact('services', 'quantity'));
    }

    public function email($id, Request $request)
    {
        $order = ServiceOrder::uuid($id);
        return view('service-order.email', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::where('active', true)->orderBy('service_type_id')->get();
        return view('service-order.create', compact('services'));
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

        if(!$request->has('contract_id')) {
            abort(403, 'Error');
        }

        if(!$request->has('client')) {
            abort(403, 'Error');
        }

        $client = Client::uuid($request->get('client'));
        $data['client_id'] = $client->id;
        $data['status_id'] = 1;

        $serviceOrder = ServiceOrder::create($data);

        ServiceOrderLog::create([
          'message' => 'Ordem de Serviço Criada',
          'service_order_id' => $serviceOrder->id,
          'status_id' => 1,
          'user_id' => $user->id
        ]);

        $services = $data['services'];

        foreach ($services as $key => $service) {
            $service = Service::uuid($service);

            ServiceOrderItem::create([
              'service_id' => $service->id,
              'service_order_id' => $serviceOrder->id,
              'status_id' => 1
            ]);

            foreach ($service->ticketTypes as $key => $ticketType) {
                ServiceOrderTicket::create([
                    'service_order_id' => $serviceOrder->id,
                    'ticket_type_id' => $ticketType->type->id,
                ]);
            }

            foreach ($service->courses as $key => $trainingCourse) {
                ServiceOrderTrainingCourse::create([
                    'service_order_id' => $serviceOrder->id,
                    'course_id' => $trainingCourse->course->id,
                ]);
            }

        }

        $addresses = $data['addresses'];

        foreach ($addresses as $key => $address) {
            $address = Address::uuid($address);
            ServiceOrderAddress::create([
              'service_order_id' => $serviceOrder->id,
              'client_id' => $client->id,
              'address_id' => $address->id,
            ]);
        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Ordem de Serviço adicionada com sucesso.'
        ]);

        return redirect()->route('service-order.show', $serviceOrder->uuid);
    }

    public function contract($id)
    {
        $order = ServiceOrder::uuid($id);
        return view('service-order.contract-1', compact('order'));
    }

    public function receipt($id, Request $request)
    {
        $order = ServiceOrder::uuid($id);
        $user = $request->user();

        $id = str_pad($order->id, 6, "0", STR_PAD_LEFT);
        $title = "OS:$id:" . $order->client->name;

        $pdf = PDF::loadView('service-order.receipt', compact('order'));

        return $pdf->stream($title. ".pdf");

        //return view('service-order.receipt', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $order = ServiceOrder::uuid($id);
        $user = $request->user();

        if($order->status_id == 1) {
            $order->status_id = 3;
            $order->save();

            ServiceOrderLog::create([
              'message' => 'Ordem de Serviço Em Elaboração',
              'service_order_id' => $order->id,
              'status_id' => 1,
              'user_id' => $user->id
            ]);

        }

        return view('service-order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = ServiceOrder::uuid($id);
        $services = Service::where('active', true)->orderBy('service_type_id')->get();
        return view('service-order.edit', compact('order', 'services'));
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
        $user = $request->user();

        if(!$request->has('contract_id')) {

            notify()->flash('Error', 'error', [
              'text' => 'Tipo de Contrado não informado.'
            ]);

            return back();
        }

        if(!$request->has('client')) {

            notify()->flash('Error', 'error', [
              'text' => 'Cliente não informado.'
            ]);

            return back();
        }

        $client = Client::uuid($request->get('client'));
        $data['client_id'] = $client->id;

        $data['status_id'] = 1;
        $data['contact_id'] = null;

        if($request->filled('contact_id')) {
          $employee = Employee::uuid($request->get('contact_id'));
          $data['contact_id'] = $employee->id;
        }

        $serviceOrder = ServiceOrder::uuid($id);
        $serviceOrder->update($data);

        $services = $data['services'];
        $addresses = $data['addresses'];

        $serviceOrder->services->map(function($service) use($services) {
            if(!in_array($service->service->uuid, $services)) {
                $service->delete();
            }
        });

        $serviceOrder->addresses->map(function($address) use($addresses) {
            if(!in_array($address->address->uuid, $addresses)) {
                $address->delete();
            }
        });

        foreach ($addresses as $key => $address) {

            $address = Address::uuid($address);

            $serviceOrderAddress = ServiceOrderAddress::where('address_id', $address->id)
                  ->where('service_order_id', $serviceOrder->id)
                  ->first();

            if(!$serviceOrderAddress) {

              ServiceOrderAddress::create([
                'service_order_id' => $serviceOrder->id,
                'client_id' => $client->id,
                'address_id' => $address->id,
              ]);

            } else {

              $serviceOrderAddress->update([
                'address_id' => $address->id,
                'service_order_id' => $serviceOrder->id,
              ]);

            }


        }

        foreach ($services as $key => $service) {

            $service = Service::uuid($service);

            $serviceOrder->tickets->map(function($ticket) use($service) {
                if(!in_array($ticket->ticket_type_id, $service->ticketTypes->pluck('ticket_type_id')->toArray())) {
                    $ticket->delete();
                }
            });

            $serviceOrder->courses->map(function($course) use($service) {
                if(!in_array($course->course_id, $service->courses->pluck('course_id')->toArray())) {
                    $course->delete();
                }
            });

            foreach ($service->ticketTypes as $key => $ticketType) {
                ServiceOrderTicket::updateOrCreate([
                    'service_order_id' => $serviceOrder->id,
                    'ticket_type_id' => $ticketType->type->id,
                ]);
            }

            foreach ($service->courses as $key => $trainingCourse) {
                ServiceOrderTrainingCourse::updateOrCreate([
                    'service_order_id' => $serviceOrder->id,
                    'course_id' => $trainingCourse->course->id,
                ]);
            }

            $originalValue = 0.00;

            $serviceValues = $service->values
                ->where('contract_id', $data['contract_id'])
                ->where('active', true)
                ->first();

            if($serviceValues) {
                $originalValue = $serviceValues->value;
            }

            $serviceOrderItem = ServiceOrderItem::where('service_id', $service->id)
                  ->where('service_order_id', $serviceOrder->id)
                  ->first();

            if(!$serviceOrderItem) {

              ServiceOrderItem::create([
                'service_id' => $service->id,
                'service_order_id' => $serviceOrder->id,
                'original_value' => $originalValue,
                'value' => $originalValue,
                'status_id' => 1
              ]);

            } else {

              $serviceOrderItem->update([
                'service_id' => $service->id,
                'service_order_id' => $serviceOrder->id,
                'original_value' => $originalValue,
                'value' => $originalValue,
              ]);

            }


        }

        ServiceOrderLog::create([
          'message' => 'Ordem de Serviço Atualizada',
          'service_order_id' => $serviceOrder->id,
          'status_id' => $serviceOrder->status_id,
          'user_id' => $user->id
        ]);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Ordem de Serviço atualizada com sucesso.'
        ]);

        return redirect()->route('service-order.show', $serviceOrder->uuid);
    }

    public function updateByAjax(Request $request, $id)
    {
        $data = $request->request->all();
        $user = $request->user();

        try {

            $serviceOrder = ServiceOrder::uuid($id);

            $name = $data['name'];
            $value = $data['value'];
            $type = $data['type'];

            if($value == null) {

              $serviceOrder->{$name} = null;

            } elseif ($type == 'date') {

              $date = \DateTime::createFromFormat('d/m/Y', $value);
              $serviceOrder->{$name} = $date;

            } elseif ($type == 'money') {

              $value = Helper::brl2decimal($value);
              $serviceOrder->{$name} = $value;

            } elseif ($type == 'boolean') {

              $serviceOrder->{$name} = (boolean)!$serviceOrder->{$name};

            } else {

              $serviceOrder->{$name} = $value;

            }

            $serviceOrder->save();

            ServiceOrderLog::create([
              'message' => 'Ordem de Serviço Atualizada: ' . $name . ':' . $value,
              'service_order_id' => $serviceOrder->id,
              'status_id' => $serviceOrder->status_id,
              'user_id' => $user->id
            ]);

            return response()->json([
              'success' => true,
              'message' => 'OS atualizada com sucesso.',
            ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado.',
          ]);

        }

    }

    public function updateItemByAjax(Request $request, $id)
    {
        $data = $request->request->all();
        $user = $request->user();

        try {

            $serviceOrderItem = ServiceOrderItem::uuid($id);

            $name = $data['name'];
            $value = $data['value'];
            $type = $data['type'];

            if($value == null) {

              $serviceOrderItem->{$name} = null;

            } elseif ($type == 'date') {

              $date = \DateTime::createFromFormat('d/m/Y', $value);
              $serviceOrderItem->{$name} = $date;

            } elseif ($type == 'money') {

              $value = Helper::brl2decimal($value);
              $serviceOrderItem->{$name} = $value;

            } elseif ($type == 'boolean') {

              $serviceOrderItem->{$name} = (boolean)!$serviceOrderItem->{$name};

            } else {

              $serviceOrderItem->{$name} = $value;

            }

            $serviceOrderItem->save();

            return response()->json([
              'success' => true,
              'message' => 'Item atualizado com sucesso.',
            ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado.',
          ]);

        }

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
