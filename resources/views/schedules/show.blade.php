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
                    <li class="breadcrumb-item">
                        <a href="{{ route('schedules.index') }}"> Agenda </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

  <div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h5><i class="icofont icofont-tasks-alt m-r-5"></i>{{ $schedule->title }}</h5>
            <span class="label label-lg label-success f-right"> {{ $schedule->type->name }}  </span></a>
        </div>

        <div class="card-block">
            <div class="">
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Informações</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="m-b-10 f-w-600">Inicio</p>
                            <h6 class="text-muted f-w-400">{{ $schedule->start->format('d/m/Y H:i') }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="m-b-10 f-w-600">Fim</p>
                            <h6 class="text-muted f-w-400">{{ $schedule->end->format('d/m/Y H:i') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Descrição</h6>
                    {{ $schedule->description }}
                </div>
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Localização</h6>
                    {{ $schedule->localization }}
                </div>
            </div>
        </div>
        <div class="card-footer">

          <div class="f-left">
            @if(auth()->user()->id == $schedule->user->id)
              <a data-route="{{ route('schedules.destroy', $schedule->uuid) }}" class="btn btn-danger text-white btn-sm waves-effect waves-light btnRemoveItemToBack" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remover"><i class="icofont icofont-close"></i>Remover</a>
            @endif
          </div>

          <div class="f-right d-flex">
            @if(auth()->user()->id == $schedule->user->id)
              <a href="{{ route('schedules.edit', ['id' => $schedule->uuid]) }}" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="icofont icofont-edit"></i>Editar</a>
            @endif
          </div>

        </div>
    </div>

    <div class="card comment-block">
        <div class="card-header">
            <h5 class="card-header-text"><i class="icofont icofont-comment m-r-5"></i>Comentários</h5>
        </div>
        <div class="card-block">
            <ul class="media-list">

                <div id="div-coments-list"></div>

              @foreach($schedule->messages->sortByDesc('id') as $message)

                <li class="media mediaFile">
                    <div class="media-left">
                        <img class="media-object img-radius comment-img" src="{{ route('image', ['user' => $message->user->uuid, 'link' => $message->user->avatar, 'avatar' => true])}}" title="{{$message->user->name}}" alt="{{$message->user->name}}">
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading txt-primary"><span class="f-12 text-muted m-l-5">{{ $message->user->person->name }}, {{$message->created_at->format('d/m/Y H:i:s')}}</span>

                          @if(auth()->user()->isAdmin() || $message->user->id == auth()->user()->id)
                              <a href="#" data-route="{{ route('schedule_message_destroy', $message->uuid) }}" class="btn btn-danger btn-sm btn-round f-right btnRemoveItem" style="cursor:pointer"><i class="fa fa-trash"></i> Apagar</a>
                          @endif

                        </h6>
                        <p>{{$message->message}}</p>

                        <hr/>
                    </div>
                </li>

              @endforeach

            </ul>
            <div class="md-float-material d-flex">
                <div class="col-md-12 btn-add-task">
                  <form id="form-schedule-comment" class="formValidation" data-parsley-validate method="post" action="{{route('schedule_message_store')}}">
                    {{csrf_field()}}
                    <input name="schedule_id" id="schedule_id" type="hidden" value="{{$schedule->uuid}}"/>
                    <textarea rows="5" name="message" id="message" class="form-control" required placeholder="Insira um Comentário"></textarea>
                    <br/>
                    <button class="btn btn-success">Enviar</button>
                  </form>

                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-lg-4">

    <div class="row">

      <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text"><i class="icofont icofont-users-alt-4"></i> Agenda de</h5>
            </div>
            <div class="card-block user-box assign-user">

                <div class="media">
                    <div class="media-left media-middle photo-table">
                        <a href="#">
                            <img class="img-radius" src="{{ route('image', ['user' => $schedule->user->uuid, 'link' => $schedule->user->avatar, 'avatar' => true])}}" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6>{{ $schedule->user->person->name }}</h6>
                        <span class="text-muted">{{ $schedule->user->person->department->name }}</span>
                    </div>
                    <div>
                        <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                    </div>
                </div>

            </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-header-text"><i class="icofont icofont-users-alt-4"></i> Participantes</h5>
            </div>
            <div class="card-block user-box assign-user">

              @foreach($schedule->guests as $guest)
                <div class="media">
                    <div class="media-left media-middle photo-table">
                        <a href="#">
                            <img class="img-radius" src="{{ route('image', ['user' => $guest->user->uuid, 'link' => $guest->user->avatar, 'avatar' => true])}}" alt="">
                        </a>
                    </div>
                    <div class="media-body">
                      @if($guest->read_at)
                          <small class="text-muted f-right">Visto em: {{ $guest->read_at->format('d/m/Y H:i:s') }}</small>
                      @endif
                      <h6>{{ $guest->user->person->name }}</h6>
                      <p class="text-muted">{{ $guest->user->person->department->name }}</p>
                      @if(!$guest->accept && auth()->user()->uuid == $guest->user->uuid)
                          <button class="btn btn-primary btn-sm btn-confirm-presence" data-url="{{ route('schedule_event_presence', $guest->uuid) }}">Marcar Presença</button>
                      @endif

                      @if($guest->accept)
                          <span class="label label-success">Presença Marcada</span>
                      @endif

                    </div>
                    <div>
                        <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                    </div>
                </div>

                <h6 class="sub-title m-b-15"></h6>

              @endforeach

            </div>
        </div>
      </div>

    </div>

  </div>

  </div>

</div>

<input type="hidden" id="input-post-schedule-comment" value="{{ route('schedule_message_store', $schedule->uuid) }}">

@endsection


@section('scripts')

<script>

    var formTicket = $("#form-schedule-comment");
    var comentsList = $("#div-coments-list");
    var inputPostComment = $("#input-post-schedule-comment").val();

    var $html = "";

    formTicket.submit(function(e) {

      var message = $("#message").val();

      e.preventDefault();
      swal.close();

      $html += '<li class="media mediaFile">' +
                  '<div class="media-left">' +
                      '<img class="media-object img-radius comment-img" src="{{ route('image', ['user' => auth()->user()->uuid, 'link' => auth()->user()->avatar, 'avatar' => true])}}" alt="">' +
                  '</div>' +
                  '<div class="media-body">' +
                      '<h6 class="media-heading txt-primary"><span class="f-12 text-muted m-l-5">{{ auth()->user()->person->name }}, {{ now()->format("d/m/Y H:i:s") }}</span> </h6>' +
                      '<p>' + message + '</p>' +
                  '</div>' +
              '</li>';

      comentsList.append($html);

      $.ajax({
        headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: inputPostComment,
        data: {
            message: message,
            schedule_id: $("#schedule_id").val()
        }

      });

      $("#message").val("");

      return false;

    });

    var btnConfirmPresence = $(".btn-confirm-presence");

    btnConfirmPresence.click(function() {

      var self = $(this);
      var url = self.data('url');

      swal({
        title: 'Confirmar Presença',
        text: "Deseja confirmar presença neste evento?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0ac282',
        cancelButtonColor: '#D46A6A',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Cancelar'
        }).then((result) => {
        if (result.value) {

          swal({
            title: 'Aguarde um instante.',
            text: 'Carregando os dados...',
            type: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
          });

          $.ajax({
            headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: url,
            success: function(data) {
                notify(data.message, 'inverse');
                self.parents('.media-body')
                .append('<span class="label label-success">Presença Marcada</span>');
                self.hide();
            }, complete: function() {
                swal.close();
            }

          });

        }
      });

    });

</script>

@endsection
