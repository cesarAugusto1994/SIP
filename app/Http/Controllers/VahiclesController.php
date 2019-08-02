<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet\Vehicle;

class VahiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('fleet.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fleet.vehicles.create');
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

        if($request->filled('bought_at')) {
            $data['bought_at'] = \DateTime::createFromFormat('d/m/Y', $data['bought_at']);
        }

        if($request->filled('last_maintenance')) {
            $data['last_maintenance'] = \DateTime::createFromFormat('d/m/Y', $data['last_maintenance']);
        }

        $data['active'] = $request->has('active');

        Vehicle::create($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Veículo adicionado com sucesso.'
        ]);

        return redirect()->route('vehicles.index');
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
        $vehicle = Vehicle::uuid($id);
        return view('fleet.vehicles.edit', compact('vehicle'));
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

        if($request->filled('bought_at')) {
            $data['bought_at'] = \DateTime::createFromFormat('d/m/Y', $data['bought_at']);
        }

        if($request->filled('last_maintenance')) {
            $data['last_maintenance'] = \DateTime::createFromFormat('d/m/Y', $data['last_maintenance']);
        }

        $data['active'] = $request->has('active');

        $vehicle = Vehicle::uuid($id);
        $vehicle->update($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Veículo atualizado com sucesso.'
        ]);

        return redirect()->route('vehicles.index');
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
