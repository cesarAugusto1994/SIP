@extends('partials.template-report')

@section('content')

<table class="table table-bordered table-style" style="font-size:11px;margin-bottom:50px;">

  <thead>
    <tr>
        <td class="text-center" colspan="2"><h4><b>FATURAMENTO DE ENTREGAS </b></h4>
            <span>{{ $first->format('d/m/Y') }} até {{ $last->format('d/m/Y') }}</span>
        </td>
        <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ asset('images/logo-provider.png') }}" alt="" /></td>
    </tr>
    <tr class="table-primary">
        <th>Cliente</th>
        <th style="width:80px">Entregas</th>
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

@stop
