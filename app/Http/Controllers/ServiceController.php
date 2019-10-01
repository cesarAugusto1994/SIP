<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceOrder\Service;
use App\Models\ServiceOrder\Service\Value as ServiceValue;
use App\Models\{Contract};

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = Service::orderBy('name');

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
        return view('service-order.service.index', compact('services', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('service-order.service.create');
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

        $service = Service::create($data);

        $contracts = Contract::all();

        foreach ($contracts as $key => $contract) {

            $slug = 'value-'.$contract->uuid;
            $slugCost = 'cost-'.$contract->uuid;

            if($request->has($slug) && $request->has($slugCost)) {

                $value = $request->get($slug);
                if($value) {
                    $value = \App\Helpers\Helper::brl2decimal($value);
                }

                $cost = $request->get($slugCost);
                if($cost) {
                  $cost = \App\Helpers\Helper::brl2decimal($cost);
                }

                ServiceValue::create([
                  'service_id' => $service->id,
                  'value' => $value ?: 0.00,
                  'cost' => $cost ?: 0.00,
                  'contract_id' => $contract->id,
                ]);
            }
        }

        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::uuid($id);
        $values = $service->values->where('active', true);
        return view('service-order.service.show', compact('service', 'values'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::uuid($id);
        $values = $service->values->where('active', true);
        return view('service-order.service.edit', compact('service', 'values'));
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

        $data['active'] = $request->has('active');

        $service = Service::uuid($id);
        $service->update($data);

        $contracts = Contract::all();

        foreach ($contracts as $key => $contract) {

            $slug = 'value-'.$contract->uuid;
            $slugCost = 'cost-'.$contract->uuid;

            if($request->has($slug)) {

                $value = $request->get($slug);
                $cost = $request->get($slugCost);

                if(!empty($value) && !empty($cost)) {
                  $value = \App\Helpers\Helper::brl2decimal($value);
                  $cost = \App\Helpers\Helper::brl2decimal($cost);
                } else {
                  $cost = $value = 0.00;
                }

                $serviceValues = $service->values->where('id', $contract->id)
                  ->where('active', true);

                  foreach ($serviceValues as $key => $serviceValue) {

                      $serviceValue->value = $value ?: 0.00;
                      $serviceValue->cost = $cost ?: 0.00;
                      $serviceValue->save();

                  }

            }
        }

        return redirect()->route('services.show', $service->uuid);
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
