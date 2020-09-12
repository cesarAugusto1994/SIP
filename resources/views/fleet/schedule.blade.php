@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Agenda Frota</h4>
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
      <div class="card-header">
          <h5>Calendário</h5>
      </div>
      <div class="card-block">
          <div class="row">
              <div class="col-xl-12 col-md-12">
                  <div id='calendar-teams'></div>
              </div>
          </div>
      </div>
  </div>

</div>

<div class="modal inmodal" id="calendar-modal" tabindex="-1" role="dialog" aria-hidden="true"  style="z-index:1041">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
              <h4 class="modal-title">Agendamento de Veículos</h4>
            </div>

            <form class="formValidation" data-parsley-validate method="POST" action="{{ route('vehicle-schedule.store') }}">
            <div class="modal-body">

                  {{  csrf_field() }}
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Motorista</label>
                            <div class="input-group">
                              <select class="form-control" name="driver_id" required>
                                  @foreach(App\Helpers\Helper::users() as $user)
                                        <option value="{{$user->id}}" {{ auth()->user()->id == $user->id ? 'selected' : ''}}>{{$user->person->name}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Veículo</label>
                            <div class="input-group">
                              <select class="form-control" name="vehicle_id" required>
                                  @foreach($vehicles->sortBy('name') as $vehicle)
                                        <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                                  @endforeach
                              </select>
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
                            <label>Vagas Disponíveis</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="0" min="0" max="4" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar Caronas</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control select2" multiple name="guests[]" id="guests">
                                  @foreach(App\Helpers\Helper::users() as $user)
                                      <option value="{{$user->id}}">{{$user->person->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" id="pac-card">
                            <label>Destino</label>
                            <div class="input-group" id="pac-container">
                                <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                <input class="form-control" name="ride_to" id="pac-input" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Motivo</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                              <textarea class="form-control" rows="6" id="reason" name="reason" required></textarea>
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
                <button type="submit" id="btnConsulta" class="btn btn-success">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" id="schedule-json" value="{{ route('vehicle_schedule_list') }}"/>

@endsection

@section('scripts')

<script>

$(document).ready(function() {

let $calendar = $('#calendar-teams');

$calendar.fullCalendar({
    height: 380,
    contentHeight: 590,
    views: {
      listDay: {
        buttonText: 'list day',
        titleFormat: "dddd, DD MMMM YYYY",
        columnFormat: "",
        timeFormat: "HH:mm"
      },

      listWeek: {
        buttonText: 'list week',
        columnFormat: "ddd D",
        timeFormat: "HH:mm"
      },

      listMonth: {
        buttonText: 'list month',
        titleFormat: "MMMM YYYY",
        timeFormat: "HH:mm"
      },

      month: {
        buttonText: 'month',
        titleFormat: 'MMMM YYYY',
        columnFormat: "ddd",
        timeFormat: "HH:mm"
      },

      agendaWeek: {
        buttonText: 'agendaWeek',
        columnFormat: "ddd D",
        timeFormat: "HH:mm"
      },

      agendaDay: {
        buttonText: 'agendaDay',
        titleFormat: 'dddd, DD MMMM YYYY',
        columnFormat: "",
        timeFormat: "HH:mm"
      },
    },
    lang: 'pt-br',
    defaultView: 'month',
    eventBorderColor: "#de1f1f",
    eventColor: "#AC1E23",
    slotLabelFormat: 'HH:mm',
    eventLimitText: 'Compromissos',
    borderColor: '#FC6180',
    backgroundColor: '#FC6180',
    droppable: true,
    businessHours: true,
    editable: true,
    allDaySlot: true,
    eventLimit: false,
    minTime: '06:00:00',
    maxTime: '22:00:00',
    header: {
        left: 'prev,next,today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth,listWeek,listDay'
    },
    navLinks: true,
    selectable: true,
    selectHelper: true,
    select: function(start, end, jsEvent, view) {
        var view = $('.calendar').fullCalendar('getView');
        $("#calendar-modal").modal('show');
        $("#start").val(start.format('DD/MM/YYYY HH:mm'));
        $("#end").val(end.format('DD/MM/YYYY HH:mm'));
    },
    eventClick: function(event, element, view) {

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto carregamos o agendamento.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

        window.location.href = event.route;
    },

    dayClick: function(date, jsEvent, view) {

        jsEvent.preventDefault();

        setTimeout(function() {

            $("#formConsultaModal").prop('action', $("#consultas-store").val());

        }, 100);

    },
    events: $("#schedule-json").val(),
    //color: 'black', // an option!
    //textColor: 'yellow', // an option!
    //When u drop an event in the calendar do the following:
    eventDrop: function(event, delta, revertFunc) {
        //console.log(event);
        popularModal(event);
    },
    //When u resize an event in the calendar do the following:
    eventResize: function(event, delta, revertFunc) {
        //console.log(event);
        popularModal(event);
    },
    eventRender: function(event, element) {
        $(element).tooltip({
            title: event.title
        });
    },
    ignoreTimezone: false,
    allDayText: 'Dia Inteiro',
    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
    axisFormat: 'HH:mm',
    buttonText: {
        prev: "<",
        next: ">",
        prevYear: "Ano anterior",
        nextYear: "Proximo ano",
        today: "Hoje",
        month: "Mês",
        week: "Semana",
        day: "Dia",
        listMonth: "Lista Mensal",
        listWeek: "Lista Semanal",
        listDay: "Lista Diária"
    }

});

});

</script>

@stop
