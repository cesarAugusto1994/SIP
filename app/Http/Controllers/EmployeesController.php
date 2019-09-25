<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Okipa\LaravelTable\Table;
use App\Models\Client;
use App\Models\Client\{Employee, Occupation};
use Auth;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client as GuzzleClient;

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

            $employees->where('company_id', $client->id);

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
            $employees->where('company_id', $client->id);
        }

        $employees = $employees->get();

        $result = [];

        $result = $employees->map(function($employee) {
            return [
              'id' => $employee->uuid,
              'name' => $employee->name,
              'document' => $employee->cpf ?? '',
              'company' => $employee->company->name
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
            return abort(403, 'Unauthorized action.');
        }

        $company = null;

        if($request->has('client')) {
            $company = Client::uuid($request->get('client'));
        }

        $companies = Client::all();

        return view('clients.employees.create', compact('company', 'companies'));
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

                  Employee::create($data);

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
            return abort(403, 'Unauthorized action.');
        }

        $data = $request->request->all();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:employees',
            //'phone' => 'string|max:20',
            'company_id' => 'required',
            'occupation_id' => 'required',
            //'cpf' => 'required|cpf|unique:employees',
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

        Employee::create($data);

        notify()->flash('Sucesso!', 'success', [
          'text' => 'Novo Funcionário adicionado ao Cliente com sucesso.'
        ]);

        return redirect()->route('clients.show', $company->uuid);
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
            return abort(403, 'Unauthorized action.');
        }

        $companies = Client::all();
        $employee = Employee::uuid($id);

        return view('clients.employees.edit', compact('companies', 'employee'));
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
            return abort(403, 'Unauthorized action.');
        }

        $data = $request->request->all();

        $employee = Employee::uuid($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:employees,email,'.$employee->id,
            //'phone' => 'string|max:20',
            'company_id' => 'required',
            'occupation_id' => 'required',
            //'cpf' => 'required|cpf|unique:employees,cpf,'.$employee->id,
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $company = Client::uuid($data['company_id']);
        $data['company_id'] = $company->id;

        $occupation = Occupation::uuid($data['occupation_id']);
        $data['occupation_id'] = $occupation->id;

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

    public function importJson()
    {
        try {

          $employeesData = [];

          $client = new GuzzleClient([
            'handler' => new \GuzzleHttp\Handler\CurlHandler(),
          ]);
          $response = $client->get('http://soc.com.br/WebSoc/exportadados?parametro={%27empresa%27:%27235164%27,%27codigo%27:%2723175%27,%27chave%27:%277edf603bbc49f9b1e241%27,%27tipoSaida%27:%27json%27}');

          $contents = $response->getBody()->getContents();

          $employeesData = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $contents), true);

          if(!$employeesData) {
              return response()->json('Dados não informados.');
          }

          $data = [];

          //$companies = Client::where('active', true)->get();

          //foreach ($companies as $key => $company) {

            /*echo '> Empresa: ' . $company->name . PHP_EOL;

            $result = array_filter($employeesData, function($item) use ($company) {
                return $item['CODIGOEMPRESA'] == $company->code;
            });*/

            foreach ($employeesData as $key => $item) {

                //if($company) {

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
                //}

            //}

            //dd($item);

          }

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
