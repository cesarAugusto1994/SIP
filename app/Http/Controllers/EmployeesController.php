<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Okipa\LaravelTable\Table;
use App\Models\Client;
use App\Models\Client\Employee\{Job, Occupation as EmployeeOccupation};
use App\Models\Client\{Employee, Occupation};
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleClient;
use pcrov\JsonReader\JsonReader;
use App\Helpers\Helper;
use Auth;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $quantity = 0;
        $employees = [];

        if($request->get('find')) {

          $employees = Employee::orderBy('name');

          if($request->filled('search')) {

            $search = $request->get('search');

            $employees->where('id', $search)
            ->orWhere('name', 'like', "%$search%")
            ->orWhere('cpf', 'like', "%$search%");

          }

          if($request->filled('client')) {

            $client = $request->get('client');
            $client = Client::uuid($client);

            $employees->whereHas('jobs', function($query) use($client){
                $query->where('company_id', $client->id);
            });

          }

          if($request->filled('status')) {
              $employees->where('active', $request->get('status'));
          }

          $quantity = $employees->count();

          $employees = $employees->paginate(15);

          foreach ($request->all() as $key => $value) {
              $employees->appends($key, $value);
          }

        }

        return view('clients.employees.index', compact('employees', 'quantity'));
    }

    public function transferToCompany($id)
    {
        $employee = Employee::uuid($id);
        return view('clients.employees.transfer-company', compact('employee'));
    }

    public function search(Request $request)
    {
        if(!$request->has('search')) {
          return response()->json('Nenhum paramentro de busca foi informado.');
        }

        $client = null;

        $search = $request->get('search');

        $employees = Employee::where('id', $search)
        ->orWhere('name', 'like', "%$search%");

        if($request->filled('client')) {
            $client = Client::uuid($request->get('client'));

            $employees->whereHas('jobs', function($query) use($client){
                $query->where('company_id', $client->id);
            });
        }

        $employees = $employees->get();

        $result = [];

        $result = $employees->map(function($employee) {
            return [
              'id' => $employee->uuid,
              'name' => $employee->name,
              'document' => Helper::formatCnpjCpf($employee->cpf) ?? '',
              'company' =>  Helper::actualOccupation($employee)->name,
            ];
        });

        return json_encode($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!Auth::user()->hasPermission('create.cliente.funcionarios')) {
            return abort(403, 'Acesso negado.');
        }

        $company = null;

        if($request->has('client')) {
            $company = Client::uuid($request->get('client'));
        }

        return view('clients.employees.create', compact('company'));
    }

    public function createMany($id, Request $request)
    {
        if(!Auth::user()->hasPermission('create.cliente.funcionarios')) {
            return abort(403, 'Unauthorized action.');
        }

        $company = Client::uuid($id);

        return view('clients.employees.create-many', compact('company'));
    }

    public function storeMany($id, Request $request)
    {
        if(!Auth::user()->hasPermission('create.cliente.funcionarios')) {
            return abort(403, 'Unauthorized action.');
        }

        if(!$request->has('indexes')) {

          notify()->flash('Erro!', 'error', [
            'text' => 'Nenhum dado foi informado, favor clicar em *Adicionar mais registros*.'
          ]);

          return back();

        }

        $data = $request->request->all();

        $company = Client::uuid($id);

        if($request->has('indexes')) {

            $indexes = $data['indexes'];

            foreach (range(0, $indexes) as $key => $value) {

              $fieldName = 'name-'.$value;
              $fieldCpf = 'cpf-'.$value;
              $fieldRg = 'rg-'.$value;
              $fieldOccupation = 'occupation-'.$value;
              $fieldActive = 'active-'.$value;

              if($request->has($fieldName)) {

                  $data['company_id'] = $company->id;

                  $data['name'] = $request->get($fieldName);
                  $data['cpf'] = $request->get($fieldCpf);
                  $data['rg'] = $request->get($fieldRg);

                  $occupation = Occupation::uuid($request->get($fieldOccupation));
                  $data['occupation_id'] = $occupation->id;

                  $data['created_by'] = $request->user()->id;
                  $data['active'] = $request->has($fieldActive);

                  $documentString = str_replace(['.','/','-'], ['','',''], $data['cpf']);
                  $data['cpf'] = $documentString;

                  $employee = Employee::create($data);

                  Job::create([
                    'company_id' => $company->id,
                    'employee_id' => $employee->id,
                  ]);

                  EmployeeOccupation::create([
                    'occupation_id' => $occupation->id,
                    'employee_id' => $employee->id,
                  ]);

              }

            }

        }

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Funcionário adicionado ao Cliente com sucesso.'
        ]);

        return redirect()->route('clients.show', $company->uuid);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->hasPermission('create.cliente.funcionarios')) {
            return abort(403, 'Acesso Negado.');
        }

        $data = $request->request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'company_id' => 'required',
            'occupation_id' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $company = Client::uuid($data['company_id']);
        $data['company_id'] = $company->id;

        $occupation = Occupation::uuid($data['occupation_id']);
        $data['occupation_id'] = $occupation->id;

        $data['created_by'] = $request->user()->id;
        $data['active'] = $request->has('active');

        $documentString = str_replace(['.','/','-'], ['','',''], $data['cpf']);

        if(!empty($documentString)) {

            $hasClient = Employee::where('cpf', $documentString)->first();

            if($hasClient) {

              notify()->flash('Atenção!', 'error', [
                'text' => 'Documento já registrado para outro Cliente.',
                'modal' => true
              ]);

              return back();

            }
        }

        $data['cpf'] = $documentString;

        $employee = Employee::create($data);

        Job::create([
          'company_id' => $company->id,
          'employee_id' => $employee->id,
        ]);

        EmployeeOccupation::create([
          'occupation_id' => $occupation->id,
          'employee_id' => $employee->id,
        ]);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Funcionário adicionado ao Cliente com sucesso.'
        ]);

        return redirect()->route('employees.show', $employee->uuid);
    }

    public function show($id)
    {
        $employee = Employee::uuid($id);
        return view('clients.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermission('edit.cliente.funcionarios')) {
            return abort(403, 'Acesso negado.');
        }

        $employee = Employee::uuid($id);
        return view('clients.employees.edit', compact('employee'));
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
        if(!Auth::user()->hasPermission('edit.cliente.funcionarios')) {
            return abort(403, 'Acesso negado.');
        }

        $data = $request->request->all();

        $employee = Employee::uuid($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cpf' => 'required|cpf|unique:client_employees,cpf,'.$employee->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $documentString = str_replace(['.','/','-'], ['','',''], $data['cpf']);
        $data['cpf'] = $documentString;

        $data['active'] = $request->has('active');
        $employee->update($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Funcionário atualizado com sucesso.'
        ]);

        return redirect()->route('employees.show', $employee->uuid);
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

          if(!Auth::user()->hasPermission('delete.cliente.funcionarios')) {
              return response()->json([
                'success' => false,
                'message' => 'Operação não autorizada'
              ]);
          }

          $employee = Employee::uuid($id);

          $employee->delete();

          return response()->json([
            'success' => true,
            'message' => 'Funcionário removido com sucesso.'
          ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function migrateEmployees()
    {
        $employees = Employee::all();

        foreach ($employees as $key => $employee) {

            Job::updateOrCreate([
              'employee_id' => $employee->id,
              'company_id' => $employee->company->id,
              'hired_at' => $employee->hired_at,
              'fired_at' => $employee->fired_at,
            ]);

            EmployeeOccupation::updateOrCreate([
              'employee_id' => $employee->id,
              'occupation_id' => $employee->occupation_id,
            ]);

        }
    }

    public function importJson()
    {
        try {

          $employeesData = [];

          $reader = new JsonReader();
          $reader->open("http://soc.com.br/WebSoc/exportadados?parametro={%27empresa%27:%27235164%27,%27codigo%27:%2723175%27,%27chave%27:%277edf603bbc49f9b1e241%27,%27tipoSaida%27:%27json%27}");

            while($reader->read()) {

                $employeesData = $reader->value();

                foreach ($employeesData as $key => $item) {

                      $birthDay = null;

                      if($item['DATA_NASCIMENTO']) {
                          $birthDay = \DateTime::createFromFormat('d/m/Y', $item['DATA_NASCIMENTO']);
                          $birthDay = $birthDay->format('Y-m-d');
                      }

                      $company = Client::where('code', $item['CODIGOEMPRESA'])->first();

                      if(!$company) {
                          continue;
                      }

                      $hasEmployee = Employee::where('name', $item['NOME'])
                                      //->orWhere('cpf', $item['CPFFUNCIONARIO'])
                                      ->orWhere('code', $item['CODIGO'])
                                      ->orWhere('birth', $birthDay)
                                      ->where('company_id', $company->id)
                                      ->first();

                      $data['company_id'] = $company->id;
                      $data['name'] = $item['NOME'];
                      $data['cpf'] = $item['CPFFUNCIONARIO'];
                      $data['code'] = $item['CODIGO'];
                      $data['active'] = $item['SITUACAO'] == 'Ativo' ? true : false;

                      $occupation = Occupation::firstOrCreate([
                        'name' => $item['NOMECARGO'],
                        'client_id' => $company->id
                      ]);

                      $data['occupation_id'] = $occupation->id;

                      $birth = $hiredAt = $firedAt = null;

                      if(!empty($item['DATA_NASCIMENTO'])) {
                          $birthday = \DateTime::createFromFormat('d/m/Y', $item['DATA_NASCIMENTO']);
                      }

                      if(!empty($item['DATA_ADMISSAO'])) {
                          $hiredAt = \DateTime::createFromFormat('d/m/Y', $item['DATA_ADMISSAO']);
                      }

                      if(!empty($item['DATA_DEMISSAO'])) {
                          $firedAt = \DateTime::createFromFormat('d/m/Y', $item['DATA_DEMISSAO']);
                      }

                      $data['birth'] = $birthday;
                      $data['hired_at'] = $hiredAt;
                      $data['fired_at'] = $firedAt;
                      $data['created_by'] = 1;

                      if($hasEmployee) {
                          //echo '>> Funcionario ja importado : ' . $item['NOME'] . '<br/>';
                          $hasEmployee->update($data);
                      } else {
                          echo '>> Funcionario adicionado : ' . $item['NOME'] . PHP_EOL;
                          Employee::create($data);
                      }

                    }

            }

            $reader->close();

            return response()->json([
              'success' => true,
              'message' => 'Funcionários importados com sucesso!'
            ]);

        } catch(\Exception $e) {
          return response()->json([
            'success' => false,
            'message' => $e->getMessage()
          ]);
        }
    }

    public function grantAccess($id)
    {
        $employee = Employee::uuid($id);

        return view('clients.employees.access', compact('employee'));
    }
}
