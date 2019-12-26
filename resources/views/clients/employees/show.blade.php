@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários</h4>
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
                        <a href="{{ route('employees.index') }}"> Funcionários </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  <div class="btn-group dropdown-split-primary">
                    @permission('edit.cliente.funcionarios')
                      <a href="{{route('employees.edit', ['id' => $employee->uuid])}}" class="btn btn-primary btn-sm"><i class="icofont icofont-edit"></i>Editar</a>
                    @endpermission
                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="sr-only">Toggle primary</span>
                      </button>
                      <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                        @permission('edit.cliente.funcionarios')
                          <a class="dropdown-item text-primary" href="{{route('employee_transfer_company', ['id' => $employee->uuid])}}">Transferir de Empresa</a>
                          <a class="dropdown-item text-primary" href="{{route('employee_transfer_company', ['id' => $employee->uuid])}}">Transferir de Cargo</a>
                        @endpermission
                      </div>
                  </div>

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-md-4">

          <div class="card">
              <div class="card-header card bg-c-green update-card">
                  <h5 class="text-white">Informações do Funcionário</h5>
              </div>
              <div class="card-block">
                <div class="table-responsive">
                    <table class="table m-0">
                        <tbody>
                            <tr>
                                <th scope="row">Nome</th>
                                <td>{{ $employee->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Situação</th>
                                <td>
                                  <p>{!! \App\Helpers\Helper::activeOrNot($employee->active) !!}</p>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail</th>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Nascimento</th>
                                <td>{{ $employee->birth ? $employee->birth->format('d/m/Y') : '' }}</td>
                            </tr>
                            <tr>
                                <th scope="row">CPF</th>
                                <td>{{ \App\Helpers\Helper::formatCnpjCpf($employee->cpf) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">RG</th>
                                <td>{{ $employee->rg }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

              </div>
          </div>

      </div>

    <div class="col-md-8">

      <div class="row">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h5>Histórico de Empresas</h5>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-lg table-styling">
                            <thead>
                                <tr class="table-primary">
                                  <th>Empresa</th>
                                  <th>Contratação</th>
                                  <th>Desligamento</th>
                                  <th>Situação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->jobs->sortByDesc('id') as $job)

                                    <tr>
                                        <td>
                                            <a href="{{route('clients.show', $job->company->uuid) }}"><small>{{ $job->company->name }}</small></a>
                                            <br/>
                                            <small>CNPJ: {{ \App\Helpers\Helper::formatCnpjCpf($job->company->document) }}</small></a>
                                        </td>

                                        <td>
                                            {{ $job->hired_at ? $job->hired_at->format('d/m/Y') : '' }}
                                        </td>

                                        <td>
                                            {{ $job->fired_at ? $job->fired_at->format('d/m/Y') : '' }}
                                        </td>

                                        <td>
                                            <p>{!! \App\Helpers\Helper::activeOrNot($job->active) !!}</p>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h5>Histórico de Cargos</h5>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-lg table-styling">
                            <thead>
                                <tr class="table-inverse">
                                  <th>Cargo</th>
                                  <th>Situação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->occupations as $occupation)

                                    <tr>
                                        <td>
                                            {{$occupation->occupation->name}}
                                        </td>
                                        <td>
                                            <p>{!! \App\Helpers\Helper::activeOrNot($occupation->active) !!}</p>
                                        </td>
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h5>Treinamentos</h5>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table table-lg table-styling">
                            <thead>
                                <tr class="table-inverse">
                                  <th>Curso</th>
                                  <th>Data</th>
                                  <th>Certificado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee->trainings as $training)

                                    @if($training->status == 'FINALIZADA')
                                        @continue;
                                    @endif

                                    <tr>
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
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

      </div>

    </div>
  </div>

</div>

@endsection

@section('scripts')

<script></script>

@endsection
