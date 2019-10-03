@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Menus</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Menus</a>
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
                  <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('menus.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Menu</a>
              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Menus</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>Nome</th>
                          <th>Slug Permissão</th>
                          <th>Descrição</th>
                          <th>Ativo</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($menus as $menu)

                      <tr>

                          <td><a href="{{route('menus.show', $menu->id)}}">{{$menu->title}}</a></td>
                          <td>{{$menu->permission}}</td>
                          <td>{{$menu->description}}</td>

                          <td>
                            @if($menu->active)
                              <span class="badge badge-success">Ativo</span>
                            @else
                              <span class="badge badge-danger">Inativo</span>
                            @endif
                          </td>

                          <td>

                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('menus.edit', $menu->id)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('menus.show', $menu->id)}}"><i class="icofont icofont-ui-edit"></i> Menus e Permissões</a>
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
