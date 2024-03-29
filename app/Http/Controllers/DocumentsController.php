<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery\Document;
use App\Models\Client;
use App\Models\Client\{Address, Employee};
use App\Models\Delivery\Document\Type;
use App\Models\Delivery\Document\Status;
use Khill\Lavacharts\Lavacharts;
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
            $documents->whereIn('status_id', [1]);
        }

        if($request->filled('code')) {
            $documents->where('id', $request->get('code'));
        } else {

          if($request->filled('client')) {
              $client = Client::uuid($request->get('client'));
              $documents->where('client_id', $client->id);
          }

          if($request->filled('employee')) {
              $employee = Employee::uuid($request->get('employee'));
              $documents->where('employee_id', $employee->id);
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

        $lava = null;

        if($request->has('find')) {

            $lava = new Lavacharts;

            $reasons = $lava->DataTable();
            $reasons2 = $lava->DataTable();
            $reasons3 = $lava->DataTable();
            $reasons4 = $lava->DataTable();

            $groupedByPriority = $groupedByStatus = $groupedByUser = $groupedByType = $documents->get();

            $groupedByType = $groupedByType->groupBy('type_id');

            $reasons->addStringColumn('Tipos')
                    ->addNumberColumn('Percent');

            foreach ($groupedByType as $key => $grouped) {
              $reasons->addRow([$grouped->first()->type->name, $grouped->count()]);
            }

            $lava->DonutChart('Tipo', $reasons, [
                'title' => 'Documentos Por Tipo'
            ]);

            // Usuário

            $reasons2->addStringColumn('Usuários')
                    ->addNumberColumn('Quantidade');

            $groupedByUser = $groupedByUser->groupBy('created_by');

            foreach ($groupedByUser as $key => $grouped) {
              $reasons2->addRow([$grouped->first()->creator->person->name, $grouped->count()]);
            }

            $lava->DonutChart('Usuario', $reasons2, [
                'title' => 'Documentos Por Usuário'
            ]);

            // Status

            $reasons3->addStringColumn('Situação')
                    ->addNumberColumn('Percent');

            $groupedByStatus = $groupedByStatus->groupBy('status_id');

            foreach ($groupedByStatus as $key => $grouped) {
              $reasons3->addRow([$grouped->first()->status->name, $grouped->count()]);
            }

            $lava->DonutChart('Status', $reasons3, [
                'title' => 'Documentos Por Situação'
            ]);

            // Prioridade

            $reasons4->addStringColumn('Cliente')
                    ->addNumberColumn('Quantidade');

            $groupedByPriority = $groupedByPriority->groupBy('client_id');

            foreach ($groupedByPriority as $key => $grouped) {
              $reasons4->addRow([$grouped->first()->client->name, $grouped->count()]);
            }

            $lava->BarChart('Empresa', $reasons4, [
                'title' => 'Documentos Por Empresa'
            ]);

        }

        $quantity = $documents->count();

        $documents = $documents->paginate();

        foreach ($request->all() as $key => $value) {
            $documents->appends($key, $value);
        }

        return view('documents.index', compact('documents', 'quantity', 'lava'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $client = null;

        if($request->filled('client')) {
            $client = Client::uuid($request->get('client'));
        }

        return view('documents.create', compact('client'));
    }

    public function createManyForOneClient()
    {
        return view('documents.create-many');
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

        $documentsList = [];

        $client = Client::uuid($data['client_id']);
        $types = $request->get('type_id');

        $employeesList = $data['employee_id'] ?? [];

        foreach ($types as $key => $typeI) {

          $type = Type::uuid($typeI);

          $emp = null;

          $data['client_id'] = $client->id;
          $data['type_id'] = $type->id;
          $data['amount'] = $type->price;

          if($request->filled('employee_id')) {

            $employees = Employee::whereIn('uuid', $employeesList)->get();

            foreach ($employees as $key => $employee) {

              $data['employee_id'] = $employee->id;
              $document = Document::create($data);
              $documentsList[$client->id] = $document->uuid;
            }


          } else {

            if($request->has('address_id')) {
                $addressDoc = Address::uuid($request->get('address_id'));
                $data['address_id'] = $addressDoc->id;
            }

            $document = Document::create($data);
            $documentsList[$client->id] = $document->uuid;

          }

        }

        if($request->has('indexes')) {

            $indexes = $data['indexes'];

            foreach (range(0, $indexes) as $key => $value) {

              $fieldType = 'type_id-'.$value;
              $fieldClient = 'client_id-'.$value;
              $fieldEmployee = 'employee_id-'.$value;
              $fieldReference = 'reference-'.$value;
              $fieldAddress = 'address_id-'.$value;

              if($request->has($fieldType)) {

                  foreach ($request->get($fieldType) as $key => $typeItem) {

                    $client = Client::uuid($request->get($fieldClient));

                    $addressDoc = $employee = null;
                    $type = Type::uuid($typeItem);
                    $reference = $request->get($fieldReference);

                    if($request->filled($fieldEmployee)) {
                        $employees = Employee::whereIn('uuid', $request->get($fieldEmployee))->get();

                        foreach ($employees as $key => $employee) {

                          $document = Document::create([
                            'type_id' => $type->id,
                            'client_id' => $client->id,
                            'employee_id' => $employee->id,
                            'reference' => $reference,
                            'created_by' => $user->id,
                            'status_id' => 1,
                            'amount' => $type->price,
                          ]);

                          $documentsList[$client->id] = $document->uuid;

                        }

                    } else {

                      if($request->filled($fieldAddress)) {
                          $addressDoc = Address::uuid($request->get($fieldAddress));
                          $addressDoc = $addressDoc->id;
                      }

                      $document = Document::create([
                        'type_id' => $type->id,
                        'client_id' => $client->id,
                        'employee_id' => null,
                        'reference' => $reference,
                        'created_by' => $user->id,
                        'status_id' => 1,
                        'amount' => $type->price,
                        'address_id' => $addressDoc
                      ]);

                      $documentsList[$client->id] = $document->uuid;

                    }

                  }



              }

            }

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Documento adicionado com sucesso.'
        ]);

        return redirect()->route('delivery-order.create', ['client' => $client->uuid, 'document[]' => $documentsList[$client->id]]);
    }

    public function createManyForOneClientStore(Request $request)
    {
        if(!$request->filled('indexes')) {
          notify()->flash('Erro!', 'error', [
            'text' => 'Nenhum documento foi informado.'
          ]);
          return back();
        }

        $data = $request->request->all();

        $user = $request->user();

        $data['created_by'] = $user->id;
        $data['status_id'] = 1;

        $documentsList = [];

        $client = Client::uuid($data['client_id']);

        $indexes = $data['indexes'];

        foreach (range(0, $indexes) as $key => $value) {

            $fieldType = 'type_id-'.$value;
            $fieldEmployee = 'employee_id-'.$value;
            $fieldReference = 'reference-'.$value;

            if($request->has($fieldType)) {

                foreach ($request->get($fieldType) as $key => $typeItem) {

                  $employee = null;
                  $type = Type::uuid($typeItem);
                  $reference = $request->get($fieldReference);

                  if($request->filled($fieldEmployee)) {
                      $employees = Employee::whereIn('uuid', $request->get($fieldEmployee))->get();

                      foreach ($employees as $key => $employee) {

                        $document = Document::create([
                          'type_id' => $type->id,
                          'client_id' => $client->id,
                          'employee_id' => $employee->id,
                          'reference' => $reference,
                          'created_by' => $user->id,
                          'status_id' => 1,
                          'amount' => $type->price,
                        ]);

                        $documentsList[$client->id] = $document->uuid;

                      }

                  } else {

                    $document = Document::create([
                      'type_id' => $type->id,
                      'client_id' => $client->id,
                      'employee_id' => null,
                      'reference' => $reference,
                      'created_by' => $user->id,
                      'status_id' => 1,
                      'amount' => $type->price,
                    ]);

                    $documentsList[$client->id] = $document->uuid;

                  }

                }
            }
        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Documento adicionado com sucesso.'
        ]);

        return redirect()->route('delivery-order.create', ['client' => $client->uuid, 'document[]' => $documentsList[$client->id]]);
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

        $deliveryOrder = $document->deliveryDocument ?
                         $document->deliveryDocument->deliveryOrder :
                         null;

        return view('documents.show', compact('document', 'deliveryOrder'));
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
