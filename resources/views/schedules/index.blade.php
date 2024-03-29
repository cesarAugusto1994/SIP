@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Agenda</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Agenda</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-block">

        <div id="openviewWeather">
            <a class="weatherwidget-io" href="https://forecast7.com/pt/n20d30n40d30/vitoria/" data-label_1="VITORIA" data-label_2="Clima" data-theme="original" >VITORIA Clima</a>
        </div>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Seus Compromissos</h5>
      </div>
      <div class="card-block">

          <div class="row">
              <div class="col-xl-2 col-sm-12">

                <div class="card">
                    <div class="card-header">
                        <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
                    </div>
                    <div class="card-block">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-controls select2" name="user" id="user-schedules">
                                  <option value="">Usuário</option>
                                  @foreach(\App\Helpers\Helper::users() as $user)
                                    @if(auth()->user()->isAdmin())
                                      <option value="{{ $user->uuid }}">{{$user->person->name}}</option>
                                    @else
                                      <option value="{{ auth()->user()->uuid }}">{{ auth()->user()->person->name }}</option>
                                    @endif
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

              </div>
              <div class="col-xl-10 col-sm-12">
                  <div id='calendar'></div>
              </div>
          </div>
      </div>
  </div>

</div>


<div class="modal inmodal" id="sechedule-modal" tabindex="-1" role="dialog" aria-hidden="true"  style="z-index:1041">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
              <h4 class="modal-title">Novo Compromisso</h4>
            </div>

            <form id="form-schedule" data-parsley-validate method="POST" action="{{ route('schedules.store') }}">
              <div class="modal-body">

                    {{  csrf_field() }}
                    <div class="row">

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Titulo</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input autofocus required class="form-control input-lg" name="title" id="title">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group ">
                              <label>Inicio</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="start" name="start" required readonly class="form-control datetimepicker" data-date-format="dd/mm/yyyy hh:ii" value="">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group ">
                              <label>Fim</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" id="end" name="end" required readonly class="form-control datetimepicker" data-date-format="dd/mm/yyyy hh:ii" value="">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Dia Inteiro</label>
                              <div class="input-group">
                                <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="all_day" class="js-switch">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Adicionar convidados</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                  <select class="form-control select2" multiple title="Selecione um convidado" name="guests[]" id="guests">
                                    <option value="todos">Todos</option>
                                    @foreach(App\Helpers\Helper::users() as $user)
                                        @if($user->id == auth()->user()->id) @continue; @endif
                                        <option value="{{$user->id}}">{{$user->person->name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Tipo Evento</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                  <select class="form-control select2" name="event_type" id="event_type">
                                    @foreach(App\Helpers\Helper::scheduleTypes() as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                  </select>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group" id="pac-card">
                              <label>Localização</label>
                              <div class="input-group" id="pac-container">
                                  <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                  <input class="form-control" name="localization" id="pac-input">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Adicionar uma descrição</label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                <textarea class="form-control" rows="6" id="description" name="description"></textarea>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Criar Nova tarefa</label>
                              <div class="input-group">
                                <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="do_task" class="js-switch">
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Enviar e-mail de Notificação</label>
                              <div class="input-group">
                                <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="send_notification_mail" class="js-switch">
                              </div>
                          </div>
                      </div>

                    </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="submit" id="btnSchedule" class="btn btn-success">Salvar</button>
              </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" id="schedule-json" value="{{ route('schedule_list') }}"/>

@endsection

@section('scripts')

  <script>
  !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
  </script>

  <script>

    $(document).ready(function() {

      var btnSchedule = $('#btnSchedule');
      var formSchedule = $('#form-schedule').parsley();

      formSchedule.on('form:submit', function(e) {

          swal({
            title: 'Aguarde um instante.',
            text: 'Salvando o compromisso...',
            type: 'success',
            showConfirmButton: false,
            allowOutsideClick: false
          });

      });;

      $('#user-schedules').on('select2:select', function (e) {

        var userSchedule = $("#user-schedules").val();
        var route = $("#schedule-json").val() + '?user=' + userSchedule;

        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('addEventSource', route);

      });

    });

  </script>

@stop
