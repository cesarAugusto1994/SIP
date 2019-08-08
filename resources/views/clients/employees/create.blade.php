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
                    @if($company)
                      <li class="breadcrumb-item">
                          <a href="{{ route('clients.show', $company->uuid) }}"> Cliente </a>
                      </li>
                    @else
                      <li class="breadcrumb-item">
                          <a href="{{ route('employees.index') }}"> Funcionários </a>
                      </li>
                    @endif
                    <li class="breadcrumb-item"><a href="#!">Funcionários</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Novo Funcionário</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('employees.store')}}">

            {{csrf_field()}}

            <div class="row m-b-30">

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="name">Nome</label>
                        <div class="input-group">
                            <input type="text" required id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Informe o nome">
                        </div>
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>


                    <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="email">Email</label>
                        <div class="input-group">
                            <input type="text" id="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Informe o email">

                        </div>
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('occupation_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="company_id">Função</label>
                        <div class="input-group">
                            <select class="form-control" name="occupation_id" required>
                                  @foreach(\App\Helpers\Helper::clientOccupation() as $occupation)
                                      <option value="{{$occupation->uuid}}" {{ old('occupation_id') == $occupation->uuid ? 'selected' : '' }}>{{$occupation->name}}</option>
                                  @endforeach
                            </select>
                        </div>
                        {!! $errors->first('occupation_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('cpf') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="cpf">CPF</label>
                        <div class="input-group">
                            <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" class="form-control inputDocument" placeholder="Informe o CPF">
                        </div>
                        {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="phone">Telefone</label>
                        <div class="input-group">
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control inputPhone" placeholder="Informe o Telefone">

                        </div>
                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="company_id">Empresa</label>
                        <div class="input-group">
                            <select class="form-control" name="company_id" required>
                                  @foreach($companies as $companyItem)
                                      <option value="{{$companyItem->uuid ?? ''}}" {{ !empty($company) && $company->uuid == $companyItem->uuid || old('company_id') == $companyItem->uuid ? 'selected' : '' }}>{{$companyItem->name}}</option>
                                  @endforeach
                            </select>
                        </div>
                        {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="active">Ativo</label>
                        <div class="input-group">
                            <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" checked value="{{ 1 }}">
                        </div>
                        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            @if($company)
              <a class="btn btn-danger btn-sm" href="{{ route('clients.show', $company->uuid) }}">Cancelar</a>
            @else
              <a class="btn btn-danger btn-sm" href="{{ route('employees.index') }}">Cancelar</a>
            @endif
        </form>

      </div>
  </div>

</div>

@endsection
