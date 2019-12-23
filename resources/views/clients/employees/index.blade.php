@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Funcionários</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.cliente.funcionarios')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('employees.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Funcionário</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">
                <form method="get" action="?">
                    <input type="hidden" name="find" value="1"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="search" placeholder="Código do Funcionário, Nome, Documento">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="status">
                              <option value="">Situação</option>
                              <option value="1">Ativo</option>
                              <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5>Funcionários Cadastrados</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                              <th>Nome</th>
                              <th>Função</th>
                              <th>Documento</th>
                              <th>Status</th>
                              <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>

                                    <td>
                                        <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                        <br/>
                                        <a href="{{route('clients.show', \App\Helpers\Helper::actualCompany($employee)->uuid)}}"><small>{{ \App\Helpers\Helper::actualCompany($employee)->name }}</small></a>
                                    </td>

                                    <td>
                                        <p>{{$employee->name}}</p>
                                    </td>

                                    <td>
                                        <p>{{ \App\Helpers\Helper::formatCnpjCpf($employee->cpf) }}</p>
                                    </td>

                                    <td>
                                        <p class="text-{{$employee->active ? 'success' : 'danger'}}">{{$employee->active ? 'Ativo' : 'Inativo'}}</p>
                                    </td>

                                    <td class="dropdown">

                                      <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                      <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                        @permission('view.clientes')
                                          <a href="{{route('employees.show', ['id' => $employee->uuid])}}" class="dropdown-item">Visualizar </a>
                                        @endpermission

                                        @permission('edit.clientes')
                                          <a href="{{route('employees.edit', ['id' => $employee->uuid])}}" class="dropdown-item">Editar </a>
                                        @endpermission

                                      </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    @if(!empty($employees))
    {{ $employees->links() }}
    @endif
  </div>

</div>

@endsection
