@extends('partials.template-report')

@section('content')

<table class="table table-bordered table-style">

  <thead>
    <tr>
        <td class="text-center" colspan="2"><h4><b>REMESSA DE ENTREGA</b> </h4></td>
        <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
    </tr>
    <tr>
        <td colspan="3" style="padding-left:13px;">
          <address>
              <b>Código:</b> #{{ str_pad($packing->id, 6, "0", STR_PAD_LEFT)  }}<br>
              <b>Entregador:</b> {{ $packing->deliver->person->name }}<br>
              <b>Data Entrega:</b> {{ $packing->delivery_date->format('d/m/Y') }}<br>

              <small>Gerado por: {{ substr(\Auth::user()->uuid, 0, 8) }} - {{ \Auth::user()->person->name }} em: <b>{{ $packing->created_at ? $packing->created_at->format('d/m/Y H:i') : '' }}</b></small>
          </address>
        </td>

    </tr>
    <tr>
        <td class="text-center" colspan="3"><b>Comprovante de Entrega de Documentos</b></td>
    </tr>
    <tr class="table-success">
      <th style="width:100px">Código</th>
      <th>Cliente</th>
      <th style="width:100px">Entregue?</th>
    </tr>
  </thead>

  <tbody>

    @foreach($packing->items as $item)

      @php
          $delivery = $item->delivery;
      @endphp

      <tr>
          <td style="font-size:12px">#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</td>
          <td style="font-size:12px">
          {{ $delivery->client->name }}

              <br/>
              <small style="font-size:10px">CNPJ: {{ \App\Helpers\Helper::formatCnpjCpf($delivery->client->document) }}</small>
              <br/>
              <small style="font-size:10px">{{$delivery->address->street}}, {{$delivery->address->number}} - {{$delivery->address->district}}, {{$delivery->address->city}}</small>

          </td>
          <td>

          </td>
      </tr>
    @endforeach

    <tr>
        <td colspan="3"></td>
    </tr>

    <tr>
        <td colspan="3"><p class="text-center">Inicio da Entrega</p></td>
    </tr>

    <tr>
        <td colspan="3"><b>Assinatura do Entregador:</b> <span style="opacity:0.3;">{{ $packing->deliver->person->name }}</span>
        <br/>
        Data/Hora:
        </td>
    </tr>

    <tr>
        <td colspan="3"><p class="text-center">Retorno da Entrega</p></td>
    </tr>

    <tr>
        <td colspan="3" style="height:20px"><b>Assinatura do Entregador:</b> <span style="opacity:0.3;">{{ $packing->deliver->person->name }}</span>
          <br/>
          Data/Hora:
        </td>
    </tr>

    <tr>
        <td colspan="3"><p class="text-center">Conferência</p></td>
    </tr>

    <tr>
        <td colspan="3" style="height:20px"><b>Assinatura do Conferênte:</b>
          <br/>
          Data/Hora:
        </td>
    </tr>

  </tbody>
  <tfoot>

  </tfoot>

</table>

@stop
