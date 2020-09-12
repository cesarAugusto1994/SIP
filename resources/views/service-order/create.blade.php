@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Serviço</h4>
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
                        <a href="{{ route('service-order.index') }}"> Ordem de Serviço </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <form class="formValidation" data-parsley-validate method="post" action="{{route('service-order.store')}}">
      @csrf

  <div class="card">
      <div class="card-header">
          <h5>Nova Ordem de Serviço</h5>
      </div>
      <div class="card-block">

            <div class="row m-b-30">

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Cliente</label>
                      <div class="input-group">
                        <select class="form-control select-client-employees select-client-addresses select-client" required
                        name="client"
                        data-search-employees="{{ route('client_employees_search') }}"
                        data-search-addresses="{{ route('client_addresses_search') }}"
                        id="client_id" data-target="#select-employee"></select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Unidades</label>
                      <div class="input-group">
                        <select class="form-control select2" id="select-address"
                          name="addresses[]" multiple>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Contato</label>
                      <div class="input-group">
                        <select class="form-control select2" id="select-employee" name="contact_id">
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Tipo de Contrato</label>
                      <div class="input-group">
                        <select class="form-control select2" required name="contract_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::contracts() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

            </div>

      </div>

      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>
                              <input class="js-switch" type="checkbox" id="select-all" name="select_all" value="1"/>
                          </th>
                          <th>#</th>
                          <th>Nome</th>
                          <th colspan="4">Valores</th>
                      </tr>
                  </thead>
                  <tbody>

                      @foreach($services as $service)
                        <tr>
                            <td><input class="js-switch select-item" type="checkbox" name="services[]" value="{{ $service->uuid }}"/></td>
                            <th scope="row">{{ str_pad($service->id, 6, "0", STR_PAD_LEFT) }}</th>
                            <td>{{ $service->name }}</td>
                            <td><small>
                            @foreach($service->values as $value)
                                {{ $value->contract->name }}: <b>{{ number_format($value->value, 2) }}</b><br/>
                            @endforeach</small>
                            </td>
                        </tr>
                      @endforeach

                  </tbody>
              </table>
          </div>
      </div>

      <div class="card-block">

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('services.index') }}">Cancelar</a>

      </div>

  </div>

</form>

</div>

@endsection

@section('scripts')

<script>

    var clickCheckbox = document.querySelector('#select-all');

    $(document).on('change','#select-all',function(){

      var itemsCheckbox = $('.select-item');

      if (clickCheckbox.checked) {

          $.each(itemsCheckbox, function(idx, elem) {

              if(!$(elem).is(':checked')) {
                  $(elem).trigger('click');
              }

          });

      } else {

          $.each(itemsCheckbox, function(idx, elem) {
            if($(elem).is(':checked')) {
                $(elem).trigger('click');
            }
          });

      }
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
