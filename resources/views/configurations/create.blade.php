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
                    <li class="breadcrumb-item"><a href="#!">Novo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Nova Configuração</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate role="form" method="post" action="{{ route('configurations.store') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box-body">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="nome">Nome</label>
              <input type="text" class="form-control" id="name" name="name" required/>
              {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
              <label for="nome">Descrição</label>
              <input type="text" class="form-control" id="description" name="description">
              {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group{{ $errors->has('type_id') ? ' has-error' : '' }}">
              <label for="type_id">Tipo</label>
              <select class="select2" id="type_id" name="type_id" placeholder="Tipo">
                @foreach($types as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
              {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group valores" id="config-1">
              <label for="cidade">Valor</label>
              <input type="text" class="form-control" id="value" name="value" value="">
              {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="checkbox valores" id="config-2">
              <label>
                <input type="checkbox" name="ativo" data-plugin="switchery" value="1"> Habilitado
              </label>
            </div>

            <div class="form-group valores" id="config-3">
              <label for="value">Valor</label>
              <input type="file" class="form-control filestyle" data-size="md" data-buttontext="Selecione um arquivo" data-buttonname="btn-default" id="value" name="value"/>
              {!! $errors->first('value', '<p class="help-block">:message</p>') !!}
            </div>

            <div class="form-group">
              <label for="value">Ativo</label>
              <input type="checkbox" name="active" value="1" data-plugin="switchery" checked/>
              {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
            </div>

            <br/>
            <br/>

            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('configurations.index') }}">Cancelar</a>

          </div>
        </form>

      </div>
  </div>
</div>

@stop

@section('scripts')

  <script>

    function habilitarValor() {

      $('.valores').hide();

      var tipo = $("#type_id").val();

      $("#config-"+tipo).show();

    }

    $(document).ready(function() {

      habilitarValor();

      $("#type_id").change(function() {
        habilitarValor();
      });

    });

  </script>

@stop
