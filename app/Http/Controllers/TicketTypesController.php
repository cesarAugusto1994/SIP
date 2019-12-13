<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket\Type;
use App\Models\Ticket\Type\Department;
use App\Helpers\Helper;

class TicketTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Helper::TicketType();
        return view('tickets.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.types.create');
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

        $type = Type::create($data);

        if($request->has('departments')) {

          $depts = $request->get('departments');

          foreach ($depts as $key => $dept) {
              Department::create([
                'type_id' => $type->id,
                'department_id' => $dept
              ]);
          }
        }

        Helper::drop('ticket-types');

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Tipo de chamado adicionado com sucesso.'
        ]);

        return redirect()->route('ticket-types.index');
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
        return view('tickets.types.edit', compact('type'));
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

        if($request->has('departments')) {

          $type->departments->map(function($department) {
              $department->delete();
          });

          $depts = $request->get('departments');

          foreach ($depts as $key => $dept) {
              Department::create([
                'type_id' => $type->id,
                'department_id' => $dept
              ]);
          }
        }

        Helper::drop('ticket-types');

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Tipo de chamado atualizado com sucesso.'
        ]);

        return redirect()->route('ticket-types.index');
    }
}
