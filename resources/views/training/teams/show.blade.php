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

    @if($team->status == 'RESERVADO' || $team->status == 'EM ANDAMENTO')
        <div class="card">
            <div class="card-header">
                <h5>Menu de opções </h5>

            </div>
            <div class="card-block">

              @if($team->status == 'RESERVADO')

                  <form action="{{ route('team_start', $team->uuid) }}" method="POST" style="display: inline;">{{ csrf_field() }}
                    <button class="btn btn-success btn-sm"><i class="ti-control-play"></i> <span>Iniciar Curso</span></button>
                  </form>

              @endif

              @if($team->status == 'EM ANDAMENTO')

                  <a href="#!" data-route="{{ route('team_finish', $team->uuid) }}" class="btn btn-danger btn-sm btnFinishTeam"><i class="ti-control-pause"></i> <span>Finalizar Curso</span></a>

              @endif

              <a href="{{ route('teams.edit', $team->uuid) }}" class="btn btn-primary btn-sm waves-effect waves-light"><i class="far fa-edit"></i> Editar Informações</a>

              <div class="modal fade editTeam" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="mySmallModalLabel">Editar Informações</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          </div>

                          <form class="formValidation" data-parsley-validate method="post" action="{{route('teams.update', ['id' => $team->uuid])}}">

                          <div class="modal-body">

                                {{csrf_field()}}
                                {{method_field('PUT')}}

                                <div class="row">

                                    <div class="col-md-6">

                                      <div class="form-group {!! $errors->has('course_id') ? 'has-error' : '' !!}">
                                          <label class="col-form-label" for="course_id">Curso</label>
                                          <div class="input-group">
                                            <select class="form-control" name="course_id" required>
                                                @foreach($courses->sortBy('name') as $course)
                                                      <option value="{{$course->uuid}}" {{ $team->course_id == $course->id ? 'selected' : '' }}>{{$course->title}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                          {!! $errors->first('course_id', '<p class="help-block">:message</p>') !!}
                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group {!! $errors->has('teacher_id') ? 'has-error' : '' !!}">
                                          <label class="col-form-label" for="teacher_id">Instrutor</label>
                                          <div class="input-group">
                                            <select class="form-control" name="teacher_id" required>
                                                @foreach($teachers->sortBy('name') as $teacher)
                                                      <option value="{{$teacher->user->uuid}}" {{ $team->teacher_id == $teacher->id ? 'selected' : '' }}>{{$teacher->name}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                          {!! $errors->first('teacher_id', '<p class="help-block">:message</p>') !!}
                                      </div>

                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="col-form-label" for="teacher_id">Data</label>
                                          <div class="input-group">
                                              <input type="text" class="input-md form-control inputDateTime" name="start" value="{{ $team->start->format('d/m/Y H:i') }}"/>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                          <label class="col-form-label" for="teacher_id">Data</label>
                                          <div class="input-group">
                                              <input type="text" class="input-md form-control inputDateTime" name="end" value="{{ $team->end->format('d/m/Y H:i') }}"/>
                                          </div>
                                      </div>
                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group {!! $errors->has('status') ? 'has-error' : '' !!}">
                                          <label class="col-form-label" for="status">Status</label>
                                          <div class="input-group">
                                            <select class="form-control" name="status" required>
                                                <option value="RESERVADO" {{ $team->status == 'RESERVADO' ? 'selected' : '' }}>RESERVADO</option>
                                                <option value="EM ANDAMENTO" {{ $team->status == 'EM ANDAMENTO' ? 'selected' : '' }}>EM ANDAMENTO</option>
                                                <option value="FINALIZADA" {{ $team->status == 'FINALIZADA' ? 'selected' : '' }}>FINALIZADA</option>
                                                <option value="CANCELADA" {{ $team->status == 'CANCELADA' ? 'selected' : '' }}>CANCELADA</option>
                                            </select>
                                          </div>
                                          {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                                      </div>

                                    </div>

                                    <div class="col-md-6">

                                      <div class="form-group {!! $errors->has('vacancies') ? 'has-error' : '' !!}">
                                          <label class="col-form-label" for="vacancies">Vagas</label>
                                          <div class="input-group">
                                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="{{ $team->vacancies }}" required>

                                          </div>
                                          {!! $errors->first('vacancies', '<p class="help-block">:message</p>') !!}
                                      </div>

                                    </div>

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
        </div>
    @endif

    @if($team->status == 'FINALIZADA')
      <div class="card bg-c-green update-card">
          <div class="card-header">
              <h4>Curso Finalizado</h4>
          </div>
      </div>
    @elseif($team->status == 'CANCELADA')
      <div class="col-sm-12">
          <div class="card bg-c-pink update-card">
              <div class="card-header">
                  <h4>Curso Cancelado</h4>
              </div>
          </div>
      </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Informações da turma </h5>

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
                                                  <td>{{ $teamCode }}</td>
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
                                                  <td>{{ $team->start->format('d/m H:i') }} à {{ $team->end->format('d/m H:i') }}</td>
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
                                                  <td>{{ $team->description }}</td>
                                              </tr>

                                          </tbody>
                                      </table>
                                  </div>
                              </div>
                              <!-- end of table col-lg-6 -->
                          </div>
                          <!-- end of row -->
                      </div>
                      <!-- end of general info -->
                  </div>
                  <!-- end of col-lg-12 -->
              </div>
              <!-- end of row -->
          </div>

        </div>
    </div>

    @permission('create.clientes')

    @if($team->status == 'RESERVADO' || $team->status == 'EM ANDAMENTO')

    <div class="card">
        <div class="card-header">
            <h5>Adicionar Funcionário </h5>
        </div>
        <div class="card-block">

          <form class="formValidation" data-parsley-validate method="post" action="{{route('teams_add_employees', ['id' => $team->uuid])}}">

            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="form-group {!! $errors->has('employees') ? 'has-error' : '' !!}">
                  <label class="col-form-label" for="employees">Funcionários</label>
                  <div class="input-group">
                    <select required style="z-index:99999" class="form-control m-b select2 selectEmployee" data-route="{{ route('employees_find') }}" name="employees[]" multiple placeholder="Informe os Funcionários" required>
                        @foreach($companies->sortBy('name') as $company)
                          <optgroup label="{{ $company->name }}">
                            @foreach($company->employees as $employee)

                              @if(in_array($employee->id, $employeesSelected))
                                  @continue;
                              @endif

                              <option value="{{$employee->uuid}}">{{$employee->name}}</option>
                            @endforeach
                          </optgroup>
                        @endforeach
                    </select>
                  </div>
                  {!! $errors->first('employees', '<p class="help-block">:message</p>') !!}
              </div>

            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>

          </form>

        </div>
    </div>

    @endif

    @endpermission

    <div class="card">
        <div class="card-header">
            <h5>Lista Funcionários para o Curso </h5>
            <span>({{ $team->employees->count() }}) registros encontrados.</span>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                  @if($hasAgendado)
                    <li><button type="button" class="btn btn-success btn-sm waves-effect waves-light" data-toggle="modal" data-target=".statusTeam">Presença</button></li>
                  @endif
                </ul>
            </div>

            <div class="modal fade statusTeam" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mySmallModalLabel">Presença</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>

                        <form class="formValidation" data-parsley-validate method="post" action="{{route('team_employee_presence', $team->uuid)}}">

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
                                        @foreach($team->employees as $employeeItem)

                                            @php
                                                $employee = $employeeItem->employee;
                                            @endphp

                                            <input name="employees[]" value="{{ $employeeItem->uuid }}" type="hidden"/>

                                            <tr>

                                                <td><input class="js-switch" type="checkbox" name="employee-{{ $employeeItem->uuid }}" value="1"/></td>
                                                <td>
                                                    <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                                    <br/>
                                                    <a href="{{route('clients.show', $employee->company->uuid)}}"><small>{{$employee->company->name}}</small></a>
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
        <div class="card-block">

          @if($team->employees->isNotEmpty())
            <div class="table-responsive">
              <table class="table table-hover">
                  <thead>
                      <tr>

                        <th>Nome</th>
                        <th>Situação</th>
                        <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($team->employees as $employeeItem)

                          @php
                              $employee = $employeeItem->employee;
                          @endphp

                          <tr>

                              <td>
                                  <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                  <br/>
                                  <a href="{{route('clients.show', $employee->company->uuid)}}"><small>{{$employee->company->name}}</small></a>
                              </td>

                              <td>
                                @if($employeeItem->status == 'PRE-AGENDADO')
                                  <span class="badge badge-primary">{{ $employeeItem->status }}</span>
                                @elseif($employeeItem->status == 'AGENDADO')
                                  <span class="badge badge-success">{{ $employeeItem->status }}</span>
                                @elseif($employeeItem->status == 'PRESENTE')
                                  <span class="badge badge-success">{{ $employeeItem->status }}</span>
                                @elseif($employeeItem->status == 'CANCELADO' || $employeeItem->status == 'FALTA')
                                  <span class="badge badge-danger">{{ $employeeItem->status }}</span>
                                @endif
                              </td>

                              <td class="dropdown">

                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @if($team->status == 'RESERVADO' || $team->status == 'EM ANDAMENTO')
                                     <a href="{{ route('teams_employee_status', $employeeItem->uuid) }}"
                                     class="dropdown-item" style="cursor:pointer">Editar Situação</a>
                                    @endif

                                    @if($team->status == 'FINALIZADA')
                                      <a target="_blank" href="{{route('team_certified', [$team->uuid, $employee->uuid])}}"
                                        class="dropdown-item text-success">Gerar Certificado</a>
                                    @endif

                                   @if($team->status == 'RESERVADO' || $team->status == 'EM ANDAMENTO')
                                     <a data-route="{{route('teams_employee_destroy', [$team->uuid, $employeeItem->uuid])}}" data-reload="1"
                                       class="dropdown-item btnRemoveItem" style="cursor:pointer">Remover </a>
                                   @endif

                                </div>

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

@endsection

@section('scripts')

<script>

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

                notify(data.message, 'danger');

              }

            });
          }
        });
    });

</script>

@endsection
