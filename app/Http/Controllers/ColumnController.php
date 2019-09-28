<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report\{Column, Format, Table};

class ColumnController extends Controller
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

    public function status($id)
    {
        $column = Column::uuid($id);
        $column->show = !$column->show;
        $column->save();

        return response()->json([
          'message' => 'Status Alterado',
          'data' => $column
        ]);
    }

    public function setFormat($id, Request $request)
    {
        $data = $request->request->all();

        $column = Column::uuid($id);
        $format = Format::find($data['format']);

        $column->format_id = $format->id;
        $column->save();

        return response()->json([
          'message' => 'Formato Adicionado',
          'data' => $format
        ]);
    }

    public function setLabel($id, Request $request)
    {
        $data = $request->request->all();

        $column = Column::uuid($id);

        $column->label = $data['label'];
        $column->save();

        return response()->json([
          'message' => 'Label Adicionado',
          'data' => $column
        ]);
    }

    public function addLabel($id, Request $request)
    {
        $data = $request->request->all();

        $column = Column::uuid($id);

        $column->is_label = !$column->is_label;
        $column->save();

        return response()->json([
          'message' => 'Label Adicionado',
          'data' => $column
        ]);
    }

    public function setTableReference($id, Request $request)
    {
        $data = $request->request->all();

        $column = Column::uuid($id);
        $table = Table::uuid($data['table_reference']);

        $column->table_reference_id = $table->id;
        $column->save();

        return response()->json([
          'message' => 'Referencia Adicionada',
          'data' => $column
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
