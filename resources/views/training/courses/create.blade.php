@extends('base')

@section('css')

@stop

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cursos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Cursos</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Adicionar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
        <div class="card-header">
            <h5>Novo Curso</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="feather icon-maximize full-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block">

          <form class="formValidation" data-parsley-validate method="post" action="{{route('courses.store')}}">

              {{csrf_field()}}

              <div class="row m-b-30">
                  <div class="col-md-12">

                    <div class="row">

                      <div class="col-md-6">

                          <div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="title">Titulo</label>
                              <div class="input-group">

                                  <input type="text" id="title" required name="title" class="form-control" autofocus placeholder="Informe o titulo">

                              </div>
                              {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                        <div class="col-md-3">
                          <div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="type">Tipo</label>
                              <div class="input-group">
                                <select class="form-control" name="type" required>
                                    <option value="Treinamento">Treinamento</option>
                                    <option value="Palestra">Palestra</option>
                                </select>
                              </div>
                              {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>

                        <div class="col-md-3">

                          <div class="form-group {!! $errors->has('workload') ? 'has-error' : '' !!}">
                              <label class="col-form-label"  for="workload">Carga Horária</label>
                              <div class="input-group">
                                  <input type="number" required id="workload" name="workload" class="form-control" value="10">

                              </div>
                              {!! $errors->first('workload', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group {!! $errors->has('ordinance') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="ordinance">Portaria</label>
                              <div class="input-group">
                                  <input type="text" id="ordinance" name="ordinance" class="form-control">
                              </div>
                              {!! $errors->first('ordinance', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group {!! $errors->has('ordinance_year') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="ordinance_year">Portaria Ano</label>
                              <div class="input-group">
                                  <input type="number" id="ordinance_year" name="ordinance_year" class="form-control">
                              </div>
                              {!! $errors->first('ordinance_year', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group {!! $errors->has('nbr') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="nbr">NBR</label>
                              <div class="input-group">
                                  <input type="text" id="nbr" name="nbr" class="form-control">
                              </div>
                              {!! $errors->first('nbr', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                        <div class="col-md-3">

                          <div class="form-group {!! $errors->has('nt') ? 'has-error' : '' !!}">
                              <label class="col-form-label" for="nt">NT</label>
                              <div class="input-group">
                                  <input type="text" id="nt" name="nt" class="form-control">
                              </div>
                              {!! $errors->first('nt', '<p class="help-block">:message</p>') !!}
                          </div>

                        </div>

                    </div>
                  </div>

                  <div class="col-md-12">

                    <div class="form-group {!! $errors->has('engineer_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="engineer_id">Engenheiro</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-users"></i></span>
                          <select class="form-control select2" name="engineer_id" required>
                              <option value="">Sem Engenheiro</option>
                              @foreach(\App\Helpers\Helper::users() as $user)
                                    <option value="{{$user->id}}">{{$user->person->name}}</option>
                              @endforeach
                          </select>
                        </div>
                        {!! $errors->first('engineer_id', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                  <div class="col-md-12">
                      <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="description">Descrição</label>
                          <div class="input-group">
                              <textarea name="description" required rows="4" class="form-control ckeditor"></textarea>
                          </div>
                          {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                      </div>

                  </div>
                  <div class="col-md-12">
                    <div class="form-group {!! $errors->has('grade') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="grade">Grade Curricular</label>
                        <div class="input-group">
                              <textarea name="grade" rows="4" class="form-control ckeditor"></textarea>
                        </div>
                        {!! $errors->first('grade', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                  <div class="col-md-3">
                      <div class="form-group {!! $errors->has('color') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="color">Cor de Fundo</label>
                          <div class="input-group">
                              <input type="color" required id="color" name="color" class="form-control" placeholder="Informe a cor de fundo">
                          </div>
                          {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
                      </div>
                  </div>

              </div>

              <button class="btn btn-success btn-sm">Salvar</button>
              <a class="btn btn-danger btn-outline btn-sm" href="{{ route('courses.index') }}">Cancelar</a>
          </form>

        </div>
    </div>

</div>

 @stop

 @section('scripts')

    <script type="text/javascript">

    </script>

 @stop
