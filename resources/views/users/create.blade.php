@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Usuários</h4>
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
                        <a href="{{ route('users') }}"> Usuários </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
          <div class="card-header">
              <h5>Novo Usuário</h5>
          </div>
          <div class="card-block">

            <form class="formValidation" method="post" action="{{route('users.store')}}" data-parsley-validate>

                {{csrf_field()}}

                <div class="row m-b-30">

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Nome</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{ old('name') }}" name="name" class="form-control">
                          </div>
                          {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                      </div>

                      <div class="form-group {!! $errors->has('cpf') ? 'has-error' : '' !!}">
                          <label class="col-form-label">CPF</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{ old('cpf') }}" name="cpf" class="form-control inputCpf">
                          </div>
                          {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                          <label class="col-form-label">E-mail</label>
                          <div class="input-group">
                            <input type="email" required autocomplete="off" data-parsley-type="email" value="{{ old('email') }}" name="email" class="form-control">
                          </div>
                          {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                      </div>

                      <div class="form-group {!! $errors->has('birthday') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Nascimento</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{ old('birthday') }}" name="birthday" class="form-control inputDate" autocomplete="off" data-date-end-date="0d">
                          </div>
                          {!! $errors->first('birthday', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Telefone</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{ old('phone') }}" name="phone" class="form-control inputPhone">
                          </div>
                          {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                      </div>
                      <div class="form-group {!! $errors->has('branch') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Ramal</label>
                          <div class="input-group">
                            <input type="text" required autocomplete="off" value="{{ old('branch') }}" name="branch" class="form-control">
                          </div>
                          {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                </div>

                <div class="row m-b-30">

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('department_id') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Departamento</label>
                          <div class="input-group">
                            <select class="form-control select-occupations" name="department_id" data-search-occupations="{{ route('occupation_search') }}" required>
                              @foreach($departments as $department)
                                  <option value="{{$department->uuid}}">{{$department->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          {!! $errors->first('department_id', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('occupation_id') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Cargo</label>
                          <div class="input-group">
                            <select class="form-control occupation" id="occupation" name="occupation_id" required>
                              @foreach($occupations as $occupation)
                                  <option value="{{$occupation->uuid}}">{{$occupation->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          {!! $errors->first('occupation_id', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('unit_id') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Unidade</label>
                          <div class="input-group">
                            <select class="form-control" id="unit" name="unit_id" required>
                              @foreach($units as $unit)
                                  <option value="{{$unit->uuid}}">{{$unit->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          {!! $errors->first('unit_id', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                </div>

                <div class="row m-b-30">

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Previlégio</label>
                          <div class="input-group">
                            <select id="roles" name="roles" required class="form-control">
                              @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                              @endforeach
                            </select>
                          </div>
                          {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Senha de Acesso</label>
                          <div class="input-group">
                            <input type="password" autocomplete="off" value="{{ old('password') }}" name="password" class="form-control">
                          </div>
                          {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group {!! $errors->has('password_email') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Senha do E-mail</label>
                          <div class="input-group">
                            <input type="password" autocomplete="off" value="{{ old('password_email') }}" name="password_email" class="form-control">
                          </div>
                          {!! $errors->first('password_email', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-4">

                      <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Ativo</label>
                          <div class="input-group">
                            <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" {{ old('active') || !request()->has('active') ? 'checked' : '' }} name="active" class="js-switch">
                          </div>
                          {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
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
