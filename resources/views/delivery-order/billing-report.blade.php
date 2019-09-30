<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="{{ asset('adminty\components\bootstrap\css\bootstrap.min.css') }}">
    <link href="{{ asset('adminty\css\style.css') }}"/>

    <style>

      @page {
          margin-top: 20px;
          margin-left: 0;
          margin-right: 0;
          margin-bottom: 100;
      }

      @page {
      	header: page-header;
      	footer: page-footer;
        body: wrapper-content;
      }

      .page-header {
        margin-top: -80px !important;
      }

      p:last-child { page-break-after: auto; }
      .wrapper-content { padding: 2em 2em;}

      .font-10 {
        font-size: 10px;
      }

      .table>tbody>tr>td {
        padding: 6px;
        padding-bottom: 3px;
        font-size: 12px;
      }

    </style>

</head>

<body class="pace-done">
  <div style="padding:0px 10px 0px 10px">
      <div class="ibox-content">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="">
                  <div class="panel-body">

                    <table class="table table-bordered">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="2"><h4><b>FATURAMENTO DE ENTREGAS </b></h4></td>
                            <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr class="table-primary">
                            <th>Cliente</th>
                            <th>Entregas</th>
                            <th style="width:100px">R$ Valor</th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach($deliveries as $delivery)

                          @if(!$delivery->first()->client->charge_delivery || !$delivery->sum('amount'))
                            @continue;
                          @endif

                          <tr>
                              <td>{{ $delivery->first()->client->name }}</td>
                              <td>{{ $delivery->count() }}</td>
                              <td>{{ number_format($delivery->count()*5.00, 2, ',', '.') }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>

  <script>
      window.print();
      window.onfocus=function() {
          window.close();
      }
  </script>

</body>

</html>
