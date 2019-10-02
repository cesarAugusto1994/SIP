<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder\ServiceOrder;
use App\Models\ServiceOrder\Service;
use App\Models\ServiceOrder\ServiceOrder\Item as ServiceOrderItem;
use App\Models\Client;

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

        $services = $data['services'];

        foreach ($services as $key => $service) {
            $service = Service::uuid($service);

            ServiceOrderItem::create([
              'service_id' => $service->id,
              'service_order_id' => $serviceOrder->id,
            ]);
        }

        return redirect()->route('service-order.index');
    }

    public function contract($id)
    {
        $order = ServiceOrder::uuid($id);
        return view('service-order.contract-1', compact('order'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
