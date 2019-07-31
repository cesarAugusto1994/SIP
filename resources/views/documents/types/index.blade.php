@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Documentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tipos de Documentos</a>
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
                @permission('create.tipo.de.documentos')
                  <a href="{{route('types.create')}}" class="btn btn-success">Novo Tipo</a>
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
                <p class="m-b-20">{{number_format($type->price, 2, ',', '')}}</p>
                <a class="btn btn-primary btn-sm btn-round" href="{{route('types.edit', ['id' => $type->uuid])}}"><i class="fa fa-edit"></i> Editar</a>
            </div>
        </div>
    </div>
    @endforeach
  </div>

</div>

@endsection
