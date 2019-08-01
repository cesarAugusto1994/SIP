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
                    <li class="breadcrumb-item"><a href="#!">Adicionar</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
    <div class="card-header">
        <h5>Listagem de Turmas</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><a class="btn btn-sm btn-success btn-round" href="{{route('teams.create')}}">Novo</a></li>
            </ul>
        </div>
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
                            <select class="form-control" name="course_id" required>
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
                            <select class="form-control" name="teacher_id" required>
                                @foreach($teachers->sortBy('name') as $teacher)
                                      <option value="{{$teacher->user->uuid}}">{{$teacher->name}}</option>
                                @endforeach
                            </select>
                          </div>
                          {!! $errors->first('teacher_id', '<p class="help-block">:message</p>') !!}
                      </div>

                    </div>

                    <div class="span5 col-md-6" id="sandbox-container">
                      <label class="col-form-label" for="course_id">Data</label>
                      <div class="input-daterange input-group" id="datepicker">
                          <input type="text" class="input-md form-control inputDate" name="start" value="{{ now()->modify('+1 day')->format('d/m/Y') }}"/>
                          <div class="input-group-append">
                              <span class="input-group-text">Até</span>
                          </div>
                          <input type="text" class="input-md form-control inputDate" name="end" value="{{ now()->modify('+2 day')->format('d/m/Y') }}"/>
                      </div>
                    </div>

                    <div class="col-md-6">

                      <div class="form-group {!! $errors->has('vacancies') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="vacancies">Vagas</label>
                          <div class="input-group">
                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="20" required>
                          </div>
                          {!! $errors->first('vacancies', '<p class="help-block">:message</p>') !!}
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
