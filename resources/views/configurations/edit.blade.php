@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Configurações</h4>
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
                        <a href="{{ route('configurations.index') }}"> Configurações </a>
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
          <h5>Editar Configuração</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate role="form" method="post" action="{{ route('configurations.update', $config->id) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="box-body">
              <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $config->name }}">
              </div>

              <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" class="form-control" id="description" name="description" value="{{ $config->description }}">
              </div>

              <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
                <label for="tipo_pessoa_id">Tipo</label>
                <select class="form-control" id="type_id" name="type_id" placeholder="Tipo">
                  @foreach($types as $item)
                      <option value="{{ $item->id }}" {{ $config->type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('type_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('type_id') }}</strong>
                  </span>
                @endif
              </div>

              @if($config->type_id == 1)
                <div class="form-group">
                  <label for="value">Valor</label>
                  <input type="text" class="form-control" id="value" name="value" value="{{ $config->value }}">
                </div>
              @elseif($config->type_id == 2)
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="active" value="1" {{ $config->valor ? 'checked' : '' }}> Habilitado
                  </label>
                </div>
              @elseif($config->type_id == 3)
                <div class="form-group">
                  <label for="value">Valor</label>
                  <input type="file" class="form-control filestyle" data-size="md" data-buttontext="Selecione um arquivo" data-buttonname="btn-default" id="value" name="value"/>
                </div>
              @elseif($config->type_id == 4)

              @elseif($config->type_id == 5)
                <div class="form-group">
                  <label for="value">Valor</label>
                  <textarea id="value" name="value" class="form-control summernote">{{ $config->valor }}</textarea>
                </div>
              @endif

                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="active" value="1" data-plugin="switchery" {{ $config->active ? 'checked' : '' }}> active
                  </label>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('configurations.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

        <div class="card-box">



        </div>

@stop
