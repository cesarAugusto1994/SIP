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

  <div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow f-w-600">{{ \App\Helpers\Helper::totalDelivery() }}</h4>
                        <h6 class="text-muted m-b-0">Total</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green f-w-600">{{ \App\Helpers\Helper::openedDeliveries() }}</h4>
                        <h6 class="text-muted m-b-0">Abertos</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue f-w-600">{{ \App\Helpers\Helper::delivered() }}</h4>
                        <h6 class="text-muted m-b-0">Entregues</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-calendar f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-pink f-w-600">{{ \App\Helpers\Helper::finishedDeliveries() }}</h4>
                        <h6 class="text-muted m-b-0">Finalizados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-download f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($delay)
      <div class="col-xl-12">
        <div class="alert alert-danger background-danger">
            <strong>Atenção!</strong> {{ $delay }} Entrega(s) em Atraso.
            <a href="?delay=1&find=1" class="btn btn-inverse btn-sm">Ver Entregas Atrasadas</a>
        </div>
      </div>
    @endif

  </div>

  <div class="row">

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div"></div>
                {!! $lava->render('DonutChart', 'Entregador', 'chart-div') !!}
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div-status"></div>
                {!! $lava->render('DonutChart', 'Status', 'chart-div-status') !!}
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div-priority"></div>
                {!! $lava->render('BarChart', 'Empresa', 'chart-div-priority') !!}
            </div>
        </div>
    </div>

  </div>

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.ordem.entrega')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery-order.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Entrega</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">
                <form method="get" action="?">
                    <input type="hidden" name="find" value="1"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="code" placeholder="Código da OE">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" id="daterange" class="form-control" placeholder="Periodo">

                            <input type="hidden" name="start" id="start" value="{{ now()->format('d/m/Y') }}"/>
                            <input type="hidden" name="end" id="end" value="{{ now()->format('d/m/Y') }}"/>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control" name="status">
                              <option value="">Situação</option>
                              @foreach(\App\Helpers\Helper::deliveryStatus() as $status)
                                <option value="{{ $status->id }}">{{$status->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="client">
                              <option value="">Cliente</option>
                              @foreach(\App\Helpers\Helper::clients()->sortBy('name') as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <!-- Recent Orders card start -->
        <div class="card">
            <div class="card-header">
                <h5>Ordens de Entrega Recentes</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
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

    {{ $orders->links() }}

  </div>

</div>

@endsection
