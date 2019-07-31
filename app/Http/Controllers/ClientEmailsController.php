<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Client\Email;

class ClientEmailsController extends Controller
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
        return view('clients.emails.create', compact('client'));
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

        Email::create([
          'client_id' => $client->id,
          'email' => $data['email'],
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo E-mail adicionado ao Cliente com sucesso.'
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
        $email = Email::uuid($id);
        return view('clients.emails.edit', compact('email'));
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
        $email = Email::uuid($id);

        $data = $request->request->all();

        $email->update([
          'email' => $data['email']
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'E-mail atualizado com sucesso.'
        ]);

        return redirect()->route('clients.show', $email->client->uuid);
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

          $email = Email::uuid($id);
          $email->delete();

          return response()->json([
            'success' => true,
            'message' => 'E-mail removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado'
          ]);
        }
    }
}
