@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Functionários</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Conceder Acesso ao Cliente</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
          <div class="card-header">
              <h5>Conceder Acesso ao Cliente</h5>
          </div>
          <div class="card-block">

            <form class="formValidation" method="post" action="{{route('users.store')}}" data-parsley-validate>

                {{csrf_field()}}

                <div class="row m-b-30">

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Nome</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{$employee->name}}" name="name" class="form-control">
                          </div>
                          {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                      </div>

                      <div class="form-group {!! $errors->has('cpf') ? 'has-error' : '' !!}">
                          <label class="col-form-label">CPF</label>
                          <div class="input-group">
                            <input type="text" autocomplete="off" readonly value="{{$employee->cpf}}" name="cpf" class="form-control inputCpf">
                          </div>
                          {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                          <label class="col-form-label">E-mail</label>
                          <div class="input-group">
                            <input type="email" required readonly autocomplete="off" data-parsley-type="email" value="{{$employee->email}}" name="email" class="form-control">
                          </div>
                          {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Telefone</label>
                          <div class="input-group">
                            <input placeholder="Campo Opcional" type="text" autocomplete="off" value="{{$employee->phone}}" name="phone" class="form-control inputPhone">
                          </div>
                          {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                </div>

                <button class="btn btn-success btn-sm">Salvar</button>
                <a class="btn btn-danger btn-sm" href="{{ route('users') }}">Cancelar</a>
            </form>

          </div>
    </div>

</div>

@endsection
