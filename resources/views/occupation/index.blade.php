@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cargos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Cargos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Cargos</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.cargos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('occupations.create')}}">Novo Cargo</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th>Cargo</th>
                        <th>Departamento</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @forelse($occupations as $occupation)

                      <tr>
                          <td>{{$occupation->name}}</td>
                          <td>{{$occupation->department->name}}</td>
                          <td class="text-right">
                              <a class="btn btn-primary btn-sm btn-round" href="{{ route('occupations.edit', $occupation->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                              <button class="btn btn-danger btn-sm btn-round btnRemoveItem" data-route="{{route('occupations.destroy', ['id' => $occupation->uuid])}}"><i class="fa fa-close"></i> Remover</button>
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
