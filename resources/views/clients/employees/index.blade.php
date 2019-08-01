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

  <div class="card">
      <div class="card-header">
          <h5>Pesquisa</h5>
      </div>
      <div class="card-block">

        <form method="get" action="?">
          <div class="row">
              <div class="col-md-5"><input name="search" type="text" placeholder="ID, Nome, Documento, Email, ou Telefone" class="form-control"></div>
              <div class="col-md-2">
                <select class="form-control" data-live-search="true" title="Situação" data-style="btn-white" data-width="100%" placeholder="Situação" name="status">
                    <option value="">Situação</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
              </div>
              <div class="col-md-3"><input name="address" type="text" placeholder="CEP, Endereço" class="form-control"></div>
              <div class="col-md-2"><button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i>  Buscar</button></div>

          </div>
        </form>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Lista de Funcionários</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><a class="btn btn-sm btn-success btn-round" href="{{route('employees.create')}}">Novo Funcionário</a></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

          @if($employees->isNotEmpty())
            <div class="table-responsive">

              <table class="table table-hover">
                  <thead>

                    <tr>
                      <th>Nome</th>
                      <th>Função</th>
                      <th>Documento</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>

                  </thead>

                  <tbody>
                      @foreach($employees->sortByDesc('id') as $employee)
                          <tr>

                              <td>
                                  <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                  <br/>

                                  <a href="{{route('clients.show', $employee->company->uuid)}}"><small>{{$employee->company->name}}</small></a>

                              </td>

                              <td>
                                  <p>{{$employee->occupation->name}}</p>
                              </td>

                              <td>
                                  <p>{{$employee->cpf}}</p>
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

              <div class="text-center">
              {{ $employees->links() }}
              </div>
            </div>
          @else

              <div class="widget white-bg no-padding text-center">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                      <h6 class="font-bold no-margins">
                          Nenhum registro encontrado para o parametros informados.
                      </h6>
                  </div>
              </div>

          @endif

      </div>
  </div>

</div>

@endsection
