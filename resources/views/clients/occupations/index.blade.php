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
                <li><a class="btn btn-sm btn-success btn-round" href="{{route('client-occupations.create')}}">Novo Cargo</a></li>
              </ul>
          </div>
      </div>
  </div>

  <div class="row">
    @foreach($occupations as $occupation)
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-block text-center">
                <h4 class="m-t-20">{{$occupation->name}}</h4>
                <p>{{$occupation->company->name}}</p>
                <hr/>
                <a class="btn btn-primary btn-sm btn-round" href="{{ route('client-occupations.edit', $occupation->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
            </div>
        </div>
    </div>
    @endforeach
  </div>

</div>

@endsection
