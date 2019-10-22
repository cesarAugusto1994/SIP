@extends('partials.template-report')

@section('content')

@foreach($periodDate as $dt)
<table class="table table-bordered table-lg table-styling" style="font-size:12px;margin-bottom:50px;">

  <thead>
    <tr>
        <th class="text-center" colspan="5" style="vertical-align: middle;text-transform:uppercase;"><h5><b>Lista de Presença - Treinamento {{ $team->course->title }}</b></h5></th>
        <th class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></th>
    </tr>

    <tr>

        <td colspan="4">
          <b>Curso:</b> {{ $team->course->title }}<br/>
          <b>Turma:</b> #{{ str_pad($team->id, 6, "0", STR_PAD_LEFT) }},
          <b>Carga horaria: </b>{{ $team->course->workload }} hora(s)<br>
          <b>Instrutor:</b> {{ $team->teacher->person->name }} - {{ $team->teacher->person->cpf }}<br/>
            @if($team->teacher->person->registry)
                {{ $team->teacher->person->registry }}<br/>
            @endif
        </td>
        <td colspan="2">
            <b>Data:</b>
            {{ $dt->format('d/m/Y') }}<br/>
          <b>Local:</b> {{ $team->localization }}</td>
    </tr>

    <tr>
        <th colspan="2">Prestador</th>
        <th colspan="3">Empresa</th>
        <th>Assinatura</th>
    </tr>
  </thead>

  <tbody>

    @foreach($team->employees as $employeeItem)
    @php
        $employee = $employeeItem->employee;
    @endphp
      <tr class="{{ $employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA' ? 'table-danger' : '' }}">
          <td colspan="2"><span style="text-transform:uppercase;">{{$employee->name}}</span><br>
            <small style="font-size:10px">CPF: {{ $employee->cpf }}</small><br/>
            <small style="font-size:10px">Função: {{ $employee->occupation->name }}</small>
          </td>
          <td colspan="3"><span style="font-size:12px">{{$employee->company->name}}</span>
            <br/>
            <small style="font-size:10px">CNPJ: {{ $employee->company->document }}</small>
          </td>
          <td class="text-center" style="vertical-align:middle;">
            @if($employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA')
              AUSENTE

            @else

            <span style="opacity:0.3;">{{$employee->name}}</span>

            @endif
          </td>
      </tr>
    @endforeach
    <tr>
        <td colspan="6">
          Observações: {{ $team->description }}
        </td>
    </tr>
    <tr>
        <td colspan="6"><b>Assinatura do Instrutor: </b></td>
    </tr>

  </tbody>
  <tfoot>

  </tfoot>

</table>
@endforeach

@stop
