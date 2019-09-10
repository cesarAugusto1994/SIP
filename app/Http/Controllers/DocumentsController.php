<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery\Document;
use App\Models\Client;
use App\Models\Client\{Address, Employee};
use App\Models\Delivery\Document\Type;
use App\Models\Delivery\Document\Status;
use Auth;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermission('view.documentos')) {
            return abort(403, 'Unauthorized action.');
        }

        $documents = Document::orderByDesc('id');

        if(!$request->has('find')) {
            $documents->whereIn('status_id', [1,2]);
        }

        if($request->filled('code')) {
            $documents->where('id', $request->get('code'));
        } else {

          if($request->filled('client')) {
              $client = Client::uuid($request->get('client'));
              $documents->where('client_id', $client->id);
          }

          if($request->filled('status')) {
              $documents->where('status_id', $request->get('status'));
          }

          if($request->filled('type')) {
              $documents->where('type_id', $request->get('type'));
          }

          if($request->filled('start')) {
              $start = \DateTime::createFromFormat('d/m/Y', $request->get('start'));
              $documents->where('created_at', '>=', $start->format('Y-m-d') . ' 00:00:00');
          }

          if($request->filled('end')) {
              $end = \DateTime::createFromFormat('d/m/Y', $request->get('end'));
              $documents->where('created_at', '<=', $end->format('Y-m-d') . ' 23:59:59');
          }
        }

        $quantity = $documents->count();

        $documents = $documents->paginate();

        foreach ($request->all() as $key => $value) {
            $documents->appends($key, $value);
        }

        return view('documents.index', compact('documents', 'quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documents.create');
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

        $data['created_by'] = $user->id;
        $data['status_id'] = 1;

        $client = Client::uuid($data['client_id']);
        $type = Type::uuid($data['type_id']);

        $emp = null;

        $data['client_id'] = $client->id;
        $data['type_id'] = $type->id;
        $data['amount'] = $type->price;

        if($request->filled('employee_id')) {

          $employees = Employee::whereIn('uuid', $data['employee_id'])->get();

          foreach ($employees as $key => $employee) {

            $data['employee_id'] = $employee->id;
            $document = Document::create($data);

          }

        } else {

          $document = Document::create($data);

        }

        if($request->has('indexes')) {

            $indexes = $data['indexes'];

            foreach (range(0, $indexes) as $key => $value) {

              $fieldType = 'type_id-'.$value;
              $fieldClient = 'client_id-'.$value;
              $fieldEmployee = 'employee_id-'.$value;
              $fieldReference = 'reference-'.$value;

              if($request->has($fieldType)) {

                  $client = Client::uuid($request->get($fieldClient));

                  $employee = null;
                  $type = Type::uuid($request->get($fieldType));
                  $reference = $request->get($fieldReference);

                  if($request->filled($fieldEmployee)) {
                      $employees = Employee::whereIn('uuid', $request->get($fieldEmployee))->get();

                      foreach ($employees as $key => $employee) {

                        Document::create([
                          'type_id' => $type->id,
                          'client_id' => $client->id,
                          'employee_id' => $employee->id,
                          'reference' => $reference,
                          'created_by' => $user->id,
                          'status_id' => 1,
                          'amount' => $type->price,
                        ]);
                      }

                  } else {

                    Document::create([
                      'type_id' => $type->id,
                      'client_id' => $client->id,
                      'employee_id' => null,
                      'reference' => $reference,
                      'created_by' => $user->id,
                      'status_id' => 1,
                      'amount' => $type->price,
                    ]);

                  }

              }

            }

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
        $document = Document::uuid($id);
        return view('documents.show', compact('document'));
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
        return view('documents.edit',compact('document'));
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

        $employee = null;

        if($request->filled('employee_id')) {
            $employee = Employee::uuid($data['employee_id']);
        }

        $data['client_id'] = $client->id;
        $data['type_id'] = $type->id;
        $data['employee_id'] = $employee->id ?? null;

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

          if($document->status_id != 1) {
            return response()->json([
              'success' => false,
              'message' => 'Não é possivel remover este documento, pois pertence a uma Ordem de Entrega.'
            ]);
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
}
