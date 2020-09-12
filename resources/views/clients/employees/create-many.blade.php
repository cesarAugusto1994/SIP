@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Clientes</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    @if($company)
                      <li class="breadcrumb-item">
                          <a href="{{ route('clients.show', $company->uuid) }}"> Clientes </a>
                      </li>
                    @else
                      <li class="breadcrumb-item">
                          <a href="{{ route('employees.index') }}"> Funcionários </a>
                      </li>
                    @endif
                    <li class="breadcrumb-item"><a href="#!">Adicionar</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Adicionar Novos Funcionários em {{ $company->name }}</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('client_employees_store', $company->uuid)}}">

            {{csrf_field()}}

            <input type="hidden" name="indexes" id="indexes" value=""/>

            <div id="rowForm"></div>

            <button class="btn btn-success btn-sm">Salvar</button>
            @if($company)
              <a class="btn btn-danger btn-sm" href="{{ route('clients.show', $company->uuid) }}">Cancelar</a>
            @else
              <a class="btn btn-danger btn-sm" href="{{ route('employees.index') }}">Cancelar</a>
            @endif

            <button type="button" id="btnAddRows" class="btn btn-primary btn-sm f-right">Adicionar Mais Registro</button>

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
              +   '<div class="form-group">'
                    + '<label class="col-form-label">Nome</label>'
                    + '<div class="input-group">'
                      + '<input type="text" required name="name-'+index+'" class="form-control" placeholder="Nome"/>'
                    + '</div>'
                + '</div>'
            + '</div>'

            + '<div class="col-md-2">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">CPF</label>'
                    + '<div class="input-group">'
                      + '<input type="text" name="cpf-'+index+'" class="form-control inputCpf" placeholder="CPF"/>'
                    + '</div>'
                + '</div>'
            + '</div>'

            + '<div class="col-md-2">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">RG</label>'
                    + '<div class="input-group">'
                      + '<input type="text" name="rg-'+index+'" class="form-control" placeholder="RG"/>'
                    + '</div>'
                + '</div>'
            + '</div>'

            + '<div class="col-md-3">'
              + '<div class="form-group">'
                  + '<label class="col-form-label">Função</label>'
                  + '<div class="input-group">'
                    + '<select class="form-control select-client-occuparions"'
                      + 'name="occupation-'+index+'" data-target="#select-employee-'+index+'" required>'
                    + '</select>'
                  + '</div>'
              + '</div>'
            + '</div>'

            + '<div class="col-md-1">'
              +   '<div class="form-group">'
                    + '<label class="col-form-label">Ativo</label>'
                    + '<div class="input-group">'
                      + '<input id="js-switch-'+index+'" type="checkbox" value="1" name="active-'+index+'"/>'
                    + '</div>'
                + '</div>'
            + '</div>'

            + '<div class="col-md-1">'
              +   '<div class="form-group">'
              + '<label class="col-form-label">Remover</label>'
                    + '<button type="button" class="btn btn-outline-danger btn-sm btnRmItem btn-block" data-item="'+index+'"><i class="fa fa-close"></i></button>'
                + '</div>'
            + '</div>'
        + '</div>';

      }

      btnAddRows.click(function() {
        index++;
        row.append(renderCols(index));
        $("#select-employee-" + index).select2();
        $('.inputCpf').mask('000.000.000-00', {reverse: true});
        indexes.val(index);

        var elem = Array.prototype.slice.call(document.querySelectorAll('#js-switch-'+index));

        elem.forEach(function(html) {
          var switchery = new Switchery(html, { color: '#93BE52', jackColor: '#fff' });
        });

        $('.select-client-occuparions').select2({
          ajax: {
            type: "GET",
            dataType: 'json',
            delay: 250,
            url: $('#input-search-client-occupations').val(),
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
      });

      var btnRmItem = $(".btnRmItem");

      $(document).on('click','.btnRmItem',function(){
        var self = $(this);
        $("#row-" + self.data('item')).remove();
      });

  </script>

@endsection
