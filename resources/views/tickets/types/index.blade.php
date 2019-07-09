@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Chamados</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tipos de Chamados</a>
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

                  @permission('create.tipo.de.chamados')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('ticket-types.create')}}">Novo Tipo</a></li>
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
                        <th>Categoria</th>
                        <th>Departmentos</th>
                        <th>Situação</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach(\App\Helpers\Helper::ticketTypes() as $type)

                      <tr>
                          <td>{{$type->name}}</td>
                          <td>{{$type->category->name ?? ''}}</td>
                          <td>
                              @foreach($type->departments as $depto)
                                  <span class="label label-inverse-primary">{{ $depto->department->name }}</span><br/><br/>
                              @endforeach
                          </td>
                          <td>
                              @if($type->active)
                                  <label class="label label-inverse-success">Ativo</label>
                              @else
                                  <label class="label label-inverse-danger">Inativo</label>
                              @endif
                          </td>
                          <td class="text-right">
                              <a class="btn btn-primary btn-sm btn-round" href="{{ route('ticket-types.edit', $type->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
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
