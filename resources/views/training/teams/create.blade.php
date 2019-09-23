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
                    <li class="breadcrumb-item"><a href="#!">Nova</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
    <div class="card-header">
        <h5>Nova Turma</h5>
    </div>
    <div class="card-block">

      <form class="formValidation" data-parsley-validate method="post" action="{{route('teams.store')}}">

          {{csrf_field()}}

          <div class="row m-b-30">
              <div class="col-md-12">

                <div class="row">

                    <div class="col-md-6">

                      <div class="form-group {!! $errors->has('course_id') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="course_id">Curso</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                            <select class="form-control select2" name="course_id" required>
                                @foreach($courses->sortBy('name') as $course)
                                      <option value="{{$course->uuid}}">{{$course->title}}</option>
                                @endforeach
                            </select>
                          </div>
                          {!! $errors->first('course_id', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-6">

                      <div class="form-group {!! $errors->has('teacher_id') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="teacher_id">Instrutor</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>
                            <select class="form-control select2" name="teacher_id" required>
                                @foreach($teachers->sortBy('name') as $teacher)
                                      <option value="{{$teacher->user->uuid}}">{{$teacher->name}}</option>
                                @endforeach
                            </select>
                          </div>
                          {!! $errors->first('teacher_id', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="teacher_id">Data Inicio</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class="input-md form-control inputDateTime" value="{{ now()->format('d/m/Y H:i') }}" name="start"/>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="teacher_id">Data Fim</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class="input-md form-control inputDateTime" value="{{ now()->addHours(2)->format('d/m/Y H:i') }}" name="end"/>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">

                      <div class="form-group {!! $errors->has('vacancies') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="vacancies">Vagas</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="20" required>
                          </div>
                          {!! $errors->first('vacancies', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar Funcionários</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select multiple class="form-control select-employees" name="employees[]" id="employees"></select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" id="pac-card">
                            <label>Localização</label>
                            <div class="input-group" id="pac-container">
                                <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                <input class="form-control" name="localization" id="pac-input">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar uma descrição</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                              <textarea class="form-control" rows="6" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
          </div>

          <button class="btn btn-success btn-sm">Salvar</button>
          <a class="btn btn-danger btn-sm" href="{{ route('teams.index') }}">Cancelar</a>
      </form>

    </div>
</div>

</div>

@endsection
