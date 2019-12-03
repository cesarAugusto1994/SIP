@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Remessa de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('delivery-packings.index') }}">Remessa de Entrega</a></li>
                    <li class="breadcrumb-item"><a href="#!">Detalhes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.ordem.entrega')
                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery-packings.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Remessa</a>
                  @endpermission

                  <a target="_blank" class="btn btn-sm btn-primary waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery_packings_print', $packing->uuid)}}"><i class="icofont icofont-paper-plane"></i> Imprimir Guia</a>

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                <h5>Remessas de Entrega Recentes</h5>
                <span>Registros retornados: </span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                                <th>Entregue?</th>
                                <th>Ordem No.</th>
                                <th>Cliente</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($packing->items as $item)

                            @php
                                $delivery = $item->delivery;
                            @endphp

                            <tr>
                                <td>
                                  @if($packing->status != 'Finalizado')
                                  <input class="js-switch confirm-delivery" type="checkbox" name="deliveries[]" value="{{ $item->uuid }}"/>
                                  @else

                                    {{ $item->delivered ? 'Sim' : 'Não' }}

                                  @endif
                                </td>
                                <td><a href="{{ route('delivery-packings.show', $delivery->uuid) }}" class="card-title" data-toggle="tooltip" data-original-title="Adicionado Por {{$delivery->creator->person->name}} em {{ $delivery->created_at->format('d/m/Y H:i:s') }}">#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</a>
                                </td>
                                <td><a href="{{route('clients.show', ['id' => $delivery->client->uuid])}}">{{ $delivery->client->name }}</a><br/>
                                  <small>Endereço: {{$delivery->address->street}}, {{$delivery->address->number}} - {{$delivery->address->district}}, {{$delivery->address->city}}</small>
                                </td>
                            </tr>

                          @endforeach

                          @if($packing->status != 'Finalizado')
                            <tr>
                                <td colspan="4">
                                    <a id="btn-confirm-delivery" class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" data-route="{{ route('delivery_packings_confirm', $packing->uuid) }}" href="!#"><i class="icofont icofont-paper-plane"></i> Confirmar Entrega da Remessa</a>
                                </td>
                            </tr>
                          @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-block">

              <div id="map"></div>

            </div>
        </div>

    </div>

  </div>

</div>

@endsection

@section('scripts')
<script>

  var btnConfirm = $("#btn-confirm-delivery");

  btnConfirm.click(function(e) {

    e.preventDefault();

    var self = $(this);
    var deliveries = $(".confirm-delivery");
    var deliveriesValue = [];

    $.each(deliveries, function(i, item) {
        if(item.checked !== false) {
            deliveriesValue.push(item.value);
        }
    });

    /*if(deliveriesValue.length === 0) {

      window.swal({
        title: 'Não foi possível confirmar as Entregas',
        text: 'Informe as Entregas Realizadas.',
        type: 'info',
        showConfirmButton: true,
        allowOutsideClick: true
      });

      return false;
    }*/

    swal({
      title: 'Confirma Entrega desta Ordens?',
      text: "Não será possível alterar!",
      showCancelButton: true,
      confirmButtonColor: '#0ac282',
      cancelButtonColor: '#D46A6A',
      confirmButtonText: 'Sim, Remover',
      cancelButtonText: 'Não'
      }).then((result) => {
      if (result.value) {

        e.preventDefault();

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto a requisição é processada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

        $.ajax({
          headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
          url: self.data('route'),
          type: 'POST',
          dataType: 'json',
          data: {
            deliveries: deliveriesValue
          }
        }).done(function(data) {

          swal.close();

          if(data.success) {

            notify(data.message, 'inverse');

            window.location.href = data.route;

          } else {

            notify(data.message, 'danger');

          }

        });
      }

    });

  });

  function initMap() {
    var center = {lat: -20.3101037 , lng: -40.320972999999995};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      center: center
    });

    var locations = [];

    var infowindow =  new google.maps.InfoWindow({});
    var marker, count;

    @foreach($packing->items as $item)

      //console.log('{{ $item->delivery->address->id }}', '{{ $item->delivery->address->description }}', '{{ $item->delivery->address->lat }}', '{{ $item->delivery->address->long }}');

      marker = new google.maps.Marker({
        position: new google.maps.LatLng('{{ $item->delivery->address->lat }}', '{{ $item->delivery->address->long }}'),
        map: map,
        title: '{{ $item->delivery->address->description }}'
      });

      google.maps.event.addListener(marker, 'click', (function (marker, count) {
        return function () {
          infowindow.setContent('{{ $item->delivery->address->description }}');
          infowindow.open(map, marker);
        }
      })(marker, count));

    @endforeach

  }

</script>

@stop
