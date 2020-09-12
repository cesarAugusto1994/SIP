@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cliente Treinamentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.index') }}"> Clientes </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.show', $client->uuid) }}"> {{ $client->name }} </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Treinamentos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">

      <div class="card-block">

          <a href="{{route('clients.show', $client->uuid)}}" class="btn btn-primary btn-sm"> Voltar</a>

      </div>
  </div>

  <div class="row">

      <div class="col-md-12">

          <div class="card">
              <div class="card-header">
                  <h5>Treinamentos</h5>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-styling">
                          <thead>
                              <tr class="table-primary">
                                <th>Nome</th>
                                <th>Curso</th>
                                <th>Data</th>
                                <th>Certificado</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($client->employees as $employee)
                              @php
                                  $employee = $employee->employee;
                              @endphp
                              @foreach($employee->trainings as $training)

                                  @if($training->status == 'FINALIZADA')
                                      @continue;
                                  @endif

                                  <tr>
                                      <td>
                                          <p><a href="{{route('employees.show', $employee->uuid)}}">{{ $employee->name }}</a></p>
                                      </td>
                                      <td>
                                          {{$training->team->course->title}}<br/><a href="{{ route('teams.show', $training->team->uuid) }}" class="card-title"><small>Turma: #{{ str_pad($training->team->id, 6, "0", STR_PAD_LEFT) }}</small></a>
                                      </td>
                                      <td>
                                          <p>{{$training->team->start->format('d/m/Y H:i')}} até {{$training->team->end->format('d/m/Y H:i')}}</p>
                                      </td>
                                      <td>
                                        <a target="_blank" href="{{route('team_certified', [$training->uuid])}}"
                                          class="btn btn-sm btn-outline-success">Gerar Certificado</a>
                                      </td>
                                  </tr>
                              @endforeach
                            @endforeach
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>

      </div>

  </div>

</div>

@endsection
