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
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
        <div class="card-header">
            <h5>Editar Curso</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="feather icon-maximize full-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block">

              <form class="formValidation" data-parsley-validate method="post" action="{{route('courses.update', $course->uuid)}}">

                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="row m-b-30">
                    <div class="col-md-12">

                      <div class="row">

                          <div class="col-md-6">

                            <div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="title">Titulo</label>
                                <div class="input-group">
                                    <input type="text" id="title" name="title" required value="{{ $course->title }}" class="form-control" autofocus placeholder="Informe o titulo">
                                </div>
                                {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-3">
                            <div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="type">Tipo</label>
                                <div class="input-group">
                                  <select class="form-control select2" name="type" required>
                                      <option value="Treinamento" {{ 'Treinamento' == $course->type ? 'selected' : '' }}>Treinamento</option>
                                      <option value="Palestra" {{ 'Palestra' == $course->type ? 'selected' : '' }}>Palestra</option>
                                  </select>
                                </div>
                                {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                            </div>
                          </div>

                          <div class="col-md-3">

                            <div class="form-group {!! $errors->has('workload') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="workload">Carga Horária</label>
                                <div class="input-group">
                                    <input type="number" id="workload" required name="workload" value="{{ $course->workload }}" class="form-control" value="10">
                                </div>
                                {!! $errors->first('workload', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-3">

                            <div class="form-group {!! $errors->has('ordinance') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="ordinance">Portaria</label>
                                <div class="input-group">
                                    <input type="text" id="ordinance" name="ordinance" value="{{ $course->ordinance }}" class="form-control">
                                </div>
                                {!! $errors->first('ordinance', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-3">

                            <div class="form-group {!! $errors->has('ordinance_year') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="ordinance_year">Portaria Ano</label>
                                <div class="input-group">
                                    <input type="number" id="ordinance_year" name="ordinance_year" value="{{ $course->ordinance_year }}" class="form-control">
                                </div>
                                {!! $errors->first('ordinance_year', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-3">

                            <div class="form-group {!! $errors->has('nbr') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="nbr">NBR</label>
                                <div class="input-group">
                                    <input type="text" id="nbr" name="nbr" value="{{ $course->nbr }}" class="form-control">
                                </div>
                                {!! $errors->first('nbr', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-3">

                            <div class="form-group {!! $errors->has('nt') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="nt">NT</label>
                                <div class="input-group">
                                    <input type="text" id="nt" name="nt" value="{{ $course->nt }}" class="form-control">
                                </div>
                                {!! $errors->first('nt', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                          <div class="col-md-12">

                            <div class="form-group {!! $errors->has('engineer_id') ? 'has-error' : '' !!}">
                                <label class="col-form-label" for="engineer_id">Engenheiro</label>
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                  <select class="form-control select2" name="engineer_id" required>
                                      @foreach(\App\Helpers\Helper::users() as $user)
                                            <option value="{{$user->id}}" {{ $course->engineer_id == $user->id ? 'selected' : '' }}>{{$user->person->name}}</option>
                                      @endforeach
                                  </select>
                                </div>
                                {!! $errors->first('engineer_id', '<p class="help-block">:message</p>') !!}
                            </div>

                          </div>

                      </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                            <label class="col-form-label" for="description">Descrição</label>
                            <div class="input-group">
                                <textarea name="description" required rows="4" class="form-control ckeditor">{{ $course->description }}</textarea>
                            </div>
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>
                    <div class="col-md-12">
                      <div class="form-group {!! $errors->has('grade') ? 'has-error' : '' !!}">
                          <label class="col-form-label" for="grade">Grade Curricular</label>
                          <div class="input-group">
                                <textarea name="grade" rows="4" class="form-control ckeditor">{{ $course->grade }}</textarea>
                          </div>
                          {!! $errors->first('grade', '<p class="help-block">:message</p>') !!}
                      </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group {!! $errors->has('color') ? 'has-error' : '' !!}">
                            <label class="col-form-label" for="color">Cor de Fundo</label>
                            <div class="input-group">
                                <input type="color" required id="color" value="{{ $course->color }}" name="color" class="form-control" placeholder="Informe a cor de fundo">
                            </div>
                            {!! $errors->first('color', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                </div>

                <button class="btn btn-success">Salvar</button>
                <a class="btn btn-danger" href="{{ route('courses.index') }}">Cancelar</a>
            </form>
        </div>
    </div>

</div>

 @stop

 @section('scripts')

 <script>
    CKEDITOR.replace( 'editor', {
        // Define the toolbar: http://docs.ckeditor.com/#!/guide/dev_toolbar
        // The standard preset from CDN which we used as a base provides more features than we need.
        // Also by default it comes with a 2-line toolbar. Here we put all buttons in a single row.
        toolbar: [{
            name: 'clipboard',
            items: ['Undo', 'Redo']
        }, {
            name: 'styles',
            items: ['Styles', 'Format']
        }, {
            name: 'basicstyles',
            items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
        }, {
            name: 'paragraph',
            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
        }, {
            name: 'links',
            items: ['Link', 'Unlink']
        }, {
            name: 'insert',
            items: ['Image', 'EmbedSemantic', 'Table']
        }, {
            name: 'tools',
            items: ['Maximize']
        }, {
            name: 'editing',
            items: ['Scayt']
        }],
    });
 </script>

 @stop
