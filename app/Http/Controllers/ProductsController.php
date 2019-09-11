<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock\Product;
use App\Models\Stock\Stock;
use App\Models\Stock\Stock\Log;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $quantity = 0;
        $products = [];

        if($request->get('find')) {

          $products = Product::orderBy('name');

          if($request->filled('search')) {

            $search = $request->get('search');

            $products->where('id', $search)
            ->orWhere('name', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orWhereHas('stocks', function($query) use($search) {
                $query->where('equity_registration_code', $search);
                $query->orWhere('serial', $search);
            });

          }

          if($request->filled('type')) {
            $products->where('type_id', $request->get('type'));
          }

          if($request->filled('status')) {
            $status = $request->get('status');
            $products->whereHas('stocks', function($query) use($status) {
                $query->where('status', $status);
            });
          }

          if($request->filled('localization')) {
            $localization = $request->get('localization');
            $products->whereHas('stocks', function($query) use($localization) {
                $query->where('localization', $localization);
            });
          }

          $quantity = $products->count();
          $products = $products->paginate();

          foreach ($request->all() as $key => $value) {
              $products->appends($key, $value);
          }

        }

        return view('stock.products.index', compact('products', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('stock.products.create');
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

        $product = Product::create($data);

        foreach (range(1, $data['actual_stock']) as $key => $item) {
            $stock = Stock::create([
              'product_id' => $product->id,
              'status' => 'Disponível',
              'localization' => 'Almoxarifado'
            ]);

            Log::create(
              [
                'stock_id' => $stock->id,
                'user_id' => $user->id,
                'message' => 'Item adicionado.'
              ]
            );
        }

        notify()->flash('Sucesso', 'success', [
          'text' => 'Novo Produto adicionado.'
        ]);

        return redirect()->route('products.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::uuid($id);
        return view('stock.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::uuid($id);
        return view('stock.products.edit', compact('product'));
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

        $product = Product::uuid($id);
        $product->update($data);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Produto atualizado com sucesso.'
        ]);

        return redirect()->route('products.show', $product->uuid);
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
