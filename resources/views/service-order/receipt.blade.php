@extends('partials.template-report')

@section('content')

<table class="table table-bordered table-style" style="font-size:12px;margin-bottom:50px;">

  <tbody>
    <tr>
        <td class="text-center" colspan="5"><h4><b>ORDEM DE SERVIÇO</b></h4></td>
        <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ asset('images/logo-provider.png') }}" alt="" /></td>
    </tr>
    <tr>
        <td colspan="6" style="padding-left:13px;">
          <h3>PROVIDER SAÚDE E SEGURANÇA DO TRABALHO LTDA ME</h3>

          <address>
              <b>CNPJ:</b> 07.110.470/0001-57<br>
              <b>Endereço:</b> Av. Paulino Muller, 885 - Jucutuquara, Vitória - ES, 29051-035<br>
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
              <b>Código OS:</b> #{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}<br>
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
      <td colspan="2">Unidade</td>
      <td colspan="4">Endereço</td>
    </tr>

    @foreach($order->addresses as $address)
      @php
          $address = $address->address;
      @endphp
      <tr>
          <td colspan="2">{{ $address->description }}
            <br/><small style="font-size:10px">CNPJ: {{ $address->document }}</small>
          </td>
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
      <td colspan="3">Serviço</td>
      <td style="width:80px">Prazo</td>
      <td style="width:80px">Quantidade</td>
      <td style="width:80px">Valor</td>
    </tr>


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
        <td>{{ $order->installment_quantity }} x R$ {{ $order->installment_value ? number_format($order->installment_value, 2, ',', '.') : '0,00' }}</td>
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
          <span><b>DATA DE SOLICITAÇÃO DE DADOS AO CLIENTE</b></span>: {{ $order->client_data_solicitation_date ? $order->client_data_solicitation_date->format('d/m/Y') : '' }}
          <br/>
          <span><b>DATA DE RETORNO DO CLIENTE</b></span>: {{ $order->client_feedback_date ? $order->client_feedback_date->format('d/m/Y') : '' }}
          <br/>
          <span><b>DATA DE LIBERAÇÃO DA OS PARA ÁREA TÉCNICA</b></span>: {{ $order->release_date ? $order->release_date->format('d/m/Y') : '' }}
          <br/>
          <span><b>SERVIÇO CONCLUÍDO?</b></span>: {{ $order->completed_service ? 'Sim' : 'Não' }}

        </td>
        <td colspan="3" style="text-align:justify;">
          <span><b>OBSERVAÇÕES QUANTO A EVOLUÇÃO DA OS</b></span>:<br/> {{ $order->observation }}
        </td>
    </tr>

  </tbody>

</table>

@stop
