@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipo de Recado</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tipo de Recado</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Tipos de Recados</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.tipos.de.recados')
                    <a href="{{route('message-types.create')}}" class="btn btn-sm btn-success btn-round">Novo Tipo de Recado</a>
                  @endpermission

              </ul>
          </div>
      </div>
  </div>

  <div class="row">
    @foreach($types as $type)
      <div class="col-md-12 col-lg-4">
          <div class="card">
              <div class="card-block text-center">
                  <h4 class="m-t-20">{{$type->name}}</h4>
                  <a class="btn btn-primary btn-sm btn-round" href="{{route('message-types.edit', ['id' => $type->uuid])}}"><i class="fa fa-edit"></i> Editar</a>
              </div>
          </div>
      </div>
    @endforeach
  </div>

</div>

@endsection
