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
                    <li class="breadcrumb-item"><a href="#!">Informações do Funcionário</a></li>
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

                  @permission('edit.cliente.funcionarios')
                    <a href="{{route('employees.edit', ['id' => $employee->uuid])}}" class="btn btn-primary text-white btn-sm">Editar</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                <h5>Informações do Funcionário</h5>
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
                                @if($employee->active)
                                    <i class="fa fa-circle text-success"></i> Ativo
                                @else
                                    <i class="fa fa-circle text-danger"></i> Inativo
                                @endif
                              </td>
                          </tr>
                          <tr>
                              <th scope="row">E-mail</th>
                              <td>{{ $employee->email }}</td>
                          </tr>
                          <tr>
                              <th scope="row">CPF</th>
                              <td>{{ $employee->cpf }}</td>
                          </tr>
                          <tr>
                              <th scope="row">RG</th>
                              <td>{{ $employee->rg }}</td>
                          </tr>
                          <tr>
                              <th scope="row">Empresa</th>
                              <td><a href="{{route('clients.show', $employee->company->uuid)}}"><b>{{ $employee->company->name }}</b></a></td>
                          </tr>
                          <tr>
                              <th scope="row">Função</th>
                              <td>{{ $employee->occupation->name }}</td>
                          </tr>
                      </tbody>
                  </table>
              </div>

            </div>
        </div>

    </div>

    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h5>Treinamentos</h5>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
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

@endsection

@section('scripts')

<script></script>

@endsection
