<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Helpers\Helper;
use Auth;

class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermission('view.menus')) {
            return abort(403, 'Acesso negado.');
        }

        $menus = Menu::where('parent', null)->get();
        return view('menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermission('create.menus')) {
            return abort(403, 'Acesso negado.');
        }

        $permissions = Permission::all();
        $menus = Menu::all();
        return view('menus.create', compact('menus', 'permissions'));
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

        $menu = Menu::create($data);

        Helper::drop('menus');

        notify()->flash('Novo Item Adicionado ao Menu!', 'success', [
          'text' => 'Novo Item Adicionado ao Menu com sucesso.'
        ]);

        return redirect()->route('menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->hasPermission('view.menus')) {
            return abort(403, 'Acesso negado.');
        }

        $menu = Menu::find($id);
        return view('menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermission('edit.menus')) {
            return abort(403, 'Acesso negado.');
        }

        $menu = Menu::find($id);
        $permissions = Permission::all();
        $menus = Menu::all();
        return view('menus.edit', compact('menu', 'menus', 'permissions'));
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

        $menu = Menu::find($id);
        $menu->update($data);

        Helper::drop('menus');

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Auth::user()->hasPermission('delete.menus')) {
            return abort(403, 'Acesso negado.');
        }
    }
}
