@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Entrega: Faturamento</h4>
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
                        <a href="{{ route('delivery-order.index') }}"> Ordem de Entrega </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Faturamento</a>
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
                <form method="get" action="?">
                  <div class="form-group row">
                      <div class="col-sm-12">
                          <input type="text" id="daterange" class="form-control" placeholder="Periodo">

                          <input type="hidden" name="start" id="start" value="{{ now()->format('d/m/Y') }}"/>
                          <input type="hidden" name="end" id="end" value="{{ now()->format('d/m/Y') }}"/>

                      </div>
                  </div>

                  <div class="">
                      <button type="submit" class="btn btn-success btn-sm">
                          <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                      </button>
                  </div>
                </form>

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-md-12 col-xl-3">
        <div class="card widget-statstic-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h5>Hoje</h5>
                    <p class="p-t-10 m-b-0 text-c-yellow">Entregas realizadas hoje</p>
                </div>
            </div>
            <div class="card-block">
                <i class="feather icon-sliders st-icon bg-c-yellow"></i>
                <div class="text-left">
                    <h3 class="d-inline-block">{{ $result['today']['count'] }}</h3>
                    <span class="f-right bg-c-yellow">{{ $result['today']['amount'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-statstic-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h5>Nesta Semana</h5>
                    <p class="p-t-10 m-b-0 text-c-pink">Entregas realizadas nesta semana.</p>
                </div>
            </div>
            <div class="card-block">
                <i class="feather icon-users st-icon bg-c-pink text-c-pink"></i>
                <div class="text-left">
                    <h3 class="d-inline-block">{{ $result['week']['count'] }}</h3>
                    <span class="f-right bg-c-pink">{{ $result['week']['amount'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-statstic-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h5>Neste Mês</h5>
                    <p class="p-t-10 m-b-0 text-c-blue">Entregas realizadas neste mês.</p>
                </div>
            </div>
            <div class="card-block">
                <i class="feather icon-calendar st-icon bg-c-blue"></i>
                <div class="text-left">
                    <h3 class="d-inline-block">{{ $result['month']['count'] }}</h3>
                    <span class="f-right bg-c-blue">{{ $result['month']['amount'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card widget-statstic-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h5>Total</h5>
                    <p class="p-t-10 m-b-0 text-c-green">Total de Entregas realizadas.</p>
                </div>
            </div>
            <div class="card-block">
                <i class="feather icon-calendar st-icon bg-c-green"></i>
                <div class="text-left">
                    <h3 class="d-inline-block">{{ $result['total']['count'] }}</h3>
                    <span class="f-right bg-c-green">{{ $result['total']['amount'] }}</span>
                </div>
            </div>
        </div>
    </div>

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

      <div class="col-xl-6 col-md-6">
          <div class="card">
              <div class="card-block">
                  <div id="deliv-div"></div>
                  {!! $lava->render('ColumnChart', 'EntregasPorMes', 'deliv-div') !!}
              </div>
          </div>
      </div>

      <div class="col-xl-6 col-md-6">
          <div class="card">
              <div class="card-block">
                  <div id="sales_div"></div>
                  {!! $lava->render('CalendarChart', 'Entregas', 'sales_div') !!}
              </div>
          </div>
      </div>

      <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  <h5>Ordens de Entrega Recentes</h5>
                  <a target="_blank" href="{{ route('delivery_billing_report', ['start' => $first->format('d/m/Y'), 'end' => $last->format('d/m/Y')]) }}" class="btn btn-primary btn-sm f-right">Imprimir</a>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-styling">
                          <thead>
                              <tr class="table-primary">
                                  <th>Cliente</th>
                                  <th>Entregas</th>
                                  <th>Valor</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($deliveriesGroupedByClient as $key => $deliveries)

                              <tr>
                                  <td><a target="_blank" href="{{route('clients.show', $key)}}">{{ $deliveries['client_name'] }}</a></td>
                                  <td>{{ $deliveries['deliveries'] }}</td>
                                  <td>
                                    @if($deliveries['charge'])
                                      <p class="lead">{{ number_format($deliveries['value'], 2, ',', '.') }}</p>
                                    @else
                                      <label class="label label-lg label-danger">Valor Não Cobrado</label>
                                    @endif
                                  </td>
                              </tr>

                            @endforeach
                          </tbody>

                          <tfoot>
                              <tr>
                                <td colspan="2"></td>
                                <td><p class="lead text-primary">Total: {{ number_format(array_sum(array_column($deliveriesGroupedByClient, 'value')), 2, ',', '.') }}</p></td>
                              </tr>
                          </tfoot>
                      </table>
                  </div>
              </div>
          </div>
          <!-- Recent Orders card end -->
      </div>
  </div>
</div>

<input type="hidden" id="billing-graph" value="{{ route('delivery_billing_graph') }}"/>

@endsection

@section('scripts')

  <script>

    if (document.getElementById("barChart")) {

        var url = $("#billing-graph").val();

        /*$.ajax({
          type: 'GET',
          url: url,
          async: true,
          cache: true,
          success: function(retorno) {

            var doughnutData = JSON.parse(retorno);

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45, // This is 0 for Pie charts
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: false,
                legend: {
                    display: false,
                    position: 'right',
                    labels: {}
                }
            };

            var data = {

                datasets: [{
                    data: doughnutData.data,
                    backgroundColor: doughnutData.backgroundColor
                }],

                labels: doughnutData.labels,
                display: false,

            };

            var config = {
                type: 'bar',
                data: data,
                //options: doughnutOptions,
                options: {
                    barValueSpacing: 20,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                        position: 'right',
                        labels: {}
                    },
                    scales: {
                      yAxes: [{
                        ticks: {
                          stepSize: 1
                        }
                      }]
                    }
                }
            };

            var ctx = document.getElementById("barChart").getContext("2d");
            var DoughnutChart = new Chart(ctx, config);

          }
        })
        */
    }

  </script>

@stop
