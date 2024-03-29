@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Departamentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Departamentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Departamentos</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.departamentos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('departments.create')}}">Novo Departamento</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
  </div>

  <div class="row">
    @foreach($departments as $department)
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-block text-center">
                <h4 class="m-t-20">{{$department->name}}</h4>
                <p class="m-b-20">{{$department->user->person->name ?? ''}}</p>
                <a class="btn btn-success btn-sm btn-round" href="{{ route('occupations.index', ['department' => $department->uuid]) }}"><i class="fa fa-tag"></i> ({{ $department->occupations->count() }}) Cargos</a>
                <a class="btn btn-primary btn-sm btn-round" href="{{ route('departments.edit', $department->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
            </div>
        </div>
    </div>
    @endforeach
  </div>

</div>

@endsection
