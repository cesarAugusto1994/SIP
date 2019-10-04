@foreach($deliveries as $delivery)
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

      .divA {page-break-inside: avoid}

    </style>

</head>

<body class="pace-done">
  <div style="padding:20px 20px 0 20px;min-height: 600px;" class="divA">
      <div class="ibox-content">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="">
                  <div class="panel-body">

                    <table class="table table-bordered table-style">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="2"><h4><b>ORDEM DE ENTREGA</b> #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</h4></td>
                            <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:13px;">
                              <h3>{{ $delivery->client->name }}</h3>

                              <address>
                                  <b>CNPJ:</b> {{ $delivery->client->document }}<br>
                                  <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}<br>
                                  <b>Cidade:</b> {{ $delivery->address->city }}, {{ $delivery->address->zip }}<br>
                              </address>
                            </td>
                            <td>

                              @php
                                  $route = route('start_delivery', $delivery->uuid);
                              @endphp

                                {!! QrCode::size(100)->generate($route); !!}

                            </td>

                        </tr>
                        <tr>
                            <td class="text-center" colspan="3"><b>Comprovante de Entrega de Documentos</b></td>
                        </tr>
                        <tr class="table-success">
                          <th>TIPO</th>
                          <th>OBSERVAÇÂO</th>
                          <th style="width:100px">DEVOLVIDO?</th>
                        </tr>
                      </thead>

                      <tbody>

                        @foreach($delivery->documents->sortBy('document.employee.name') as $document)
                        @php
                            $document = $document->document;
                        @endphp
                          <tr>
                              <td>{{ $document->type->name }}
                                <br/>
                                <small>{{ $document->created_at->format('d/m/Y') }}</small>
                              </td>
                              <td>
                              @if($document->employee)
                                  Funcionário: {{ $document->employee->name ?? '' }} <br/>
                                  <small>CPF: {{ $document->employee->cpf ?? '' }}</small>
                              @elseif($document->reference)
                                  <small>Referência: {{ $document->reference ?? '' }}</small>
                              @endif

                              @if($document->address)
                                  @php
                                      $formated = $document->address->description . ' - ' . $document->address->document;
                                  @endphp
                                  <br/>
                                  <small>Unidade: {{ $formated }}</small>
                              @endif
                              </td>
                              <td>

                              </td>
                          </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-center font-9"><br/><p style="font-size:9px"><b>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS,
                            DATADOS E CARIMBADOS.</b></p></td>
                        </tr>

                        <tr>
                            <td>Data/Hora: __/__/____ __:__</td>
                            <td colspan="2"><b>Assinatura:</b> </td>
                        </tr>

                        <tr>
                            <td><small>Ordem Entrega: <b>#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</b></small></td>
                            <td><small>Gerado por: {{ substr(\Auth::user()->uuid, 0, 8) }} - {{ \Auth::user()->person->name }} <br/> Em: <b>{{ $delivery->created_at ? $delivery->created_at->format('d/m/Y H:i') : '' }}</b></small></td>
                            <td><small>Entregador: <br/>{{ $delivery->user->person->name }}</small></td>
                        </tr>

                      </tbody>
                      <tfoot>

                      </tfoot>

                    </table>

                    @if($delivery->documents->count() < 2)

                    <div class="bg-white" style="border:1px dashed #212529;background-color: #212529;margin-bottom:0.8em"></div>

                    <table class="table table-bordered table-style">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="2"><h4><b>ORDEM DE ENTREGA</b> #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</h4></td>
                            <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-left:13px;">
                              <h3>{{ $delivery->client->name }}</h3>

                              <address>
                                  <b>CNPJ:</b> {{ $delivery->client->document }}<br>
                                  <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}<br>
                                  <b>Cidade:</b> {{ $delivery->address->city }}, {{ $delivery->address->zip }}<br>
                              </address>
                            </td>
                            <td>

                              @php
                                  $route = route('start_delivery', $delivery->uuid);
                              @endphp

                                {!! QrCode::size(100)->generate($route); !!}

                            </td>

                        </tr>
                        <tr>
                            <td class="text-center" colspan="3"><b>Comprovante de Entrega de Documentos</b></td>
                        </tr>
                        <tr class="table-primary">
                          <th>TIPO</th>
                          <th>OBSERVAÇÂO</th>
                          <th style="width:100px">DEVOLVIDO?</th>
                        </tr>
                      </thead>

                      <tbody>

                        @foreach($delivery->documents->sortBy('document.employee.name') as $document)
                        @php
                            $document = $document->document;
                        @endphp
                          <tr>
                              <td>{{ $document->type->name }}
                                <br/>
                                <small>{{ $document->created_at->format('d/m/Y') }}</small>
                              </td>
                              <td>
                              @if($document->employee)
                                  Funcionário: {{ $document->employee->name ?? '' }} <br/>
                                  <small>CPF: {{ $document->employee->cpf ?? '' }}</small>
                              @elseif($document->reference)
                                  <small>Referência: {{ $document->reference ?? '' }}</small>
                              @endif

                              @if($document->address)
                                  @php
                                      $formated = $document->address->description . ' - ' . $document->address->document;
                                  @endphp
                                  <br/>
                                  <small>Unidade: {{ $formated }}</small>
                              @endif
                              </td>
                              <td>

                              </td>
                          </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-center font-9"><br/><p style="font-size:9px"><b>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS,
                            DATADOS E CARIMBADOS.</b></p></td>
                        </tr>

                        <tr>
                            <td>Data/Hora: __/__/____ __:__</td>
                            <td colspan="2">Assinatura: </td>
                        </tr>

                        <tr>
                            <td><small>Ordem Entrega: <b>#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</b></small></td>
                            <td><small>Gerado por: {{ substr(\Auth::user()->uuid, 0, 8) }} - {{ \Auth::user()->person->name }} <br/> Em: <b>{{ $delivery->created_at ? $delivery->created_at->format('d/m/Y H:i') : '' }}</b></small></td>
                            <td><small>Entregador: {{ $delivery->user->person->name }}</small></td>
                        </tr>

                      </tbody>

                    </table>

                    @endif

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
@endforeach
