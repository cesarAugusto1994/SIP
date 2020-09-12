@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários</h4>
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
                        <a href="{{ route('employees.index') }}"> Funcionários </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('employees.show', $employee->uuid) }}"> {{ $employee->name }} </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Editar Funcionário</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('employees.update', $employee->uuid)}}">

            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="name">Nome</label>
                        <div class="input-group">
                            <input type="text" id="name" required name="name" value="{{ $employee->name }}" class="form-control" placeholder="Informe o nome">
                        </div>
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="active">Ativo</label>
                        <div class="input-group">
                            <input class="js-switch" type="checkbox" id="active" name="active" {{ $employee->active ? 'checked' : '' }} data-plugin="switchery" value="{{ 1 }}">
                        </div>
                        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('cpf') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="cpf">CPF</label>
                        <div class="input-group">
                            <input type="text" id="cpf" name="cpf" value="{{ $employee->cpf }}" class="form-control inputCpf" placeholder="Informe o CPF">
                        </div>
                        {!! $errors->first('document', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('document') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="email">Email</label>
                        <div class="input-group">
                            <input type="text" id="email" name="email" value="{{ $employee->email }}" class="form-control" placeholder="Informe o email">
                        </div>
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>



                </div>

                <div class="col-md-4">

                    <div class="form-group {!! $errors->has('rg') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="rg">RG</label>
                        <div class="input-group">
                            <input type="text" id="cpf" name="rg" value="{{ $employee->rg }}" class="form-control" placeholder="Informe o RG">
                        </div>
                        {!! $errors->first('rg', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="phone">Telefone</label>
                        <div class="input-group">
                            <input type="text" id="phone" name="phone" value="{{ $employee->phone }}" class="form-control" placeholder="Informe o Telefone">
                        </div>
                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('employees.show', $employee->uuid) }}">Cancelar</a>
        </form>

      </div>
  </div>
</div>

@endsection
