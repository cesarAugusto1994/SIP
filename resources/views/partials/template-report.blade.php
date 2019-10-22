<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('adminty\css\style.css') }}"/>

    <style>

      @page {
          margin-top: 20px;
          margin-left: 0;
          margin-right: 0;
          /*margin-bottom: 20px;*/
      }

      @page {
      	header: page-header;
      	footer: page-footer;
        body: wrapper-content;
      }

      header { position: fixed; top: -60px; left: 0px; right: 0px; background-color: #005432; height: 60px;}
      footer { position: fixed; bottom: -60px; left: 0px; right: 0px; background-color: #005432; height: 130px; }

      p:last-child { page-break-after: auto; }
      .wrapper-content { padding: 2em 2em;}

      .table>tbody>tr {
        page-break-inside: avoid
      }

      .watermark {
            opacity: 0.1;
            position: absolute;
            left:50px;
            text-align: center;
            top:40%;
            bottom:50%;
            z-index:99999;
        }

    </style>

</head>

<body class="pace-done">

  <header>

    <div class="watermark">
      <img class="img" width="700" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
    </div>

  </header>
  <footer>

      <table class="table table-style">
        <tr class="m-t-20">
            <th colspan="6" style="text-align: center;padding-top:5px;color:white;font-size:12px;">CONHEÇA NOSSAS UNIDADES</th>
        </tr>
        <tr class="m-t-20">
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">VITÓRIA
              <br><small style="font-size:8px">Av. Paulino Muller, 885 - Jucutuquara, Vitória - ES, 29051-035</small>
            </th>
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">VILA VELHA I
              <br><small style="font-size:8px">R. Araribóia, 719, Centro, Vila Velha - ES, 29100-970</small>
            </th>
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">VILA VELHA II
              <br><small style="font-size:8px">AR. Rejente Feijó, 04, Nossa Senhora da Penha, Vila Velha - ES, 29110-160</small>
            </th>
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">CARIACICA
              <br><small style="font-size:8px">Av. Espírito Santo, 13 - Morada de Campo Grande, Cariacica - ES, 29144-080</small>
            </th>
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">SERRA
              <br><small style="font-size:8px">R. Isaac Newton, 154 - Parque Res. Laranjeiras, Serra - ES, 29165-180</small>
            </th>
            <th style="text-align: center;padding-top:10px;color:white;font-size:12px;">BAIXO GUANDU
              <br><small style="font-size:8px">R. Sebastião Cândido de Oliveira, 507, 3º andar, Sl 303, Centro, Baixo Guandú - ES, 29730-000</small>
            </th>
        </tr>
      </table>

  </footer>

  <div style="background-color:white;">
      <div class="card-body">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div>
                  <div class="panel-body">
                    <div class="table-responsive">
                      @yield('content')
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </div>

  </div>

</body>

</html>
