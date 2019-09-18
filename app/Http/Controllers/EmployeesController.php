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

        $search = $request->get('search');

        $employees = Employee::where('id', $search)
        ->orWhere('name', 'like', "%$search%")
        ->get();

        $result = [];

        $result = $employees->map(function($employee) {
            return [
              'id' => $employee->uuid,
              'name' => $employee->name,
              'document' => $employee->cpf,
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

          //if(session()->has('employees')) {

              //$employeesData = session()->get('employees');

          //} else {

            /*$client = new GuzzleClient([
              'handler' => new \GuzzleHttp\Handler\CurlHandler(),
            ]);
            $response = $client->get('http://soc.com.br/WebSoc/exportadados?parametro={%27empresa%27:%27235164%27,%27codigo%27:%2723175%27,%27chave%27:%277edf603bbc49f9b1e241%27,%27tipoSaida%27:%27json%27}');

            $contents = $response->getBody()->getContents();

            $employeesData = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $contents), true);

            if(!$employeesData) {
                return response()->json('Ocorreu um erro.');
            }
*/
            $employeesData = [];

            $employeesData = array (
                0 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '1',
                  'NOME' => 'TIAGO ALVARENGA DE TASSI',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '11018',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Ativo',
                  'DATA_NASCIMENTO' => '24/05/1981',
                  'DATA_ADMISSAO' => '01/07/2009',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                1 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '2',
                  'NOME' => 'FABIO MIRANDA DA SILVA',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '21651',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '05/05/1978',
                  'DATA_ADMISSAO' => '13/01/2010',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                2 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '3',
                  'NOME' => 'ANTONIO MACIEL',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '21822',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '28/09/1977',
                  'DATA_ADMISSAO' => '15/01/2010',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                3 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '4',
                  'NOME' => 'EMANUELY BICALHO DE MATTOS',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '15267',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '20/02/1980',
                  'DATA_ADMISSAO' => '12/08/2011',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                4 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '5',
                  'NOME' => 'SANTILHA REIS',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8841',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '22/08/1980',
                  'DATA_ADMISSAO' => '02/06/2009',
                  'DATA_DEMISSAO' => '02/06/2009',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                5 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '6',
                  'NOME' => 'GEILSON PEREIRA MAIA',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '002',
                  'NOMECARGO' => 'CARGO INDEFINIDO',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8917',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '06/12/1973',
                  'DATA_ADMISSAO' => '02/06/2009',
                  'DATA_DEMISSAO' => '18/01/2010',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                6 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '7',
                  'NOME' => 'PAULO AFONSO',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8918',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '11/03/1973',
                  'DATA_ADMISSAO' => '03/06/2009',
                  'DATA_DEMISSAO' => '13/01/2010',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                7 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '8',
                  'NOME' => 'RONNE VENTURA DE SOUZA',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8919',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '08/04/1974',
                  'DATA_ADMISSAO' => '03/06/2009',
                  'DATA_DEMISSAO' => '24/03/2010',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                8 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '9',
                  'NOME' => 'ALMIR CHAVES DE BRITO',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8921',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '19/11/1973',
                  'DATA_ADMISSAO' => '16/10/2008',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                9 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '10',
                  'NOME' => 'PATRICIA MENDES LEITE',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8922',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '29/01/1984',
                  'DATA_ADMISSAO' => '03/06/2009',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                10 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '11',
                  'NOME' => 'ALEXANDRE FERNANDES DE SA',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8923',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '01/01/1970',
                  'DATA_ADMISSAO' => '01/01/2013',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                11 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '12',
                  'NOME' => 'HEDILAINE DO CARMO UCCELI',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '006',
                  'NOMECARGO' => 'SECRETARIA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '8948',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '23/06/1976',
                  'DATA_ADMISSAO' => '31/05/2004',
                  'DATA_DEMISSAO' => '04/01/2011',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                12 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '13',
                  'NOME' => 'SANDRA NERI DE OLIVEIRA',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '11732',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '05/06/1977',
                  'DATA_ADMISSAO' => '14/06/2007',
                  'DATA_DEMISSAO' => '30/07/2010',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                13 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '14',
                  'NOME' => 'DANIEL DA MOTA EDUARDO',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '1402',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '22/02/1986',
                  'DATA_ADMISSAO' => '25/04/2012',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                14 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '15',
                  'NOME' => 'MAGNO GOMES MACIEL',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '002',
                  'NOMESETOR' => 'OPERACIONAL',
                  'CODIGOCARGO' => '004',
                  'NOMECARGO' => 'FRENTISTA',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '6183',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '16/04/1985',
                  'DATA_ADMISSAO' => '01/01/2000',
                  'DATA_DEMISSAO' => '06/05/2011',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
                15 =>
                array (
                  'CODIGOEMPRESA' => '244534',
                  'NOMEEMPRESA' => 'AUTO POSTO SAO PEDRO LTDA ',
                  'CODIGO' => '16',
                  'NOME' => 'KARLA CAROLINA CAETANO DOS SANTOS COUTINHO',
                  'CODIGOUNIDADE' => '0000001',
                  'NOMEUNIDADE' => 'AUTO POSTO SAO PEDRO LTDA',
                  'CODIGOSETOR' => '001',
                  'NOMESETOR' => 'ADMINISTRATIVA',
                  'CODIGOCARGO' => '001',
                  'NOMECARGO' => 'CAIXA ATENDENTE',
                  'CBOCARGO' => '',
                  'MATRICULAFUNCIONARIO' => '3496',
                  'CPFFUNCIONARIO' => '',
                  'SITUACAO' => 'Inativo',
                  'DATA_NASCIMENTO' => '30/10/1988',
                  'DATA_ADMISSAO' => '17/10/2007',
                  'DATA_DEMISSAO' => '',
                  'ENDERECO' => ',',
                  'NUMERO_ENDERECO' => '0',
                  'BAIRRO' => '',
                  'UF' => '',
                  'CEP' => '',
                  'CODIGO_MUNICIPIO' => '0',
                ),
              );

            //session()->put('employees', $employeesData);

          //}

          $data = [];

          $companiesAlreadyLoaded = $companiesHasLoaded = [];

          //if(session()->has('companies')) {
            //$companiesHasLoaded = session()->get('companies');
          //}

          $companies = Client::where('active', true)->get();

          foreach ($companies as $key => $company) {

            echo '> Empresa: ' . $company->name . '<br/>';

            $companiesAlreadyLoaded[] = $company->id;
            $companiesHasLoaded = session('companies', $companiesAlreadyLoaded);

            $result = array_filter($employeesData, function($item) use ($company) {
                return $item['CODIGOEMPRESA'] == $company->code;
            });

            if(count($result) == $company->employees->count()) {
                //continue;
            }

            foreach ($result as $key => $item) {

                if($company) {

                  $birthDay = null;

                  if($item['DATA_NASCIMENTO']) {
                      $birthDay = \DateTime::createFromFormat('d/m/Y', $item['DATA_NASCIMENTO']);
                      $birthDay = $birthDay->format('Y-m-d');
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
                      echo '>> Funcionario ja importado : ' . $item['NOME'] . '<br/>';
                      $hasEmployee->update($data);
                  } else {
                      echo '>> Funcionario adicionado : ' . $item['NOME'] . '<br/>';
                      Employee::create($data);
                  }
                }

            }

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
}
