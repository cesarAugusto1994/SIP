@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Itens do Menu Pai</h4>
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
                        <a href="{{ route('menus.index') }}"> Menus </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Permissões</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Módulos Filhos de {{ $menu->title }}</h5>
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
                          <th>Ativo</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($menu->childs as $child)

                      <tr>

                          <td>{{ $child->title }}</td>
                          <td>{{ $child->permission }}</td>
                          <td>{{ $child->description }}</td>
                          <td>
                            @if($child->active)
                              <span class="badge badge-success">Ativo</span>
                            @else
                              <span class="badge badge-danger">Inativo</span>
                            @endif
                          </td>
                          <td>

                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('menus.edit', $child->id)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                    <div class="dropdown-divider"></div>
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
