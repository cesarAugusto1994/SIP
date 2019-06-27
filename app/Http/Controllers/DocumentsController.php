<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery\Document;
use App\Models\Client;
use App\Models\Client\{Address, Employee};
use App\Models\Delivery\Document\Type;
use Auth;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->hasPermission('view.documentos')) {
            return abort(403, 'Unauthorized action.');
        }

        $documents = Document::orderByDesc('id')->paginate(10);
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $types = Type::all();
        return view('documents.create',compact('clients', 'types'));
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

        //dd($data);

        $user = $request->user();

        $data['created_by'] = $user->id;

        $data['status_id'] = 1;

        $client = Client::uuid($data['client_id']);
        $type = Type::uuid($data['type_id']);

        $data['client_id'] = $client->id;
        $data['type_id'] = $type->id;
        $data['price'] = $type->price;

        if($request->filled('employees')) {

          $employees = Employee::whereIn('uuid', $data['employees'])->get();

          foreach ($employees as $key => $employee) {

            $data['employee_id'] = $employee->id;
            $document = Document::create($data);

          }

        } else {

          $document = Document::create($data);

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Documento adicionado com sucesso.'
        ]);

        return redirect()->route('documents.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $document = Document::uuid($id);
        $clients = Client::all();
        $types = Type::all();
        $employees = Employee::all();
        return view('documents.edit',compact('clients', 'document', 'types', 'employees'));
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

        $document = Document::uuid($id);

        $client = Client::uuid($data['client_id']);
        $type = Type::uuid($data['type_id']);
        $employee = Employee::uuid($data['employee_id']);

        $data['client_id'] = $client->id;
        $data['type_id'] = $type->id;
        $data['employee_id'] = $employee->id;

        $document->update($data);

        notify()->flash('Sucesso!', 'success',[
          'text' => 'Documento editado com sucesso.'
        ]);

        return redirect()->route('documents.index');
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

          $document = Document::uuid($id);
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
}
