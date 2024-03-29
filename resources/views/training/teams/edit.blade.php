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
                    <li class="breadcrumb-item"><a href="#!">Editar</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
    <div class="card-header card bg-c-green update-card">
        <h5 class="text-white">Editar Turma</h5>
    </div>
    <div class="card-block">

      <form class="formValidation" data-parsley-validate method="post" action="{{route('teams.update', $team->uuid)}}">

          {{csrf_field()}}
          {{ method_field('PUT') }}

          <div class="row m-b-30">
              <div class="col-md-12">

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Curso</label>
                            <div class="input-group">
                              <select class="form-control select2" name="course_id" required>
                                  @foreach(\App\Helpers\Helper::courses()->sortBy('title') as $course)
                                        <option value="{{$course->uuid}}" {{ $team->course_id == $course->id ? 'selected' : '' }}>{{$course->title}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Instrutor</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <select class="form-control select2" name="teacher_id" required>
                                  @foreach($teachers->sortBy('name') as $teacher)
                                        <option value="{{$teacher->user->uuid}}" {{ $team->teacher_id == $teacher->id ? 'selected' : '' }}>{{$teacher->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="teacher_id">Data Inicio</label>
                          <div class="input-group">
                              <input type="text" class="input-md form-control inputDateTime" value="{{ $team->start ?  $team->start->format('d/m/Y H:i') : '' }}" name="start"/>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                          <label class="col-form-label" for="teacher_id">Data Fim</label>
                          <div class="input-group">
                              <input type="text" class="input-md form-control inputDateTime" value="{{ $team->end ?  $team->end->format('d/m/Y H:i') : '' }}" name="end"/>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-3">

                      <div class="form-group {!! $errors->has('vacancies') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="vacancies">Vagas</label>
                          <div class="input-group">
                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="{{ $team->vacancies }}" required>
                          </div>
                          {!! $errors->first('vacancies', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="col-md-3">
                      <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="status">Situação</label>
                          <div class="input-group">
                            <select class="form-control" name="status" required>
                                <option value="RESERVADO" {{ 'RESERVADO' == $team->status ? 'selected' : '' }}>RESERVADO</option>
                                <option value="EM ANDAMENTO" {{ 'EM ANDAMENTO' == $team->status ? 'selected' : '' }}>EM ANDAMENTO</option>
                                <option value="FINALIZADA" {{ 'FINALIZADA' == $team->status ? 'selected' : '' }}>FINALIZADA</option>
                                <option value="CANCELADA" {{ 'CANCELADA' == $team->status ? 'selected' : '' }}>CANCELADA</option>
                            </select>
                          </div>
                          {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" id="pac-card">
                            <label>Localização</label>
                            <div class="input-group" id="pac-container">
                                <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                <input class="form-control" name="localization" value="{{ $team->localization }}" id="pac-input">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar uma descrição</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                              <textarea class="form-control" rows="6" id="description" name="description">{{ $team->description }}</textarea>
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
