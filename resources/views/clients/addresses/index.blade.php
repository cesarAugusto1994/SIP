@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Endereços do Cliente: {{ $client->name }}</h4>
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
                        <a href="{{ route('clients.index') }}"> Clientes </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.show', $client->uuid) }}"> {{ $client->name }} </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Endereços</a></li>
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

                  @permission('create.cliente.enderecos')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('client_addresses_create', $client->uuid)}}"><i class="icofont icofont-paper-plane"></i> Novo Endereço</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>



  <div class="card">
      <div class="card-header">
          <h5>Endereços Cadastrados</h5>
          <span>Registros retornados: {{ $quantity }}</span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>Opções</th>
                          <th>#</th>
                          <th>Descrição</th>
                          <th>Endereço</th>
                          <th>Cidade</th>
                          <th>Principal?</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($client->addresses as $address)
                          <tr>

                              <td class="dropdown">

                                <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                  @permission('edit.cliente.enderecos')
                                    <a href="{{route('client_addresses_edit', [$client->uuid, $address->uuid])}}" class="dropdown-item">Editar </a>
                                  @endpermission

                                  @permission('delete.cliente.enderecos')
                                    <a href="#!" data-route="{{route('client_address_destroy', ['id' => $address->uuid])}}" class="dropdown-item btnRemoveItem">Remover </a>
                                  @endpermission

                                </div>
                              </td>

                              <td>#{{ str_pad($address->id, 6, "0", STR_PAD_LEFT) }}</td>

                              <td>
                                  {{$address->description}}
                              </td>

                              <td>
                                  <p>{{$address->street}}, {{$address->number}} - {{$address->district}}</p>
                              </td>

                              <td>
                                  {{$address->city}} - {{$address->zip}}
                              </td>

                              <td>
                                @if($address->is_default)
                                  <span class="badge badge-success">Sim</span>
                                @else
                                  <span class="badge badge-danger">Não</span>
                                @endif
                              </td>

                          </tr>
                      @endforeach
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


@endsection

@section('scripts')
<script>

  function initMap() {
    var center = {lat: -20.3101037 , lng: -40.320972999999995};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 11,
      center: center
    });

    var locations = [];

    var infowindow =  new google.maps.InfoWindow({});
    var marker, count;

    @foreach($client->addresses as $address)

      marker = new google.maps.Marker({
        position: new google.maps.LatLng('{{ $address->lat }}', '{{ $address->long }}'),
        map: map,
        title: '{{ $address->description }}'
      });

      google.maps.event.addListener(marker, 'click', (function (marker, count) {
        return function () {
          infowindow.setContent('{{ $address->description }}');
          infowindow.open(map, marker);
        }
      })(marker, count));

    @endforeach

  }

</script>

@stop
