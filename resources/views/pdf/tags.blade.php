<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('admin/img/RedukLogo/favicon.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="http://cdn.jsdelivr.net/npm/inspinia@2.6.5/dist/inspinia.min.css"/>

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
<div style="width:100%;max-height:100px;min-height:100px;padding:0.6em 0.6em;top:0;margin-top:0">
  <!--public_path('/admin/img/RedukLogo/LogoNegativoPdf.png-->
<img class="img" style="max-height:100px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
</div>
  <div class="wrapper wrapper-content">
      <div class="ibox-content">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <h4>Ordem de Entrega: #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</h4>
              </div>

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="">
                  <div class="panel-body">

                    <div class="row">

                      <div class="col-md-12 pull-right">

                        @php
                            $route = route('start_delivery', $delivery->uuid);
                        @endphp

                          {!! QrCode::size(145)->generate($route); !!}

                      </div>

                      <div class="col-md-12">

                          <h3>{{ $delivery->client->name }}</h3>

                          <address>
                              <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }},<br>
                              <b>Bairro:</b> {{ $delivery->address->district }},<br>
                              <b>Complemento:</b> {{ $delivery->address->complement }}<br>
                              <b>Cidade:</b> {{ $delivery->address->city }}<br>
                              <b>CEP:</b> {{ $delivery->address->zip }}<br>
                              <b>Referencia:</b> {{ $delivery->address->reference }}<br>
                              <br>
                              <b>Email:</b> {{ $delivery->client->email }}<br>
                              <b>Telefone:</b> {{ $delivery->client->phone }}
                          </address>

                          <address>
                            <strong>Entregador</strong><br>
                            <span id="entregador"><span class="text-navy">{{ $delivery->user->person->name }} - {{ $delivery->user->person->cpf }}</span></span>
                          </address>

                      </div>

                    </div>

                    <div class="bg-white" style="border-bottom:2px dashed grey;padding:2em 2em;margin-bottom:5em"></div>

                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <h4>Comprovante de Entrega de Documentos</h4>
                    </div>

                    <table class="table table-bordered">

                      <thead>
                        <tr>
                            <td class="text-center">Empresa</td>
                            <td class="text-center" colspan="2"><b>{{ $delivery->client->name }}</b></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <th>Funcionário</th>
                            <th>Referência</th>
                            <th>Entregue?</th>
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
                              <td>
                                  Sim <input type="checkbox"/>
                                  Não <input type="checkbox"/>
                              </td>
                          </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" class="text-center font-10"><b>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS,
                            DATADOS E CARIMBADOS.</b></td>
                        </tr>

                        <tr>
                            <td>Data/Hora: __/__/____ __:__</td>
                            <td colspan="3">Assinatura: ___________________________________________</td>
                        </tr>

                      </tbody>
                      <tfoot>
                        <tr>
                            <td colspan="4">Ordem Entrega: #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</td>
                        </tr>
                        <tr>
                            <td colspan="4"><small>Etiqueta gerada por: {{ \Auth::user()->id }} - {{ \Auth::user()->person->name }}</small></td>
                        </tr>
                      </tfoot>

                    </table>

                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>

</body>

</html>
