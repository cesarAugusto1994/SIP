<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket\Type\Category;
use App\Helpers\Helper;

class TicketTypeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('tickets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.categories.create');
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

        $category = Category::create($data);

        Helper::drop('ticket-categories');

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Nova Categoria de chamado adicionada com sucesso.'
        ]);

        return redirect()->route('ticket-type-categories.index');
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
        $category = Category::uuid($id);
        return view('tickets.categories.edit', compact('category'));
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

        $category = Category::uuid($id);
        $category->update($data);

        Helper::drop('ticket-categories');

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Categoria de chamado atualizada com sucesso.'
        ]);

        return redirect()->route('ticket-type-categories.index');
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
