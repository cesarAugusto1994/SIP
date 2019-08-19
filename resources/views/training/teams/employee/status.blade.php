@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Turmas</h4>
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
                        <a href="{{ route('teams.index') }}"> Turmas</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">ditar Situação</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
    <div class="card-header">
        <h5>Editar Situação do Participante: {{ $employee->employee->name }}</h5>
    </div>
    <div class="card-block">

      <form class="formValidation" data-parsley-validate method="post" action="{{route('teams_employee_status_update', [$employee->uuid])}}">

        {{csrf_field()}}
        {{method_field('PUT')}}

        <div class="row m-b-30">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label class="col-form-label" for="status">Situação</label>
                          <div class="input-group">
                            <select class="form-control" name="status" id="status-employee-" required>
                                  <option value="AGENDADO" {{ $employee->status == 'AGENDADO' ? 'selected' : '' }}>AGENDADO</option>
                                  <option value="PRESENTE" {{ $employee->status == 'PRESENTE' ? 'selected' : '' }}>PRESENTE</option>
                                  <option value="FALTA" {{ $employee->status == 'FALTA' ? 'selected' : '' }}>FALTA</option>
                            </select>
                          </div>
                      </div>
                  </div>
              </div>

        <button class="btn btn-success btn-sm">Salvar</button>
        <a class="btn btn-danger btn-sm" href="{{ route('teams.show', $employee->team->uuid) }}">Cancelar</a>

      </form>

    </div>
</div>

</div>

@endsection
