<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client\Occupation;
use App\Models\Client;
use Auth;

class ClientOccupationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $occupations = Occupation::all();

        if(!Auth::user()->hasPermission('view.funcoes')) {
            return abort(403, 'Acesso negado.');
        }

        $quantity = 0;
        $occupations = [];

        if($request->get('find')) {

          $occupations = Occupation::orderBy('name');

          if($request->filled('search')) {

            $search = $request->get('search');

            $occupations->where('id', $search)
            ->orWhere('name', 'like', "%$search%");

          }

          if($request->filled('client')) {
            $client = Client::uuid($request->get('client'));
            $occupations->where('client_id', $client->id);
          }

          $quantity = $occupations->count();
          $occupations = $occupations->paginate();

          foreach ($request->all() as $key => $value) {
              $occupations->appends($key, $value);
          }

        }

        return view('clients.occupations.index', compact('occupations', 'quantity'));
    }

    public function search(Request $request)
    {
        if(!$request->filled('search')) {}

        $search = $request->get('search');

        $occupations = Occupation::where('id', $search)
        ->orWhere('name', 'like', "%$search%")
        ->get();

        $result = [];

        $result = $occupations->map(function($occupation) {
            return [
              'id' => $occupation->uuid,
              'name' => $occupation->name
            ];
        });

        return json_encode($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.occupations.create');
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

        Occupation::updateOrCreate([
          'name' => $data['name'],
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo cargo adicionado com sucesso.'
        ]);

        return redirect()->route('client-occupations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $occupation = Occupation::uuid($id);
        return view('clients.occupations.edit', compact('occupation'));
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

        $occupation = Occupation::uuid($id);
        $occupation->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Cargo atualizado com sucesso.'
        ]);

        return redirect()->route('client-occupations.index');
    }
}
