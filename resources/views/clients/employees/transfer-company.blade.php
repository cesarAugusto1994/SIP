@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários: Transferência de Empresa</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Transferir</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Transferir Funcionário</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('employee_transfer_company_store', $employee->uuid)}}">

            {{csrf_field()}}

            <input type="hidden" name="old_company_id" value="{{ \App\Helpers\Helper::actualCompany($employee)->uuid }}"/>

            <div class="row m-b-30">

              <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label" for="company_id">Empresa Atual</label>
                      <div class="input-group">
                          {{ \App\Helpers\Helper::actualCompany($employee)->name ?? '' }}
                      </div>
                  </div>
              </div>

              <div class="col-md-2">
                  <div class="form-group {!! $errors->has('fired_at') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="fired_at">Desligamento</label>
                      <div class="input-group">
                          <input type="text" name="fired_at" class="form-control inputDate" placeholder="Informe a data de Desligamento">
                      </div>
                      {!! $errors->first('fired_at', '<p class="help-block">:message</p>') !!}
                  </div>
              </div>

            </div>

            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Nova Empresa</h6>

            <div class="row m-b-30">

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="company_id">Empresa</label>
                        <div class="input-group">
                            <select class="form-control select-client" name="company_id" data-url="{{ route('client_search') }}" required></select>
                        </div>
                        {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group {!! $errors->has('hired_at') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="hired_at">Admissão</label>
                        <div class="input-group">
                            <input type="text" name="hired_at" class="form-control inputDate" placeholder="Informe a data de Admissão">
                        </div>
                        {!! $errors->first('hired_at', '<p class="help-block">:message</p>') !!}
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
