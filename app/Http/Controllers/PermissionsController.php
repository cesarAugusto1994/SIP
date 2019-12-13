<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Module;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions=Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $modules = Module::all();
        $module = $request->get('module');
        return view('permissions.create', compact('modules', 'module'));
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

        $module = Module::find($request->get('module_id'));

        $name = $request->get('name');
        $slug = str_slug($request->get('slug'), '.');
        $description = $request->get('description');

        if (Permission::where('slug', '=', $slug)->first() !== null) {

            notify()->flash('Erro', 'error', [
              'text' => 'Permissão já adicionada.'
            ]);

            return back();
        }

        Permission::create([
            'name'        => $name,
            'slug'        => $slug,
            'description' => $description,
            'module_id'   => $module->id,
        ]);

        notify()->flash('Sucesso', 'success', [
          'text' => 'Permissão adicionada com sucesso.'
        ]);

        if($request->has('redirect')) {
            return redirect($request->get('redirect'));
        }

        return redirect()->route('permissions.index');
    }
}
