@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários: Mudar de Função</h4>
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
                        <a href="{{ route('employees.show', $employee->uuid) }}"> Informações </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Mudar Função</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Mudar Função do Funcionário</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('employee_occupation_change_store', $employee->uuid)}}">

            {{csrf_field()}}

            <input type="hidden" name="old_occupation_id" value="{{ \App\Helpers\Helper::actualOccupation($employee)->uuid }}"/>

            <div class="row m-b-30">

              <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label" for="company_id">Função Atual</label>
                      <div class="input-group">
                          {{ \App\Helpers\Helper::actualOccupation($employee)->name ?? '' }}
                      </div>
                  </div>
              </div>

            </div>

            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Nova Função</h6>

            <div class="row m-b-30">

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('occupation_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="occupation_id">Função</label>
                        <div class="input-group">
                            <select class="form-control fetch-occupations" name="occupation_id" data-url="{{ route('occupation_search') }}" required></select>
                        </div>
                        {!! $errors->first('occupation_id', '<p class="help-block">:message</p>') !!}
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
