@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Editar Departamento</h4>
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
                        <a href="{{ route('departments.index') }}"> Departamentos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Departamentos</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('departments.update', ['id' => $department->uuid])}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" value="{{$department->name}}" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Resposável</label>
                      <div class="input-group">
                        <select class="form-control" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{$user->id}}" {{ $department->user_id == $user->id ? 'selected' : '' }}>{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>
            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('departments.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
