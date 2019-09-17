@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Categoria de Chamados</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Categoria de Chamados</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.categoria.de.chamados')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('ticket-type-categories.create')}}">Nova Categoria</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block table-border-style">

        <div class="table-responsive">
            <table class="table table-lg table-styling">
                <thead>
                    <tr class="table-primary">
                        <th>Nome</th>
                        <th>Situação</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($categories as $category)

                      <tr>
                          <td>{{$category->name}}</td>
                          <td>
                              @if($category->active)
                                  <label class="label label-inverse-success">Ativo</label>
                              @else
                                  <label class="label label-inverse-danger">Inativo</label>
                              @endif
                          </td>
                          <td class="text-right">
                            @permission('edit.categoria.de.chamados')
                              <a class="btn btn-primary btn-sm btn-round" href="{{ route('ticket-type-categories.edit', $category->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                            @endpermission
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
