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
              <h4 class="modal-title">Nova Turma</h4>
            </div>

            <form class="formValidation" data-parsley-validate method="POST" action="{{ route('teams.store') }}">
            <div class="modal-body">

                  {{  csrf_field() }}
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Curso</label>
                            <div class="input-group">
                              <select class="form-control" name="course_id" required>
                                  @foreach($courses->sortBy('name') as $course)
                                        <option value="{{$course->uuid}}">{{$course->title}}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Instrutor</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              <select class="form-control" name="teacher_id" required>
                                  @foreach($teachers->sortBy('name') as $teacher)
                                        <option value="{{$teacher->user->uuid}}">{{$teacher->name}}</option>
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
                            <label>Vagas</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="number" id="vacancies" name="vacancies" class="form-control" value="20" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar Funcionários</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select multiple class="form-control select-employees" name="employees[]" id="employees"></select>
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

<input type="hidden" id="schedule-json" value="{{ route('team_schedule_list') }}"/>

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
          text: 'Aguarde enquanto carregamos o compromisso.',
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
        //popularModal(event);
    },
    //When u resize an event in the calendar do the following:
    eventResize: function(event, delta, revertFunc) {
        //console.log(event);
        //popularModal(event);
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
