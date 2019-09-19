@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Documentos Por Cliente</h4>
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
      <div class="card-header bg-c-green update-card">
          <h5 class="text-white">Novos Documentos Por Cliente</h5>
      </div>
      <div class="card-block">

        <form class="formValidation m-t-30" data-parsley-validate method="post" action="{{route('documents_create_for_client_store')}}">
            {{csrf_field()}}

            <input type="hidden" name="indexes" id="indexes" value=""/>

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                      <label class="col-form-label">Cliente</label>
                      <div class="input-group">
                        <select class="form-control select-client" name="client_id" id="client_id" required></select>
                      </div>
                      {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>

            </div>

            <div id="rowForm"></div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('documents.index') }}">Cancelar</a>

            <button type="button" id="btnAddRows" class="btn btn-primary btn-sm f-right">Adicionar Mais Registros</button>

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

        return '<div class="row m-b-30" id="row-'+index+'">'

             + '<div class="col-md-3">'
                 + '<div class="form-group">'
                     + '<label class="col-form-label">Tipo(s) de Documentos</label>'
                     + '<div class="input-group">'
                       + '<select class="form-control" id="type-document-'+index+'" title="Selecione" name="type_id-'+index+'[]" required multiple>'
                          + '<option value="">Selecione...</option>'
                           @foreach(\App\Helpers\Helper::documentTypes()->sortBy('name') as $type)
                               + '<option value="{{$type->uuid}}">{{$type->name}}</option>'
                           @endforeach
                      + '</select>'
                    + '</div>'
                + '</div>'
            + '</div>'


            + '<div class="col-md-5">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Funcionário(s)</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control select-client-employees" multiple '
                      + 'name="employee_id-'+index+'[]" id="employee_id-'+index+'">'
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'
            + '<div class="col-md-3">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">Referencia</label>'
                    + '<div class="input-group">'
                      + '<input type="text" name="reference-'+index+'" class="form-control" placeholder="Código de referencia do documento"/>'
                    + '</div>'
                + '</div>'
            + '</div>'
            + '<div class="col-md-1">'
              +   '<div class="form-group">'
              + '<label class="col-form-label">Opção</label>'
                    + '<button type="button" class="btn btn-outline-danger btn-sm btnRmItem btn-block" data-item="'+index+'"><i class="fa fa-close"></i></button>'
                + '</div>'
            + '</div>'
        + '</div>';

      }

      btnAddRows.click(function() {

        if(!$("#client_id").val()) {
          notify("Informe o Cliente para adicionar documentos.", 'inverse');
          return false;
        }

        index++;
        row.append(renderCols(index));
        $("#select-employee-" + index).select2();

        $("#type-document-" + index).select2();

        indexes.val(index);

        $("#employee_id-" + index).select2({
          ajax: {
            type: "GET",
            dataType: 'json',
            delay: 250,
            url: $('#input-search-employees').val(),
            data: function (params) {
              var query = {
                search: params.term,
                client: $("#client_id").val(),
                type: 'public'
              }

              return query;
            },
            processResults: function (data, params) {

                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            }
          },
          cache: true,
          placeholder: 'Procurar um Funcionário',
          minimumInputLength: 3,
          escapeMarkup: function(markup) {
              return markup;
          }, // let our custom formatter work
          templateResult: formatRepo, // omitted for brevity, see the source of this page
          templateSelection: formatRepoSelection // omitted for brevity, see the source of this page

        });

      });

      var btnRmItem = $(".btnRmItem");

      $(document).on('click','.btnRmItem',function(){
        var self = $(this);
        $("#row-" + self.data('item')).remove();
      });

      function formatRepo(emp) {

          if(!emp.name) return '<span>Pesquisando...</span>';

          var markup = "<div class='select2-result-repository clearfix'>" +
              "<div class='select2-result-repository__avatar'></div>" +
              "<div class='select2-result-repository__meta'>" +
              "<div class='select2-result-repository__title'>" + emp.name + "</div>";

          if (emp.company) {
              markup += "<div class='select2-result-repository__description'>" + emp.company + "</div>";
          }

          markup += "<div class='select2-result-repository__statistics'>" +
              "<div class='select2-result-repository__forks'>Documento " + emp.document + " </div>" +
              "</div>" +
              "</div></div>";

          return markup;
      }

      function formatRepoSelection(repo) {
          return repo.name || repo.company;
      }

  </script>

@endsection
