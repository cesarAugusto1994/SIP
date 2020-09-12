<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client as GuzzleClient;
use App\Models\Client;
use App\Models\Client\Address;

class AddressesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'addresses:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar Enderecos das Empresas Clientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
