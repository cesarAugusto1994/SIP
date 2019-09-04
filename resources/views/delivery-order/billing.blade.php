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
      <div class="col-xl-6">
          <!-- Sales and expense card start -->
          <div class="card">
              <div class="card-header">
                  <h5>Entregas Mensais</h5>
              </div>
              <div class="card-block">
              <canvas id="barChart" width="400" height="300"></canvas>
              </div>
          </div>
          <!-- Sales and expense card end -->
      </div>
      <div class="col-xl-6">
          <!-- Sales, Receipt and Dues card start -->
          <div class="card">
              <div class="card-header">
                  <h5>Financeiro</h5>

              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-hover">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Valor</th>
                                  <th>Entregas</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($result as $item)
                              <tr>
                                  <th scope="row">{{ $item['title'] }}</th>
                                  <td>{{ $item['amount'] }}</td>
                                  <td>{{ $item['count'] }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <!-- Sales, Receipt and Dues card end -->
      </div>
      <div class="col-lg-12">
          <!-- Recent Orders card start -->
          <div class="card">
              <div class="card-header">
                  <h5>Ordens de Entrega Recentes</h5>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-styling">
                          <thead>
                              <tr class="table-primary">
                                  <th>Ordem No.</th>
                                  <th>Cliente</th>
                                  <th>Data</th>
                                  <th>Documentos</th>
                                  <th>Valor</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($deliveries->sortByDesc('id') as $delivery)
                              <tr>
                                  <td><a href="{{ route('delivery-order.show', $delivery->uuid) }}" class="card-title">{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                  <td>{{ $delivery->client->name }}</td>
                                  <td>{{ $delivery->created_at->format('d/m/Y') }}</td>
                                  <td>{{ $delivery->documents->count() }}</td>
                                  <td>
                                    @if($delivery->client->charge_delivery)
                                      <label class="label label-md label-success">5,00</label>
                                    @else
                                      <label class="label label-md label-primary">Valor não cobrado</label>
                                    @endif
                                  </td>
                              </tr>
                            @endforeach
                          </tbody>
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

        $.ajax({
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

    }

  </script>

@stop
