<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Client\Address;
use GuzzleHttp\Client as GuzzleClient;
use Auth;

class AddressesController extends Controller
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

    public function search(Request $request)
    {
        if(!$request->has('search')) {
          return response()->json('Nenhum paramentro de busca foi informado.');
        }

        $client = null;

        $search = $request->get('search');

        $addresses = Address::where('id', $search)
        ->orWhere('description', 'like', "%$search%")
        ->orWhere('zip', 'like', "%$search%")
        ->orWhere('street', 'like', "%$search%");

        if($request->filled('client')) {
            $client = Client::uuid($request->get('client'));
            $addresses->where('client_id', $client->id);
        }

        $addresses = $addresses->get();

        $result = [];

        $result = $addresses->map(function($address) {

            $formated = $address->description . ' - ' . $address->street . ', ' . $address->number . ', ' . $address->district . ' - ' . $address->city . ' / ' . $address->state . ' - ' . $address->zip;

            return [
              'id' => $address->uuid,
              'address' => $formated,
            ];
        });

        return json_encode($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!Auth::user()->hasPermission('create.cliente.enderecos')) {
            return abort(403, 'Unauthorized action.');
        }

        $client = Client::uuid($id);
        return view('clients.addresses.create', compact('client'));
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
        $user = $request->user();

        $client = Client::uuid($data['client_id']);
        $data['client_id'] = $client->id;
        $data['user_id'] = $user->id;
        $data['is_default'] = $request->has('is_default');

        Address::create($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O Endereço do Cliente foi adicionado com sucesso.'
        ]);

        return redirect()->route('clients.show', $client->uuid);
    }

    public function storeWithoutClientId(Request $request)
    {
        $data = $request->request->all();
        $user = $request->user();

        if(!$request->has('client_id')) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Cliente não informado.'
          ]);

          return back();
        }

        $id = $data['client_id'];

        $client = Client::uuid($id);
        $data['client_id'] = $client->id;
        $data['user_id'] = $user->id;
        $data['is_default'] = $request->has('is_default');

        Address::create($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O Endereço do Cliente foi adicionado com sucesso.'
        ]);

        return redirect()->route('clients.show', $client->uuid);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!Auth::user()->hasPermission('view.cliente.enderecos')) {
            return abort(403, 'Unauthorized action.');
        }

        $client = Client::uuid($id);
        return view('clients.addresses.index', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $address)
    {
        $address = Address::uuid($address);
        $client = $address->client;
        return view('clients.addresses.edit', compact('client', 'address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $address)
    {
        $data = $request->request->all();

        $address = Address::uuid($address);

        $data['is_default'] = $request->has('is_default');

        $address->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'O Endereço do Cliente foi atualizado com sucesso.'
        ]);

        return redirect()->route('clients.show', $id);

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

          $address = Address::uuid($id);
          $address->delete();

          return response()->json([
            'success' => true,
            'message' => 'Endereço removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function importJson()
    {
        $client = new GuzzleClient([
          'handler' => new \GuzzleHttp\Handler\CurlHandler(),
        ]);
        $response = $client->get('https://www.soc.com.br/WebSoc/exportadados?parametro={%27empresa%27:%27235164%27,%27codigo%27:%2719951%27,%27chave%27:%2753f97ed9b98ef2c4f476%27,%27tipoSaida%27:%27json%27,%27ativo%27:%271%27}');

        $contents = $response->getBody()->getContents();

        $response = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $contents), true);

        if(!$response) {
            return response()->json('Ocorreu um erro.');
        }

        foreach ($response as $key => $item) {

          $client = Client::where('code', $item['CODIGOEMPRESA'])->first();

          if($client) {

            if(!$item['CEP']) {
              continue;
            }

            $hasAddress = Address::where('street', $item['ENDERECO'])->where('number', $item['NUMEROENDERECO'])->where('zip', $item['CEP'])->first();

            if($hasAddress) {
                continue;
            }

            $data['client_id'] = $client->id;
            $data['user_id'] = 1;
            $data['is_default'] = false;

            $data['description'] = $item['NOMEUNIDADE'];
            $data['street'] = $item['ENDERECO'];
            $data['number'] = $item['NUMEROENDERECO'];
            $data['complement'] = $item['COMPLEMENTO'];
            $data['district'] = $item['BAIRRO'];
            $data['city'] = $item['CIDADE'];
            $data['state'] = $item['UF'];
            $data['zip'] = $item['CEP'];

            $address = "";

            if(!empty($data['street'])) {
                $address .= $data['street'] . " " . $data['number'] . " ";
            } elseif (!empty($data['district'])) {
                $address .= $data['district'] . " ";
            } elseif (!empty($data['city'])) {
                $address .= $data['city'] . " ";
            } elseif (!empty($data['state'])) {
                $address .= $data['state'] . " ";
            }

            $address .= $data['zip'];

            $responseGoogle = \GoogleMaps::load('geocoding')
            ->setParam (['address' => $address])
            ->get();

            $local = json_decode($responseGoogle);
            $lat = $lng = null;

            if($local && $local->results) {
                $geometry = $local->results[0]->geometry;
                $data['lat'] = $geometry->location->lat;
                $data['long'] = $geometry->location->lng;
            }

            Address::create($data);

          }

        }

        return response()->json('Enderecos importados com sucesso!');
    }
}
