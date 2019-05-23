<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client, Documents};
use Storage;
use Illuminate\Support\Facades\Validator;
use Auth;

class ClientController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
       $this->middleware('auth');
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.clientes')) {
            return abort(403, 'Unauthorized action.');
        }

        //exit;

        $clients = [];

        $clients = Client::where('id', '>', 0);

        if($request->filled('search')) {

          $search = $request->get('search');

          $clients->where('id', $search)
          ->orWhere('name', 'like', "%$search%")
          ->orWhere('phone', 'like', "%$search%")
          ->orWhere('document', 'like', "%$search%")
          ->orWhere('email', 'like', "%$search%");

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

        $quantity = $clients->count();

        $clients = $clients->paginate(15);

        foreach ($request->all() as $key => $value) {
            $clients->appends($key, $value);
        }

        return view('clients.index', compact('clients', 'quantity'));
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
                  'status_id' => 1,
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

          Storage::delete($document->link);

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

      $validator = Validator::make($request->all(), [
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:clients',
          'phone' => 'required|string|max:20',
          'document' => 'required|unique:clients|'.$documentType,
      ]);

      if ($validator->fails()) {
          return back()->withErrors($validator)->withInput();
      }

      $data['active'] = $request->has('active');

      Client::create($data);

      notify()->flash('Sucesso!', 'success', [
        'text' => 'Novo Cliente adicionado com sucesso.'
      ]);

      return redirect()->route('clients.index');
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

    public function employees(Request $request)
    {
        $id = $request->get('param');

        try {

          $client = Client::uuid($id);

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $client->employees
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

          $employee = Employee::where('name', 'LIKE', "%$param%")->get();

          return response()->json([
            'success' => true,
            'message' => 'Registros retornados',
            'data' => $employee
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
            'email' => 'required|string|email|max:255|unique:clients,email,'.$client->id,
            'phone' => 'required|string|max:20',
            'document' => 'required|unique:clients,document,'.$client->id.'|'.$documentType,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data['active'] = $request->has('active');

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
}
