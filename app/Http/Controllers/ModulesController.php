<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use jeremykenedy\LaravelRoles\Models\Permission;

class ModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::where('parent', 1)->get();
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::where('parent', 1)->get();
        return view('modules.create', compact('modules'));
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

        $data['slug'] = str_slug($data['name']);

        $module = Module::create($data);

        $slugView = 'view.' . str_slug($module->name);
        $slugCreate = 'create.' . str_slug($module->name);
        $slugEdit = 'edit.' . str_slug($module->name);
        $slugDelete = 'delete.' . str_slug($module->name);

        if ($request->has('show') && Permission::where('slug', '=', $slugView)->first() === null) {
            Permission::create([
                'name'        => 'Visualizar ' . $module->name,
                'slug'        => $slugView,
                'description' => 'Pode Visualizar ' . $module->name,
                'model'       => '',
                'module_id'   => $module->id,
            ]);
        }

        if ($request->has('create') && Permission::where('slug', '=', $slugCreate)->first() === null) {
            Permission::create([
                'name'        => 'Criar ' . $module->name,
                'slug'        =>  $slugCreate,
                'description' => 'Pode Adicionar ' . $module->name,
                'model'       => '',
                'module_id'   => $module->id,
            ]);
        }

        if ($request->has('edit') && Permission::where('slug', '=', $slugEdit)->first() === null) {
            Permission::create([
                'name'        => 'Editar ' . $module->name,
                'slug'        => $slugEdit,
                'description' => 'Pode Editar ' . $module->name,
                'model'       => '',
                'module_id'   => $module->id,
            ]);
        }

        if ($request->has('delete') && Permission::where('slug', '=', $slugDelete)->first() === null) {
            Permission::create([
                'name'        => 'Deletar ' . $module->name,
                'slug'        => $slugDelete,
                'description' => 'Pode Deletar ' . $module->name,
                'model'       => '',
                'module_id'   => $module->id,
            ]);
        }

        return redirect()->route('modules.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::find($id);
        return view('modules.permissions', compact('module'));
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
