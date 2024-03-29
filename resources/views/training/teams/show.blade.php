@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Turmas</h4>
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
                        <a href="{{ route('teams.index') }}"> Turmas </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
        <div class="card-block">

          @if($hasAgendado)
            <button type="button" class="btn btn-outline-success btn-sm waves-effect waves-light" data-toggle="modal" data-target=".statusTeam">Marcar Presença</button>
          @endif

          <a href="{{ route('teams.edit', $team->uuid) }}" class="btn btn-outline-info btn-sm waves-effect waves-light"><i class="far fa-edit"></i> Editar Informações</a>

          <div class="btn-group dropdown-split-primary">
            @permission('edit.turmas')

              @if($team->status == 'RESERVADO')

                  <a href="#!" data-route="{{ route('team_start', $team->uuid) }}" class="btn btn-success btn-sm btnStartTeam"><i class="ti-control-play"></i> <span>Iniciar Curso</span></a>

              @endif

              @if($team->status == 'EM ANDAMENTO')

                  <a href="#!" data-route="{{ route('team_finish', $team->uuid) }}" class="btn btn-success btn-sm btnFinishTeam"><i class="ti-control-pause"></i> <span>Finalizar Curso</span></a>

              @endif

            @endpermission
              <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="sr-only">Toggle primary</span>
              </button>
              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(113px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">

                  <a target="_blank" href="{{ route('team_presence_list', $team->uuid) }}" class="dropdown-item btn-primary"><i class="ti-list"></i> <span>Lista de Presença</span></a>

                  <!--
                  <a href="#!" data-route="{{ route('team_duplicate', $team->uuid) }}" class="dropdown-item btn-primary"><i class="far fa-copy"></i> Duplicar</a>
                -->

                  @if($team->status == 'FINALIZADA')

                      <a target="_blank" href="{{ route('team_certified_company', $team->uuid) }}" class="dropdown-item btn-primary"><i class="ti-file"></i> <span>Certificado por Empresa</span></a>
                      <a target="_blank" href="{{ route('team_certified_team', $team->uuid) }}" class="dropdown-item btn-primary"><i class="ti-file"></i> <span>Certificado por Turma</span></a>

                  @endif

              </div>

          </div>

        </div>
    </div>

    @if($team->status == 'FINALIZADA')
      <div class="card bg-c-green update-card">
          <div class="card-header">
              <h4>Treinamento Finalizado</h4>
          </div>
      </div>
    @elseif($team->status == 'CANCELADA')
      <div class="card bg-c-pink update-card">
          <div class="card-header">
              <h4>Treinamento Cancelado</h4>
          </div>
      </div>
    @endif

    @if($team->vacancies < $team->employees->count())
      <div class="alert alert-warning">
          <h3>Atenção</h3>
          <p>A quantidade de participantes excede o limite de vagas atribuído à turma.</p>
      </div>
    @endif

    <div class="card">
        <div class="card-header card bg-c-green update-card">
            <h5 class="text-white">Informações da turma </h5>
        </div>
        <div class="card-block">

          <div class="view-info">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="general-info">
                          <div class="row">
                              <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                      <table class="table m-0">
                                          <tbody>
                                              <tr>
                                                  <th scope="row">Turma</th>
                                                  <td>#{{ str_pad($team->id, 6, "0", STR_PAD_LEFT)  }}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Curso</th>
                                                  <td>{{ $team->course->title }}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Instrutor</th>
                                                  <td>{{ $team->teacher->person->name }}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Data</th>
                                                  <td>
                                                    @if($diffDays > 1)
                                                        {{ $team->start->format('d/m/Y') }} à {{ $team->end->format('d/m/Y') }}
                                                    @else
                                                        {{ $team->start->format('d/m/Y') }} {{ $team->start->format('H:i') }} até {{ $team->end->format('H:i') }}
                                                    @endif
                                                    </td>
                                              </tr>

                                              <tr>
                                                  <th scope="row">Local</th>
                                                  <td>{{ $team->localization }}</td>
                                              </tr>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <!-- end of table col-lg-6 -->
                              <div class="col-lg-12 col-xl-6">
                                  <div class="table-responsive">
                                      <table class="table">
                                          <tbody>
                                              <tr>
                                                  <th scope="row">Situação</th>
                                                  <td>{{ ucfirst($team->status) }}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Carga horaria</th>
                                                  <td>{{ $team->course->workload }} hora(s)</td>
                                              </tr>

                                              <tr>
                                                  <th scope="row">Vagas</th>
                                                  <td>{{$team->employees->count()}} de {{$team->vacancies}} vagas</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Porcentagem Vagas preenchidas</th>
                                                  <td>{{ round(($team->employees->count() / intval($team->vacancies)) * 100, 2) }}%</td>
                                              </tr>

                                              <tr>
                                                  <th scope="row">Observações</th>
                                                  <td>{!! $team->description !!}</td>
                                              </tr>

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
    </div>

    <div class="row">

      <div class="col-md-3">

    @permission('create.turmas')

      @if($team->status == 'RESERVADO' || $team->status == 'EM ANDAMENTO')

        <div class="card">
            <div class="card-header card bg-danger update-card">
                <h5 class="text-white">Adicionar Funcionários</h5>
            </div>
            <div class="card-block">

              <form class="formValidation" data-parsley-validate method="post" action="{{route('teams_add_employees', ['id' => $team->uuid])}}">

                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="form-group {!! $errors->has('employees') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="employees">Funcionários</label>
                      <div class="input-group">
                          <select multiple class="form-control select-employees" name="employees[]" id="employees" required></select>
                      </div>
                      {!! $errors->first('employees', '<p class="help-block">:message</p>') !!}
                  </div>

                <button type="submit" class="btn btn-primary btn-sm">Salvar</button>

              </form>

            </div>
        </div>

      @endif

    @endpermission

      </div>

      <div class="col-md-9">

        <div class="card">
            <div class="card-header">
                <h5>Lista Funcionários para o Curso </h5>
                <span>({{ $team->employees->count() }}) registros encontrados.</span>

                <div class="modal fade statusTeam" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mySmallModalLabel">Presença</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>

                            <form data-parsley-validate method="post" action="{{route('team_employee_presence', $team->uuid)}}">

                            <div class="modal-body">

                                  {{csrf_field()}}

                                  <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>

                                              <th>Presente?</th>
                                              <th>Nome</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($team->employees->sortBy('employee.name') as $employeeItem)

                                                @php
                                                    $employee = $employeeItem->employee;

                                                    $checked = null;

                                                    if($employeeItem->status == 'PRESENTE') {
                                                        $checked = 'checked';
                                                    }
                                                @endphp

                                                <input name="employees[]" value="{{ $employeeItem->uuid }}" type="hidden"/>

                                                <tr>

                                                    <td><input class="js-switch" type="checkbox" {{ $checked }} name="employee-{{ $employeeItem->uuid }}" value="1"/></td>
                                                    <td>
                                                        <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                                        @if(\App\Helpers\Helper::actualCompany($employee))
                                                          <br/>
                                                          <a href="{{route('clients.show', \App\Helpers\Helper::actualCompany($employee)->uuid)}}"><small>{{ \App\Helpers\Helper::actualCompany($employee)->name }}</small></a>
                                                        @endif
                                                    </td>

                                                </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                  </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary btnChangeStatus waves-effect waves-light">Salvar</button>
                            </div>

                            </form>

                        </div>
                    </div>
                </div>

            </div>
            <div class="card-block table-border-style">

              @if($team->employees->isNotEmpty())
                <div class="table-responsive">
                  <table class="table table-lg table-styling">
                      <thead>
                          <tr class="table-inverse">
                            <th>Nome</th>
                            <th>Situação</th>
                            <th>Opções</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($team->employees->sortBy('employee.name') as $employeeItem)

                              @php
                                  $employee = $employeeItem->employee;
                              @endphp

                              <tr>

                                  <td>
                                      <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                      @if(\App\Helpers\Helper::actualCompany($employee))
                                      <br/>
                                      <a href="{{route('clients.show', \App\Helpers\Helper::actualCompany($employee)->uuid)}}"><small>{{ \App\Helpers\Helper::actualCompany($employee)->name }}</small></a>
                                      @endif
                                      @if(\App\Helpers\Helper::actualOccupation($employee))
                                      <br/>
                                      <small>Função: {{ \App\Helpers\Helper::actualOccupation($employee)->name }}</small>
                                      @endif
                                      <br/>
                                      <small>CPF: {{ \App\Helpers\Helper::formatCnpjCpf($employee->cpf) }}</small>

                                  </td>

                                  <td>
                                    @if($employeeItem->status == 'AGENDADO')
                                      <span class="badge badge-primary">{{ $employeeItem->status }}</span>
                                    @elseif($employeeItem->status == 'PRESENTE')
                                      <span class="badge badge-success">{{ $employeeItem->status }}</span>
                                    @elseif($employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA')
                                      <span class="badge badge-danger">{{ $employeeItem->status }}</span>
                                    @endif
                                  </td>

                                  <td class="dropdown">

                                    @if(in_array($team->status, ['RESERVADO', 'EM ANDAMENTO']))

                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                       <a href="{{ route('teams_employee_status', $employeeItem->uuid) }}"
                                       class="dropdown-item" style="cursor:pointer">Editar Situação</a>
                                       <a data-route="{{route('teams_employee_destroy', [$team->uuid, $employeeItem->uuid])}}" data-reload="1"
                                         class="dropdown-item btnRemoveItem" style="cursor:pointer">Remover </a>
                                    </div>

                                    @endif

                                    @if($employeeItem->approved)
                                      <a target="_blank" href="{{route('team_certified', [$employeeItem->uuid])}}"
                                        class="btn btn-sm btn-success">Gerar Certificado</a>
                                    @endif

                                  </td>

                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
              @else
                <div class="widget white-bg no-padding">
                    <div class="p-m text-center">
                        <h1 class="m-md"><i class="fas fa-users fa-2x"></i></h1>
                        <h6 class="font-bold no-margins">
                            Nenhum registro encontrado.
                        </h6>
                    </div>
                </div>
              @endif

            </div>
        </div>

      </div>

    </div>

    <div class="card">
        <div class="card-header bg-c-green update-card">
            <h5 class="text-white">Adicionar Lista de Presença </h5>
        </div>
        <div class="card-block">

          <form class="m-t-30" data-parsley-validate method="post" enctype="multipart/form-data" action="{{route('teams_upload_presence_list', ['id' => $team->uuid])}}">

            {{csrf_field()}}

            <div class="form-group {!! $errors->has('presence_list') ? 'has-error' : '' !!}">
                  <label class="col-form-label" for="presence_list">Upload da Lista</label>
                  <div class="input-group">
                      <input required name="presence_list" data-buttonText="Selecionar Documento" data-dragdrop="true" data-badge="false" type="file" data-input="true"
                      accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" class="filestyle" multiple/>
                  </div>
                  {!! $errors->first('presence_list', '<p class="help-block">:message</p>') !!}
              </div>

            <button type="submit" class="btn btn-success btn-sm">Enviar</button>

          </form>

        </div>
    </div>

    @if($team->presence_list)
    <div class="card">
        <div class="card-header bg-c-green update-card">
            <h5 class="text-white">Lista de Presença </h5>
        </div>
        <div class="card-block">

          <ul class="media-list m-t-30">

            <li class="media d-flex m-b-10 mediaFile">
                <div class="m-r-20 v-middle">
                    <i class="icofont icofont-file-pdf f-28 text-muted"></i>
                </div>
                <div class="media-body">
                    <a target="_blank" href="{{ route('teams_preview_presence_list', $team->uuid) }}" class="m-b-5 d-block">Visualizar Lista</a>
                </div>
            </li>

          </ul>

        </div>
    </div>
    @endif

</div>

@endsection

@section('scripts')

<script>

    $(".btnStartTeam").click(function(e) {
        var self = $(this);

        swal({
          title: 'Iniciar o Curso?',
          text: "Tenha certeza que quer Iniciar o curso!",
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim, Iniciar',
          cancelButtonText: 'Não'
          }).then((result) => {
          if (result.value) {

            e.preventDefault();

            window.swal({
              title: 'Em progresso...',
              text: 'Iniciando o Curso.',
              type: 'success',
              showConfirmButton: false,
              allowOutsideClick: false
            });

            $.ajax({
              headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
              url: self.data('route'),
              type: 'POST',
              dataType: 'json',
              data: {}
            }).done(function(data) {

              swal.close();

              if(data.success) {

                window.location.reload();

                notify(data.message, 'inverse');

              } else {

                notify2(data.message, 'danger');

              }

            });
          }
        });
    });

    $(".btnFinishTeam").click(function(e) {
        var self = $(this);

        swal({
          title: 'Finalizar o Curso?',
          text: "Tenha certeza que quer finalizar o curso!",
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim, Finalizar',
          cancelButtonText: 'Não'
          }).then((result) => {
          if (result.value) {

            e.preventDefault();

            window.swal({
              title: 'Em progresso...',
              text: 'Aguarde enquanto a requisição é processada.',
              type: 'success',
              showConfirmButton: false,
              allowOutsideClick: false
            });

            $.ajax({
              headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
              url: self.data('route'),
              type: 'POST',
              dataType: 'json',
              data: {}
            }).done(function(data) {

              swal.close();

              if(data.success) {

                window.location.reload();

                notify(data.message, 'inverse');

              } else {

                notify2(data.message, 'danger');

              }

            });
          }
        });
    });

    $(".btnDuplicate").click(function(e) {
        var self = $(this);

        swal({
          title: 'Duplicar Turma?',
          text: "Deseja duplicar esta Turma?",
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Não'
          }).then((result) => {
          if (result.value) {

            e.preventDefault();

            window.swal({
              title: 'Em progresso...',
              text: 'Aguarde enquanto a requisição é processada.',
              type: 'success',
              showConfirmButton: false,
              allowOutsideClick: false
            });

            $.ajax({
              headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
              url: self.data('route'),
              type: 'POST',
              dataType: 'json',
              data: {}
            }).done(function(data) {

              if(data.success) {

                notify(data.message, 'inverse');

                window.location.href = data.route;

              } else {

                swal.close();

                notify2(data.message, 'danger');

              }

            });
          }
        });
    });

</script>

@endsection
