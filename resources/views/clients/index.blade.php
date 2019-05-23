@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Clientes</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Clientes</a></li>
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
          <h5>Lista de Cleintes</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><a class="btn btn-sm btn-success btn-round" href="{{route('clients.create')}}">Novo</a></li>
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

          @if($clients->isNotEmpty())
            <div class="table-responsive">

              <table class="table table-hover">
                  <thead>

                    <tr>
                      <th>ID</th>
                      <th>Nome</th>
                      <th>Documento</th>
                      <th>Telefone</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>

                  </thead>

                  <tbody>
                      @foreach($clients as $client)
                          <tr>

                              <td>
                                  <a>{{$client->id}}</a>
                              </td>

                              <td>
                                  <a href="{{route('clients.show', ['id' => $client->uuid])}}">{{$client->name}}</a>
                              </td>

                              <td>
                                  <a>{{$client->document}}</a>
                              </td>

                              <td>
                                  <a>{{$client->phone}}</a>
                              </td>

                              <td>
                                  <a>{{$client->email}}</a>
                              </td>

                              <td>
                                @if($client->active)
                                  <span class="badge badge-success">Ativo</span>
                                @else
                                  <span class="badge badge-danger">Inativo</span>
                                @endif
                              </td>

                              <td class="dropdown">

                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                  @permission('view.clientes')
                                    <a href="{{route('clients.show', ['id' => $client->uuid])}}" class="dropdown-item">Visualizar </a>
                                  @endpermission

                                  @permission('edit.clientes')
                                    <a href="{{route('clients.edit', ['id' => $client->uuid])}}" class="dropdown-item">Editar </a>
                                  @endpermission

                                  @permission('delete.clientes')
                                    <a href="#!" data-route="{{route('clients.destroy', ['id' => $client->uuid])}}" class="dropdown-item btnRemoveItem">Remover </a>
                                  @endpermission

                                </div>
                              </td>


                          </tr>
                      @endforeach
                  </tbody>
              </table>

              <div class="text-center">
              {{ $clients->links() }}
              </div>
            </div>
          @else

              <div class="widget white-bg no-padding text-center">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-3x"></i></h1>
                      <h4 class="font-bold no-margins">
                          Nenhum registro encontrado para o parametros informados.
                      </h4>
                  </div>
              </div>

          @endif

      </div>
  </div>

</div>

@endsection
