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
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <form class="formValidation" data-parsley-validate method="post" action="{{route('service-order.update', $order->uuid)}}">
      @csrf
      {{ method_field('PUT') }}
  <div class="card">
      <div class="card-header">
          <h5>Editar Ordem de Serviço</h5>
      </div>
      <div class="card-block">

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Cliente</label>
                      <div class="input-group">
                        <select class="form-control select-client" required name="client">
                            <option value="{{ $order->client->uuid }}">{{ $order->client->name }}</option>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Contrato</label>
                      <div class="input-group">
                        <select class="form-control select2" required name="contract_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::contracts() as $item)
                                <option value="{{$item->id}}" {{ $order->contract->id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
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
                        @php

                            $checked = null;

                            $has = $order->services->where('service_id', $service->id);

                            if($has->isNotEmpty()) {
                                $checked = 'checked';
                            }

                        @endphp

                        <tr>
                            <td><input class="js-switch select-item" type="checkbox" name="services[]" {{ $checked }} value="{{ $service->uuid }}"/></td>
                            <th scope="row">{{ str_pad($service->id, 6, "0", STR_PAD_LEFT) }}</th>
                            <td>{{ $service->name }}</td>
                            @foreach($service->values as $value)
                                <td>{{ $value->contract->name }}<br/> <b>{{ number_format($value->value, 2) }}</b></td>
                            @endforeach
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

</script>

@endsection
