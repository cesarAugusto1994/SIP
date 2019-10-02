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



<form class="formValidation" data-parsley-validate method="post" action="{{route('documents.store')}}">
{{csrf_field()}}

<div class="card">
    <div class="card-header bg-c-green update-card">
        <h5 class="text-white">Novo Documento</h5>
        <div class="card-header-right">

        </div>
    </div>
    <div class="card-block">

      <input type="hidden" name="indexes" id="indexes" value=""/>

      <div class="row m-t-30">

          <div class="col-md-4">

              <div class="form-group {!! $errors->has('type_id') ? 'has-error' : '' !!}">
                  <label class="col-form-label">Tipo</label>
                  <div class="input-group">
                    <select class="form-control select2" title="Selecione" name="type_id[]" required multiple>

                        @foreach(\App\Helpers\Helper::documentTypes()->sortBy('name') as $type)
                            <option value="{{$type->uuid}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
              </div>

          </div>

          <div class="col-md-4">
              <div class="form-group {!! $errors->has('type_id') ? 'has-error' : '' !!}">
                  <label class="col-form-label">Referencia</label>
                  <div class="input-group">
                    <input type="text" name="reference" class="form-control" placeholder="Código de referencia do documento"/>
                  </div>
                  {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
              </div>
          </div>

          <div class="col-md-4">
            <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                <label class="col-form-label">Cliente</label>
                <div class="input-group">
                  <select class="form-control select-client-employees select-client"
                    data-search-employees="{{ route('client_employees_search') }}"
                    name="client_id" id="client_id" data-target="#select-employee" required>
                  </select>
                </div>
                {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label">Funcionário</label>
                <div class="input-group">
                  <select class="form-control select2" id="select-employee" multiple
                    name="employee_id[]">
                  </select>
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label">Endereço</label>
                <div class="input-group">
                  <select class="form-control" id="select-client-address"
                    name="address_id">
                  </select>
                </div>
            </div>
          </div>

      </div>

    </div>
</div>

<div id="rowForm"></div>

<div class="card">
    <div class="card-block">
      <button class="btn btn-success btn-sm">Salvar</button>
      <a class="btn btn-danger btn-sm" href="{{ route('documents.index') }}">Cancelar</a>
      <button type="button" id="btnAddRows" class="btn btn-primary btn-sm f-right">Adicionar Mais Registros</button>

    </div>
</div>

</form>

</div>

@endsection

@section('scripts')

  <script>

      var row = $("#rowForm");
      var btnAddRows = $("#btnAddRows");
      var indexes = $("#indexes");

      var index = 0;

      function renderCols(index) {

        return '<div class="card" id="row-'+index+'">'
            + '<div class="card-header bg-c-green update-card">'
                + '<h5 class="text-white">Novo Documento</h5>'
                + '<div class="card-header-right">'

                + '</div>'
            + '</div>'
            + '<div class="card-block">'
            + '<div class="row m-t-30">'
             + '<div class="col-md-4">'
                 + '<div class="form-group">'
                     + '<label class="col-form-label">Tipo</label>'
                     + '<div class="input-group">'
                       + '<select class="form-control" id="type-document-'+index+'" title="Selecione" name="type_id-'+index+'[]" required multiple>'

                           @foreach(\App\Helpers\Helper::documentTypes()->sortBy('name') as $type)
                               + '<option value="{{$type->uuid}}">{{$type->name}}</option>'
                           @endforeach
                      + '</select>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="col-md-4">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">Referencia</label>'
                    + '<div class="input-group">'
                      + '<input type="text" name="reference-'+index+'" class="form-control" placeholder="Código de referencia do documento"/>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="col-md-4">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Cliente</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control select-client-employees"'
                      + 'data-search-employees="{{ route("client_employees_search") }}"'
                      + 'name="client_id-'+index+'" id="client_id-'+index+'" data-target="#select-employee-'+index+'" required>'

                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
            + '<div class="col-md-4">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Funcionário</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control" multiple '
                      + 'name="employee_id-'+index+'[]" id="select-employee-'+index+'">'
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
            + '<div class="col-md-4">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Endereços</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control" '
                      + 'name="address_id-'+index+'" id="select-address-'+index+'">'
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
            + '<div class="col-md-12">'
              +   '<div class="form-group">'
              + '<label class="col-form-label"></label>'
                    + '<button type="button" class="btn btn-block btn-danger btn-sm btnRmItem btn-block" data-item="'+index+'"><i class="fa fa-close"></i> Remover</button>'
                + '</div>'
            + '</div>'
        + '</div>'
        + '</div>'
    + '</div>';

      }

      btnAddRows.click(function() {
        index++;
        row.append(renderCols(index));
        $("#select-employee-" + index).select2();

        $("#type-document-" + index).select2();

        indexes.val(index);

        $('.select-client-employees').select2({
          ajax: {
            type: "GET",
            dataType: 'json',
            delay: 250,
            url: $('#input-search-clientes').val(),
            data: function (params) {
              var query = {
                search: params.term,
                type: 'public'
              }

              return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
          },
          cache: true,
          placeholder: 'Procurar um cliente',
          minimumInputLength: 1,

        });

        $("#select-address-"+index).select2({
          ajax: {
            type: "GET",
            dataType: 'json',
            delay: 250,
            url: $('#input-search-addresses').val(),
            data: function (params) {
              var query = {
                search: params.term,
                client: $("#client_id-"+index).val(),
                type: 'public'
              }

              return query;
            },
            processResults: function (data, params) {

              return {
                  results: $.map(data, function (item) {
                      return {
                          text: item.address,
                          id: item.id
                      }
                  })
              };
            }
          },
          cache: true,
          placeholder: 'Procurar um Endereço',
          minimumInputLength: 3,
        });
      });

      var btnRmItem = $(".btnRmItem");

      $(document).on('click','.btnRmItem',function(){
        var self = $(this);
        $("#row-" + self.data('item')).remove();
      });

      $("#select-client-address").select2({
        ajax: {
          type: "GET",
          dataType: 'json',
          delay: 250,
          url: $('#input-search-addresses').val(),
          data: function (params) {
            var query = {
              search: params.term,
              client: $("#client_id").val(),
              type: 'public'
            }

            return query;
          },
          processResults: function (data, params) {

            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.address,
                        id: item.id
                    }
                })
            };
          }
        },
        cache: true,
        placeholder: 'Procurar um Endereço',
        minimumInputLength: 3,
      });

  </script>

@endsection
