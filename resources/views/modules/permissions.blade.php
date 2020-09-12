@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Permissões do Modulo</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('modules.index') }}"> Módulos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Permissõe</a>
                    </li>
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

                  @permission('create.clientes')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('permissions.create', ['module' => $module->id])}}"><i class="icofont icofont-paper-plane"></i> Nova Permissão</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  @if($module->children->isNotEmpty())
  <div class="card">
      <div class="card-header">
          <h5>Módulos Filhos de {{ $module->name }}</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>Nome</th>
                          <th>Slug</th>
                          <th>Descrição</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($module->children as $child)

                      <tr>

                          <td>{{ $child->name }}</td>
                          <td>{{ $child->slug }}</td>
                          <td>{{ $child->description }}</td>
                          <td>

                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('modules.edit', $child->id)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('modules.show', $child->id)}}"><i class="icofont icofont-key"></i> Permissões</a>
                                </div>
                            </div>

                          </td>

                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  @endif

  <div class="card">
      <div class="card-header">
          <h5>Permissões de {{ $module->name }}</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-inverse">
                          <th>Nome</th>
                          <th>Slug</th>
                          <th>Descrição</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($module->permissions as $permission)

                      <tr>

                          <td>{{$permission->name}}</td>
                          <td>{{$permission->slug}}</td>
                          <td>{{$permission->description}}</td>
                          <td>

                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('permissions.edit', $permission->id)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('module_permissions_users', ['id' => $module->id, 'permission' => $permission->id])}}"><i class="icofont icofont-users"></i> Usuários</a>
                                </div>
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

@endsection
