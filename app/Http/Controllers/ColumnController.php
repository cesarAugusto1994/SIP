<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report\{Column, Format, Table};

class ColumnController extends Controller
{
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
}
