<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchasing;
use App\Models\Purchasing\Item;

class PurchasingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $purchasings = Purchasing::orderByDesc('id');

        if($request->filled('status')) {
            $purchasings->where('status', $request->get('status'));
        }

        if($request->filled('start')) {
            $start = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
            $purchasings->where('created_at', '>=', $start->format('Y-m-d') . ' 00:00:00');
        }

        if($request->filled('end')) {
            $end = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
            $purchasings->where('created_at', '<=', $end->format('Y-m-d') . ' 23:59:59');
        }

        if($request->filled('user')) {
            $purchasings->where('user_id', $request->get('user'));
        }

        $quantity = $purchasings->count();

        $purchasings = $purchasings->paginate();

        foreach ($request->all() as $key => $value) {
            $purchasings->appends($key, $value);
        }
        return view('purchasing.index', compact('purchasings', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchasing.create');
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

        $data['user_id'] = $user->id;

        $purchasing = Purchasing::create($data);

        if($request->has('indexes')) {

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

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Pedido de Compra adicionado com sucesso.'
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
        $purchasing = Purchasing::uuid($id);
        return view('purchasing.show', compact('purchasing'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchasing = Purchasing::uuid($id);
        return view('purchasing.edit', compact('purchasing'));
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

        $purchasing = Purchasing::uuid($id);
        $purchasing->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Pedido de Compra atualizado com sucesso.'
        ]);

        return redirect()->route('purchasing.show', $purchasing->uuid);
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

            $purchasing = Purchasing::uuid($id);

            $purchasing->items()->delete();

            $purchasing->delete();

            return response()->json([
              'success' => true,
              'message' => 'Pedido de Compra removido com sucesso.'
            ]);

        } catch(\Exception $e) {
            return response()->json([
              'success' => false,
              'message' => 'Ocorreu um erro inesperado.'
            ]);
        }
    }
}
