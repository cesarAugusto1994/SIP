<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Ordem de Serviço #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }} </title>
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

      .page-header {
        /*margin-top: -80px !important;*/
      }

      @print {
        footer {
          background-color: #005432; height: 130px;
        }
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

      .table>tbody>tr {
        page-break-inside: avoid
      }

      .watermark {
            opacity: 0.2;
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
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">VITÓRIA
              <br><small style="font-size:8px">Av. Paulino Muller, 885 - Ilha de Santa Maria, Vitória - ES, 29051-035</small>
            </th>
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">VILA VELHA I
              <br><small style="font-size:8px">R. Araribóia, 719, Centro, Vila Velha - ES, 29100-970</small>
            </th>
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">VILA VELHA II
              <br><small style="font-size:8px">AR. Rejente Feijó, 04, Nossa Senhora da Penha, Vila Velha - ES, 29110-160</small>
            </th>
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">CARIACICA
              <br><small style="font-size:8px">Av. Espírito Santo, 13 - Morada de Campo Grande, Cariacica - ES, 29144-080</small>
            </th>
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">SERRA
              <br><small style="font-size:8px">R. Isaac Newton, 154 - Parque Res. Laranjeiras, Serra - ES, 29165-180</small>
            </th>
            <th style="text-align: center;padding-top:20px;color:white;font-size:12px;">BAIXO GUANDU
              <br><small style="font-size:8px">R. Sebastião Cândido de Oliveira, 507, 3º andar, Sl 303, Centro, Baixo Guandu - ES, 29730-000</small>
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

                    <table class="table table-bordered table-style">

                      <tbody>
                        <tr>
                            <td class="text-center" colspan="5"><h4><b>ORDEM DE SERVIÇO</b> #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}</h4></td>
                            <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding-left:13px;">
                              <h3>Provider Saúde Coporativa Integral LTDA-ME</h3>

                              <address>
                                  <b>CNPJ:</b> 07.110.470/0001-57<br>
                                  <b>Endereço:</b> Av. Paulino Muller, 885 - Ilha de Santa Maria, Vitória - ES, 29051-035<br>
                                  <b>Telefones:</b> (27) 3223-3130 e (27) 3322-0030
                              </address>
                            </td>

                        </tr>
                        <tr>
                            <td class="text-center" colspan="6"><b>DADOS GERAIS</b></td>
                        </tr>

                        <tr>
                            <td colspan="3">

                              <h3>{{ $order->client->name }}</h3>

                              <address>
                                  <b>CNPJ:</b> {{ $order->client->document }}<br>
                                  <b>Tipo de Contrato:</b> {{ $order->contract->name }}<br>
                                  <b>Contato Cliente:</b> {{ $order->contact ? $order->contact->name : '-' }}<br>
                              </address>

                            </td>

                            <td colspan="3">

                              <address>
                                  <b>Código da OS:</b> #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}<br>
                                  <b>Data:</b> {{ $order->created_at->format('d/m/Y') }}<br>

                                  <b>Telefones:</b>
                                    @foreach($order->client->phones as $phone)
                                        {{ $phone->number }}<br>
                                    @endforeach
                                  <br>
                                  <b>Email:</b>
                                    @foreach($order->client->emails as $email)
                                        {{ $email->email }},
                                    @endforeach
                                  <br>
                              </address>

                            </td>
                        </tr>

                        <tr>
                            <td class="text-center" colspan="6"><b>ENDEREÇOS/UNIDADES</b></td>
                        </tr>
                        <tr>
                          <td>Unidade</td>
                          <td style="width:140px;">CNPJ</td>
                          <td colspan="4">Endereço</td>
                        </tr>

                        @foreach($order->addresses as $address)
                          @php
                              $address = $address->address;
                          @endphp
                          <tr>
                              <td>{{ $address->description }}</td>
                              <td>{{ $address->document }}</td>
                              <td colspan="4">{{ $address->street }}, {{ $address->number }} - {{ $address->district }}, {{ $address->city }} / {{ $address->state }} - {{ $address->zip }}<br/>
                                  <small>{{ $address->complement }}</small>
                              </td>

                          </tr>
                        @endforeach

                        <tr>
                            <td class="text-center" colspan="6"></td>
                        </tr>

                        <tr>
                            <td class="text-center" colspan="6"><b>PRODUTOS/SERVIÇOS LIBERADOS PARA EXECUÇÃO</b></td>
                        </tr>

                        <tr>
                          <td>Serviço</td>
                          <td>Observação</td>
                          <td style="width:140px;">Executor</td>
                          <td>Prazo</td>
                          <td>Quantidade</td>
                          <td>Valor</td>
                        </tr>

                        @foreach($order->services as $service)
                          @foreach($service->service->values->where('contract_id', $order->contract_id) as $value)
                          <tr>
                              <td>{{ $service->service->name }}</td>
                              <td>{{ $service->observation }}</td>
                              <td>{{ $service->user ? $service->user->person->name : '' }}</td>
                              <td>{{ $service->deadline ? $service->deadline->format('d/m/Y') : '' }}</td>
                              <td>{{ $service->quantity ?? 1}}</td>
                              @if(!request()->has('without_value'))
                                <td>{{ number_format($service->value, 2, ',', '.') }}</td>
                              @else
                                <td>0,00</td>
                              @endif
                          </tr>
                          @endforeach
                        @endforeach

                        <tr>
                            <td class="text-center" colspan="6"></td>
                        </tr>

                        @if(!request()->has('without_value'))

                          <tr>
                              <td class="text-center" colspan="6"><b>DADOS FINANCEIROS</b></td>
                          </tr>

                          <tr>
                            <td>Valor Total</td>
                            <td>Vlr. Desconto</td>
                            <td>Vlr. Entrada</td>
                            <td>Dt. Vencto</td>
                            <td>Vlr. Parcela</td>
                            <td>Dt. Parcela</td>
                          </tr>

                        <tr>
                            <td>R$ {{ $order->amount ? number_format($order->amount, 2, ',', '.') : number_format($order->services->sum('value'), 2, ',', '.') }}</td>
                            <td>{{ $order->discount ? number_format($order->discount, 2, ',', '.') : '0,00' }}</td>
                            <td>R$ {{ $order->input_value ? number_format($order->input_value, 2, ',', '.') : '0,00' }}</td>
                            <td>{{ $order->due_date ? $order->due_date->format('d/m/Y') : '' }}</td>
                            <td>R$ {{ $order->installment_value ? number_format($order->installment_value, 2, ',', '.') : '0,00' }}</td>
                            <td>{{ $order->installment_date ? $order->installment_date->format('d/m/Y') : '' }}</td>
                        </tr>

                        @endif

                        <tr>
                            <td class="text-center" colspan="6"></td>
                        </tr>

                        <tr>
                            <td class="text-center" colspan="6"><b>CONTROLE DE EVOLUÇÃO DA OS</b></td>
                        </tr>

                        <tr>
                            <td colspan="3">
                              <span>DATA DE SOLICITAÇÃO DE DADOS AO CLIENTE</span>: {{ $order->client_data_solicitation_date ? $order->client_data_solicitation_date->format('d/m/Y') : '' }}
                              <br/>
                              <span>DATA DE RETORNO DO CLIENTE</span>: {{ $order->client_feedback_date ? $order->client_feedback_date->format('d/m/Y') : '' }}
                              <br/>
                              <span>DATA DE LIBERAÇÃO DA OS PARA ÁREA TÉCNICA</span>: {{ $order->release_date ? $order->release_date->format('d/m/Y') : '' }}
                              <br/>
                              <span>SERVIÇO CONCLUÍDO?</span>: {{ $order->completed_service ? 'Sim' : 'Não' }}

                            </td>
                            <td colspan="3">
                              <span>OBSERVAÇÕES QUANTO A EVOLUÇÃO DA OS</span>: {{ $order->observation }}
                            </td>
                        </tr>

                      </tbody>

                    </table>

                  </div>
                </div>
              </div>
          </div>
      </div>

  </div>

  <script>
      //window.print();
      window.onfocus=function() {
          //window.close();
      }
  </script>

</body>

</html>
