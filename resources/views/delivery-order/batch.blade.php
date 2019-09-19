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
  <div style="width:100%;max-height:100px;min-height:100px;padding:0.6em 0.6em;top:0;margin-top:0">
    <!--public_path('/admin/img/RedukLogo/LogoNegativoPdf.png-->
    <img class="img" style="max-height:100px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
  </div>
  <div style="padding:0px 10px 0px 10px; min-height:900px!important ">
      <div class="ibox-content">
          <div class="row">

              <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                  <h4>ORDEM DE ENTREGA: #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</h4>
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

                          <h4>{{ $delivery->client->name }}</h4>

                          <address>
                              <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}<br>
                              <b>Cidade:</b> {{ $delivery->address->city }}, {{ $delivery->address->zip }}<br>
                          </address>

                      </div>

                    </div>

                    <table class="table table-bordered">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="2"><b>Comprovante de Entrega de Documentos</b></td>
                            <td class="text-center"><img style="padding:3px" class="img" width="64" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <th>Funcionário / Referência</th>
                            <th style="width:100px">Entregue?</th>
                        </tr>
                      </thead>

                      <tbody>

                        @foreach($delivery->documents->sortBy('document.employee.name') as $document)
                        @php
                            $document = $document->document;
                        @endphp
                          <tr>
                              <td>{{ $document->type->name }}</td>
                              @if($document->employee)
                              <td>{{ $document->employee->name ?? '' }}</td>
                              @else
                              <td>{{ $document->reference ?? '' }}</td>
                              @endif
                              <td>
                                  Sim <input type="checkbox"/>
                                  Não <input type="checkbox"/>
                              </td>
                          </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-center font-9"><p style="font-size:9px"><b>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS,
                            DATADOS E CARIMBADOS.</b></p></td>
                        </tr>

                        <tr>
                            <td>Data/Hora: __/__/____ __:__</td>
                            <td colspan="2">Assinatura: _______________________________________________</td>
                        </tr>

                        <tr>
                            <td><small>Ordem Entrega: <b>#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT)  }}</b></small></td>
                            <td><small>Gerado por: {{ substr(\Auth::user()->uuid, 0, 8) }} - {{ \Auth::user()->person->name }} <br/> Em: <b>{{ $delivery->created_at ? $delivery->created_at->format('d/m/Y H:i') : '' }}</b></small></td>
                            <td><small>Entregador: {{ $delivery->user->person->name }}</small></td>
                        </tr>

                      </tbody>
                      <tfoot>

                      </tfoot>

                    </table>

                    @if($delivery->documents->count() < 6)

                    <div class="bg-white" style="border-bottom:2px dashed black;padding:0.3em 0.2em;margin-bottom:2em"></div>

                    <div class="row">
                    <div class="col-md-12 pull-right">

                      @php
                          $route = route('start_delivery', $delivery->uuid);
                      @endphp

                        {!! QrCode::size(100)->generate($route); !!}

                    </div>

                    <div class="col-md-12">

                      <h3>{{ $delivery->client->name }}</h3>

                      <address>
                          <b>Endereço:</b> {{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}<br>
                          <b>Cidade:</b> {{ $delivery->address->city }}, {{ $delivery->address->zip }}<br>
                      </address>

                    </div>
                    </div>

                    <table class="table table-bordered">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="2"><b>Comprovante de Entrega de Documentos</b></td>
                            <td class="text-center"><img style="padding:3px" class="img" width="64" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <th>Funcionário / Referência</th>
                            <th style="width:100px">Entregue?</th>
                        </tr>
                      </thead>

                      <tbody>

                        @foreach($delivery->documents->sortBy('document.employee.name') as $document)
                        @php
                            $document = $document->document;
                        @endphp
                          <tr>
                              <td>{{ $document->type->name }}</td>
                              @if($document->employee)
                              <td>{{ $document->employee->name ?? '' }}</td>
                              @else
                              <td>{{ $document->reference ?? '' }}</td>
                              @endif
                              <td>
                                  Sim <input type="checkbox"/>
                                  Não <input type="checkbox"/>
                              </td>
                          </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-center font-9"><p style="font-size:9px"><b>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS,
                            DATADOS E CARIMBADOS.</b></p></td>
                        </tr>

                        <tr>
                            <td>Data/Hora: __/__/____ __:__</td>
                            <td colspan="2">Assinatura: _______________________________________________</td>
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
  </script>

</body>

</html>
@endforeach
