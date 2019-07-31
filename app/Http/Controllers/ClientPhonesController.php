<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Client\Phone;

class ClientPhonesController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $client = $request->get('client');
        $client = Client::uuid($client);
        return view('clients.phones.create', compact('client'));
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

        $client = Client::uuid($data['client_id']);

        Phone::create([
          'client_id' => $client->id,
          'number' => $data['phone'],
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Telefone adicionado ao Cliente com sucesso.'
        ]);

        return redirect()->route('clients.show', $client->uuid);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phone = Phone::uuid($id);
        return view('clients.phones.edit', compact('phone'));
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
        $phone = Phone::uuid($id);

        $data = $request->request->all();

        $phone->update([
          'number' => $data['number']
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Telefone atualizado com sucesso.'
        ]);

        return redirect()->route('clients.show', $phone->client->uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

          $phone = Phone::uuid($id);
          $phone->delete();

          return response()->json([
            'success' => true,
            'message' => 'Telefone removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado'
          ]);
        }
    }
}
