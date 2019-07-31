@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Documentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('documents.index') }}">Documentos</a>
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
          <h5>Novo Documento</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('documents.store')}}">
            {{csrf_field()}}

            <input type="hidden" name="indexes" id="indexes" value=""/>

            <div class="row m-b-30">

                <div class="col-md-3">

                    <div class="form-group {!! $errors->has('type_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tipo</label>
                        <div class="input-group">
                          <select class="form-control" title="Selecione" name="type_id" required>
                              <option value="">Selecione...</option>
                              @foreach($types as $type)
                                  <option value="{{$type->uuid}}">{{$type->name}}</option>
                              @endforeach
                          </select>
                        </div>
                        {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-3">
                    <div class="form-group {!! $errors->has('type_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Referencia</label>
                        <div class="input-group">
                          <input type="text" name="reference" class="form-control" placeholder="Código de referencia do documento"/>
                        </div>
                        {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                      <label class="col-form-label">Cliente</label>
                      <div class="input-group">
                        <select class="form-control"
                          name="client_id" required>
                              <option value="">Selecione um Cliente</option>
                              @foreach($clients as $client)
                                  <option value="{{$client->uuid}}">{{$client->name}}</option>
                              @endforeach
                        </select>
                      </div>
                      {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Funcionário</label>
                      <div class="input-group">
                        <select class="form-control"
                          name="employee_id">
                              <option value="">Selecione um Funcionário</option>
                              @foreach(\App\Helpers\Helper::employees()->sortBy('name') as $emloyee)
                                  <option value="{{$emloyee->uuid}}">{{$emloyee->name}}</option>
                              @endforeach
                        </select>
                      </div>
                  </div>
                </div>

            </div>

            <div id="rowForm"></div>

            <button type="button" id="btnAddRows" class="btn btn-primary btn-sm">Adicionar Linha</button>
            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('documents.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

      var row = $("#rowForm");
      var btnAddRows = $("#btnAddRows");
      var indexes = $("#indexes");

      var index = 0;

      function renderCols(index) {

        return '<div class="row" id="row-'+index+'">'
            + '<div class="col-md-1">'
              +   '<div class="form-group">'
              + '<label class="col-form-label">Opç</label>'
                    + '<button type="button" class="btn btn-danger btn-sm btn-block btnRmItem" data-item="'+index+'"><i class="fa fa-ban"></i></button>'
                + '</div>'
            + '</div>'
             + '<div class="col-md-3">'
                 + '<div class="form-group">'
                     + '<label class="col-form-label">Tipo</label>'
                     + '<div class="input-group">'
                       + '<select class="form-control" title="Selecione" name="type_id-'+index+'" required>'
                          + '<option value="">Selecione...</option>'
                           @foreach($types as $type)
                               + '<option value="{{$type->uuid}}">{{$type->name}}</option>'
                           @endforeach
                      + '</select>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="col-md-2">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">Referencia</label>'
                    + '<div class="input-group">'
                      + '<input type="text" name="reference-'+index+'" class="form-control" placeholder="Código de referencia do documento"/>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="col-md-3">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Cliente</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control"'
                      + 'name="client_id-'+index+'" required>'
                          + '<option value="">Selecione um Cliente</option>'
                          @foreach($clients as $client)
                              + '<option value="{{$client->uuid}}">{{$client->name}}</option>'
                          @endforeach
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
            + '<div class="col-md-3">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Funcionário</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control"'
                      + 'name="employee_id-'+index+'">'
                          + '<option value="">Selecione um Funcionário</option>'
                          @foreach(\App\Helpers\Helper::employees()->sortBy('name') as $emloyee)
                              + '<option value="{{$emloyee->uuid}}">{{$emloyee->name}}</option>'
                          @endforeach
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
        + '</div>';

      }

      btnAddRows.click(function() {
        index++;
        row.append(renderCols(index));
        indexes.val(index);
      });

      var btnRmItem = $(".btnRmItem");

      $(document).on('click','.btnRmItem',function(){
        console.log('item');
        var self = $(this);
        $("#row-" + self.data('item')).remove();
      });

  </script>

@endsection
