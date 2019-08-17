<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchasing;
use App\Models\Purchasing\Item;

class PurchasingItemsController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->has('purchasing_id')) {
          notify()->flash('Erro', 'error', [
            'text' => 'Pedido de Compra não informado.'
          ]);

          return back();
        }

        $purchasing = Purchasing::uuid($request->get('purchasing_id'));

        return view('purchasing.items.create', compact('purchasing'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->has('purchasing_id')) {
          notify()->flash('Erro', 'error', [
            'text' => 'Pedido de Compra não informado.'
          ]);

          return back();
        }

        if(!$request->filled('indexes')) {

          notify()->flash('Erro', 'error', [
            'text' => 'Nenhum item informado.'
          ]);

          return back();

        }

        $data = $request->request->all();
        $user = $request->user();

        $id = $request->get('purchasing_id');

        $purchasing = Purchasing::uuid($id);

        $indexes = $data['indexes'];

        foreach (range(0, $indexes) as $key => $value) {

              $fieldUnit = 'unit-'.$value;
              $fieldDesc = 'description-'.$value;
              $fieldQuant = 'quantity-'.$value;

              if($request->has($fieldUnit)) {

                  Item::create([
                    'purchasing_id' => $purchasing->id,
                    'quantity' => $request->get($fieldQuant),
                    'unit' => $request->get($fieldUnit),
                    'description' => $request->get($fieldDesc),
                    'user_id' => $user->id,
                  ]);

              }

            }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Item adicionado ao Pedido de Compra com sucesso.'
        ]);

        return redirect()->route('purchasing.show', $purchasing->uuid);
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
        $purchasing = Item::uuid($id);
        return view('purchasing.items.edit', compact('purchasing'));
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
        $purchasing = Item::uuid($id);
        $purchasing->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Item do Pedido de Compra aatualizado com sucesso.'
        ]);

        return redirect()->route('purchasing.show', $purchasing->purchasing->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $item = Item::uuid($id);
            $item->delete();

            return response()->json([
              'success' => true,
              'message' => 'Item removido do Pedido de Compra com sucesso.'
            ]);

        } catch(\Exception $e) {
            return response()->json([
              'success' => false,
              'message' => 'Ocorreu um erro inesperado.'
            ]);
        }
    }
}
