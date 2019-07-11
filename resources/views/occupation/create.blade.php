@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Novo Cargo</h4>
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
                        <a href="{{ route('occupations.index') }}"> Cargos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Novo Cargos</h5>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('occupations.store')}}">
            {{csrf_field()}}

            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group"><label class="col-form-label">Nome</label>
                      <div class="input-group"><input type="text" name="name" class="form-control" autofocus required/></div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group"><label class="col-form-label">Departamento</label>
                      <div class="input-group">
                        <select class="form-control" name="department_id">
                            @foreach($departments as $department)
                                <option value="{{$department->uuid}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('occupations.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
