<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, Documents};
use App\Models\Client\Employee;
use Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleClient;
use pcrov\JsonReader\JsonReader;
use App\Helpers\Helper;
use Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.clientes')) {
            return abort(403, 'Acesso negado.');
        }

        $quantity = 0;
        $clients = [];

        if($request->get('find')) {

          $clients = Client::orderBy('name');

          if($request->filled('search')) {

            $search = $request->get('search');

            $clients->where('id', $search)
            ->orWhere('name', 'like', "%$search%")
            ->orWhere('document', 'like', "%$search%");

          }

          if($request->filled('status')) {
            $clients->where('active', $request->get('status'));
          }

          if($request->filled('address')) {

              $address = $request->get('address');

              $clients->whereHas('addresses', function($query) use($address) {
                  $query->where('zip', 'like', "%$address%")
                  ->orWhere('description', 'like', "%$address%")
                  ->orWhere('street', 'like', "%$address%")
                  ->orWhere('number', 'like', "%$address%")
                  ->orWhere('district', 'like', "%$address%")
                  ->orWhere('city', 'like', "%$address%")
                  ->orWhere('state', 'like', "%$address%")
                  ->orWhere('complement', 'like', "%$address%")
                  ->orWhere('reference', 'like', "%$address%")
                  ->orWhere('long', 'like', "%$address%")
                  ->orWhere('lat', 'like', "%$address%");
              });
          }

          $clients->orderBy('name');

          $quantity = $clients->count();
          $clients = $clients->paginate();

          foreach ($request->all() as $key => $value) {
              $clients->appends($key, $value);
          }

        }

        return view('clients.index', compact('clients', 'quantity'));
    }

    public function trainings($id)
    {
        $client = Client::uuid($id);
        return view('clients.trainings', compact('client'));
    }

    public function search(Request $request)
    {
        if(!$request->filled('search')) {}

        $search = $request->get('search');

        $clients = Client::where('id', $search)
        ->orWhere('name', 'like', "%$search%")
        ->orWhere('document', 'like', "%$search%")
        ->where('active', true)
        ->get();

        $result = [];

        $result = $clients->where('active', true)->map(function($client) {
            return [
              'id' => $client->uuid,
              'name' => $client->name,
              'document' => $client->document
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
        return view('clients.create');
    }

    public function uploadDocuments($id, Request $request)
    {
        $client = Client::uuid($id);

        $user = $request->user();

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $key => $file) {

                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $path = $file->storeAs('client/documents', $filename);

                Documents::create([
                  'client_id' => $client->id,
                  'description' => $filename,
                  'link' => $path,
                  'filename' => $filename,
                  'extension' => $extension,
                  'created_by' => $user->id,
                  'type_id' => 6,
                ]);
            }

        }

        notify()->flash('Upload realizado!', 'success', [
          'text' => 'Documentos Anexados ao Cliente com sucesso.'
        ]);

        return redirect()->route('clients.show', $id);
    }

    public function downloadDocument($id)
    {
        $document = Documents::uuid($id);
        return Storage::download($document->link);
    }

    public function deleteDocument($id)
    {
        try {

          $document = Documents::uuid($id);

          if(Storage::exists($document->link)) {
              Storage::delete($document->link);
          }

          $document->delete();

          return response()->json([
            'success' => true,
            'message' => 'Documento removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }

    }

    public function previewDocument($id)
    {
        $document = Documents::uuid($id);

        $link = $document->link;

        $file = \Storage::exists($link) ? \Storage::get($link) : false;

        if(!$file) {
          $file = null;
        }

        $mimetype = \Storage::disk('local')->mimeType($link);

        return response($file, 200)->header('Content-Type', $mimetype);
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

        $documentType = "";

        if(strlen($data['document']) == 18) {
            $documentType = "cnpj";
        } elseif (strlen($data['document']) < 18) {
            $documentType = "cpf";
        }

        $documentString = str_replace(['.','/','-'], ['','',''], $data['document']);
        $data['document'] = $documentString;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contract_id' => 'required',
            'document' => 'required|unique:clients|'.$documentType,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['active'] = $request->has('active');
        $data['charge_delivery'] = $request->has('charge_delivery');
        $data['deliver_documents'] = $request->has('deliver_documents');

        $client = Client::create($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Cliente adicionado com sucesso.'
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
        $client = Client::uuid($id);
        return view('clients.show', compact('client'));
    }

    public function addresses(Request $request)
    {
        $id = $request->get('param');

        try {

          $client = Client::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $client->addresses
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    public function emails(Request $request)
    {
        $id = $request->get('param');

        try {

          $client = Client::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $client->emails
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    public function employees(Request $request)
    {
        $id = $request->get('param');

        try {

          $employees = Employee::orderBy('name');
          $client = Client::uuid($id);
          $employees->whereHas('jobs', function($query) use($client){
              $query->where('company_id', $client->id)->where('active', true);
          });

          $employees = $employees->get();

          $result = [];

          $result = $employees->map(function($employee) {
              return [
                'id' => $employee->uuid,
                'name' => $employee->name,
                'document' => Helper::formatCnpjCpf($employee->cpf) ?? '',
                'company' =>  Helper::actualOccupation($employee)->name ?? '',
              ];
          });

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $result
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    public function documents(Request $request)
    {
        $id = $request->get('param');

        try {

          $client = Client::uuid($id);
          $documents = $client->documents->where('status_id', 1);

          $response = [];

          foreach ($documents as $key => $document) {
              $response[] = [
                'id' => str_pad($document->id, 6, "0", STR_PAD_LEFT),
                'uuid' => $document->uuid,
                'type' => $document->type->name,
                'client' => $document->client->name,
                'employee' => $document->employee->name ?? '',
                'status' => $document->status->name,
                'reference' => $document->reference ?? '',
              ];
          }

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $response
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    public function employeeFind(Request $request)
    {
        $param = $request->get('param');

        try {

          $employees = Employee::where('name', 'LIKE', "%$param%")->orWhere('cpf', 'LIKE', "%$param%");

          if($request->get('client')) {
              $client = Client::uuid($request->get('client'));
              $employees->whereHas('jobs', function($query) use($client2){
                  $query->where('company_id', $client->id)->where('active', true);
              });
          }

          $employees = $employees->get();

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $employees
          ]);

        } catch(\Exception $e) {

          return response()->json([
            'success' => false,
            'message' => 'Ocorreu um erro inesperado',
            'data' => []
          ]);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::uuid($id);
        return view('clients.edit', compact('client'));
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

        $documentType = "";

        if(strlen($data['document']) == 18) {
            $documentType = "cnpj";
        } elseif (strlen($data['document']) < 18) {
            $documentType = "cpf";
        }

        $client = Client::uuid($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['active'] = $request->has('active');
        $data['charge_delivery'] = $request->has('charge_delivery');
        $data['deliver_documents'] = $request->has('deliver_documents');

        $documentString = str_replace(['.','/','-'], ['','',''], $data['document']);

        $data['document'] = $documentString;

        $client->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'As Informações do cliente foram alteradas com sucesso.'
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

          $client = Client::uuid($id);

          if($client->addresses->isNotEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'O cliente não pode ser removido: existem endereços vinculados a ele.'
            ]);
          }

          if($client->documents->isNotEmpty()) {
            return response()->json([
              'success' => false,
              'message' => 'O cliente não pode ser removido: existem movimentações.'
            ]);
          }

          $client->delete();

          return response()->json([
            'success' => true,
            'message' => 'cliente removido com sucesso.'
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
        try {

            $clientData = [];

            $reader = new JsonReader();
            $reader->open("http://soc.com.br/WebSoc/exportadados?parametro={'empresa':'235164','codigo':'23703','chave':'d32494177fab74b4df10','tipoSaida':'json','empresafiltro':'','subgrupo':'','socnet':'','mostrarinativas':''}");

            while ($reader->read()) {

                $clientData = $reader->value();

                foreach ($clientData as $key => $item) {

                    $contractId = 1;

                    $documentString = str_replace(['.','/','-'], ['','',''], $item['cnpj']);
                    $item['cnpj'] = $documentString;

                    $company = Client::where('document', $item['cnpj'])
                    ->where('name', trim($item['razaoSocial']))
                    ->where('code', trim($item['codigo']))
                    ->first();

                    if($company) {
                        $contractId = $company->contract_id;
                    }

                    $data = [
                        'code' => ($item['codigo']),
                        'name' => trim($item['razaoSocial']),
                        'document' => trim($item['cnpj']),
                        'active' => (boolean)$item['status'],
                        'contract_id' => $contractId
                    ];

                    if($company) {
                        $company->update($data);
                        echo '* Empresa Atualizada: ' . $company->code . ' : ' . $company->name . ' - Status: ' . $item['status'] . PHP_EOL;
                    } else {
                        $company = Client::create($data);
                        echo '* Empresa Adicionada: ' . $company->code . ' : ' . $company->name . ' - Status: ' . $item['status'] . PHP_EOL;
                    }

                }


            }
            $reader->close();

            exit('FIM');

            foreach ($clientData as $key => $item) {

                $contractId = 1;

                $documentString = str_replace(['.','/','-'], ['','',''], $item['cnpj']);
                $item['cnpj'] = $documentString;

                $company = Client::where('document', $item['cnpj'])
                ->where('name', trim($item['razaoSocial']))
                ->where('code', trim($item['codigo']))
                ->first();

                if($company) {
                    $contractId = $company->contract_id;
                }

                $data = [
                    'code' => ($item['codigo']),
                    'name' => trim($item['razaoSocial']),
                    'document' => trim($item['cnpj']),
                    'active' => (boolean)$item['status'],
                    'contract_id' => $contractId
                ];

                if($company) {
                    $company->update($data);
                    echo '* Empresa Atualizada: ' . $company->code . ' : ' . $company->name . ' - Status: ' . $item['status'] . PHP_EOL;
                } else {
                    $company = Client::create($data);
                    echo '* Empresa Adicionada: ' . $company->code . ' : ' . $company->name . ' - Status: ' . $item['status'] . PHP_EOL;
                }

            }

            return response()->json([
              'success' => true,
              'message' => 'Clientes importados com sucesso!'
            ]);

          } catch(\Exception $e) {
              throw $e;
          }
    }
}
