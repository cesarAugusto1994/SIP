@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ordem de Entrega</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <form target="_blank" action="{{ route('print_batch') }}" method="post">
    @csrf

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.ordem.entrega')
                    <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light m-r-15 m-b-5 m-t-5" target="_blank"><i class="icofont icofont-print"></i> Gerar</button>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-12">
        <!-- Recent Orders card start -->
        <div class="card">
            <div class="card-header">
                <h5>Ordens de Entrega Pendentes</h5>
                <span>Listagem para impressão</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                              <th>
                                  <input class="js-switch" type="checkbox" id="select-all" name="select_all" value="1"/>
                              </th>
                              <th>Ordem No.</th>
                              <th>Situação</th>
                              <th>Cliente</th>
                              <th>Previsão / Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($orders->sortByDesc('id') as $delivery)

                          @php

                            $status = $delivery->status->id;

                            $bgColor = 'success';

                            switch($status) {
                              case '1':
                                $bgColor = 'primary';
                                break;
                              case '2':
                                $bgColor = 'warning';
                                break;
                              case '3':
                                $bgColor = 'success';
                                break;
                              case '4':
                                $bgColor = 'danger';
                                break;
                            }

                            @endphp

                            <tr>
                                <td><input class="js-switch select-item" type="checkbox" checked name="deliveries[]" value="{{ $delivery->uuid }}"/></td>
                                <td><a href="{{ route('delivery-order.show', $delivery->uuid) }}" class="card-title">#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                <td>
                                  <span class="label label-{{$bgColor}} f-right"> {{$delivery->status->name}} </span>
                                </td>
                                <td><a href="{{route('clients.show', ['id' => $delivery->client->uuid])}}">{{ $delivery->client->name }}</a><br/>
                                  <label class="label label-inverse-primary">{{$delivery->address->street}}, {{$delivery->address->number}} - {{$delivery->address->district}}, {{$delivery->address->city}}</label>
                                </td>
                                <td>

                                  @if(in_array($delivery->status_id, [1,2,3]))

                                    {{ $delivery->delivery_date->format('d/m/Y') }}
                                    <br/>
                                    <label class="label label-inverse-primary">{{ $delivery->delivery_date->diffForHumans() }}</label>

                                  @elseif($delivery->delivered_at)

                                    {{ $delivery->delivered_at->format('d/m/Y') }}
                                    <br/>
                                    <label class="label label-inverse-success">{{ $delivery->delivered_at->diffForHumans() }}</label>

                                  @endif

                                </td>

                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
