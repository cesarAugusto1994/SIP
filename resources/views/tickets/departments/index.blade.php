@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Chamados: Departamentos</h4>
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
                        <a href="{{ route('ticket-types.index') }}"> Tipos de Chamados </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">{{ $type->name }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Departamentos vinculados</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.tipo.de.chamados')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('ticket-type-departments.create', ['type_id' => $type->uuid])}}">Adicionar departamento</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($type->departments as $type)

                      <tr>
                          <td>{{$type->department->name}}</td>
                          <td class="text-right">
                              <a class="btn btn-danger btn-sm btn-round" href="{{ route('ticket-type-departments.destroy', $type->uuid) }}"><i class="fa fa-edit"></i> Remover</a>
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
