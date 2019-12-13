<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Brand;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        return view('stock.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.brands.create');
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

        $data['active'] = $request->has('active');

        Brand::create($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Nova Marca adicionada.'
        ]);

        return redirect()->route('brands.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::uuid($id);
        return view('stock.brands.edit', compact('brand'));
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

        $brand = Brand::uuid($id);
        $brand->update($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Marca atualizada com sucesso.'
        ]);

        return redirect()->route('brands.index');
    }
}
