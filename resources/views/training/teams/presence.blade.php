@extends('partials.template-report')

@section('content')

@foreach($periodDate as $dt)
<table class="table table-bordered table-lg table-styling" style="font-size:12px;margin-bottom:50px;padding-top:15px;page-break-after: always">

  <thead>
    <tr>
        <th class="text-center" colspan="5" style="vertical-align: middle;text-transform:uppercase;"><h5><b>Lista de Presença - Treinamento {{ $team->course->title }}</b></h5></th>
        <th class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ asset('images/logo-provider.png') }}" alt="" /></th>
    </tr>

    <tr>

        <td colspan="4">
          <b>Curso:</b> {{ $team->course->title }}<br/>
          <b>Turma:</b> #{{ str_pad($team->id, 6, "0", STR_PAD_LEFT) }},
          <b>Carga horaria: </b>{{ $team->course->workload }} hora(s)<br>
          <b>Instrutor:</b> {{ $team->teacher->person->name }} - {{ $team->teacher->person->cpf }}
            @if($team->teacher->person->registry)
                - {{ $team->teacher->person->registry }}<br/>
            @endif
        </td>
        <td colspan="2">
            <b>Data:</b>
            {{ $dt->format('d/m/Y') }}<br/>
          <b>Local:</b> {{ $team->localization ?? 'Centro de Treinamentos Provider' }}</td>
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
          <td colspan="2"><span style="text-transform:uppercase;">{{$employee->name}}</span>
            @if($employee->cpf)
            <br>
            <small style="font-size:10px">CPF: {{ \App\Helpers\Helper::formatCnpjCpf($employee->cpf) }}</small>
            @endif
            @if(\App\Helpers\Helper::actualOccupation($employee))
            <br/>
            <small style="font-size:10px">Função: {{ \App\Helpers\Helper::actualOccupation($employee)->name }}</small>
            @endif
          </td>
          <td colspan="3" style="font-size:10px">

            @if(\App\Helpers\Helper::actualCompany($employee))
              {{ \App\Helpers\Helper::actualCompany($employee)->name }}<br/>
              CNPJ: {{ \App\Helpers\Helper::formatCnpjCpf(\App\Helpers\Helper::actualCompany($employee)->document) }}
            @endif

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
