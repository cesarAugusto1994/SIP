<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\bootstrap\css\bootstrap.min.css') }}">
    <link href="{{ asset('adminty\css\style.css') }}"/>

    <style>

      @page {
          margin-top: 20px;
          margin-left: 20px;
          margin-right: 20px;
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

      @media print {
        .table-bordered td, .table-bordered th {
            border: 1px solid #1b1e21 !important;
        }
      }

    </style>

</head>

<body class="pace-done">

  <div style="padding:0px 10px 0px 10px">
      <div class="ibox-content">
          <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="">
                  <div class="panel-body" style="font-size:11px">

                    <table class="table table-bordered table-framed">

                      <thead>
                        <tr>
                            <td class="text-center" colspan="4" style="vertical-align: middle;text-transform:uppercase;"><h5><b>Lista de Presença - Treinamento {{ $team->course->title }}</b></h5></td>
                            <td class="text-center" colspan="2"><img style="padding:3px" class="img" width="128" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
                        </tr>

                        <tr>
                            <td>
                              <b>Curso:</b> {{ $team->course->title }}<br/>

                            <td colspan="2">
                              <b>Turma:</b> #{{ str_pad($team->id, 6, "0", STR_PAD_LEFT) }},
                              <b>Carga horaria: </b>{{ $team->course->workload }} hora(s)<br>
                              <b>Instrutor:</b> {{ $team->teacher->person->name }} - {{ $team->teacher->person->cpf }}<br/>
                                @if($team->teacher->person->registry)
                                    REG/MTE: {{ $team->teacher->person->registry }}<br/>
                                @endif

                            </td>
                            <td><b>Data:</b> {{ $team->start->format('d/m/Y') }}</td>
                            <td colspan="2"><b>Local:</b> {{ $team->localization }}</td>
                        </tr>

                        <tr>
                            <th>Nome</th>
                            <th>Função</th>
                            <th>Empresa</th>
                            <th>CNPJ</th>
                            <th>OS</th>
                            <th>Assinatura</th>
                        </tr>
                      </thead>

                      <tbody>

                        @foreach($team->employees as $employeeItem)
                        @php
                            $employee = $employeeItem->employee;
                        @endphp
                          <tr class="{{ $employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA' ? 'table-danger' : '' }}">
                              <td style="text-transform:uppercase;">{{$employee->name}}</td>
                              <td>{{$employee->occupation->name}}</td>
                              <td>{{$employee->company->name}}</td>
                              <td style="font-size:10px">{{$employee->company->document}}</td>
                              <td style="width:150px">

                              </td>
                              <td style="width:220px;" class="text-center">
                                @if($employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA')
                                  AUSENTE
                                @endif
                              </td>
                          </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">
                              Observações: {{ $team->description }}
                            </td>
                            <td colspan="3"><b>Assinatura do Instrutor: </b></td>
                        </tr>

                      </tbody>
                      <tfoot>

                      </tfoot>

                    </table>

                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>

  <script>

    window.print();
    window.onfocus=function(){ window.close();}

  </script>

</body>

</html>
