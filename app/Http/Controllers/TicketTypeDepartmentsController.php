<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket\Type\Department;
use App\Models\Ticket\Type;
use App\Models\Department as Dpto;

class TicketTypeDepartmentsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $typeId = $request->get('type_id');

        $type = Type::uuid($typeId);

        $listDeptsAdded = $type->departments->pluck('department_id')->toArray();

        return view('tickets.departments.create', compact('type', 'listDeptsAdded'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = Type::uuid($id);
        return view('tickets.departments.index', compact('type'));
    }
}
