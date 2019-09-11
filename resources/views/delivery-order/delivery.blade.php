<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('adminty\css\style.css') }}"/>

    <style>

      @page {
          margin-top: 0;
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

    </style>

</head>

<body class="pace-done">
<div class="text-center" style="width:100%;max-height:100px;min-height:100px;padding:0.6em 0.6em;top:0;margin-top:0">
  <!--public_path('/admin/img/RedukLogo/LogoNegativoPdf.png-->
<img class="img" style="max-height:100px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
</div>
  <div style="padding:0px 10px 0px 10px">
      <div class="ibox-content">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <h4>Ordem de Entrega: #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</h4>
                  <label class="label label-primary">{{ $delivery->status->name }}</label>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="">
                  <div class="panel-body">

                    <div class="row">

                      <div class="col-md-12 pull-right">

                        @php
                            $route = route('start_delivery', $delivery->uuid);
                        @endphp

                          {!! QrCode::size(120)->generate($route); !!}

                      </div>

                      <div class="col-md-12">

                          <h3>{{ $delivery->client->name }}</h3>

                          <address>
                              <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}<br>
                              <b>Cidade:</b> {{ $delivery->address->city }}, {{ $delivery->address->zip }}<br>
                          </address>

                      </div>

                      <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                          <h4>Comprovante de Entrega de Documentos</h4>
                      </div>

                      <table class="table table-bordered" style="font-size:11px">

                        <thead>
                          <tr>
                              <td class="text-center">Empresa</td>
                              <td class="text-center" colspan="2"><b>{{ $delivery->client->name }}</b></td>
                          </tr>
                          <tr>
                              <th>Tipo</th>
                              <th>Funcionário</th>
                              <th>Referência</th>
                          </tr>
                        </thead>

                        <tbody>

                          @foreach($delivery->documents as $document)
                          @php
                              $document = $document->document;
                          @endphp
                            <tr>
                                <td>{{ $document->type->name }}</td>
                                <td>{{ $document->employee->name ?? '' }}</td>
                                <td>{{ $document->reference ?? '' }}</td>

                            </tr>
                          @endforeach

                        </tbody>
                        <tfoot>
                          <tr>
                              <td colspan="3"><small>Entregue Por: {{ $delivery->user->person->name }}</small></td>
                          </tr>
                          <tr>

                          </tr>
                        </tfoot>

                      </table>

                    </div>

                    <a class="btn btn-primary btn-block" href="{{ route('delivery_receipt_image', $delivery->uuid) }}"> Comprovante </a>

                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
</body>

</html>
