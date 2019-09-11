<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Product\Type;
use App\Helpers\Helper;

class ProductTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        return view('stock.products.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.products.types.create');
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

        Type::create($data);

        Helper::drop('product-types');

        notify()->flash('Sucesso', 'success', [
          'text' => 'Novo Tipo de Produto adicionado com sucesso'
        ]);

        return redirect()->route('product-types.index');
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
        $type = Type::uuid($id);
        return view('stock.products.types.edit', compact('type'));
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

        $type = Type::uuid($id);
        $type->update($data);

        Helper::drop('product-types');

        notify()->flash('Sucesso', 'success', [
          'text' => 'Tipo de Produto atualizado com sucesso'
        ]);

        return redirect()->route('product-types.index');
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
