@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Chamados</h4>
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
                        <a href="{{ route('tickets.index') }}"> Chamados </a>
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

    @if($ticket->logs->last()->status->id == 3)
    <div class="col-sm-12">
        <!-- List type card start -->
        <div class="card bg-c-green update-card">
            <div class="card-header">
                <h4>Chamado Concluído!</h4>
            </div>

              <div class="card-block">

                @if($ticket->user_id == auth()->user()->id)
                <p class="lead">Seu chamado foi concluído, agora informe se o chamado resolveu a sua necessidade.</p>
                <form style="display:inline" id="ticket-finish" style="display:inline" action="{{ route('ticket_finish', $ticket->uuid) }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-sm btn-round"><i class="fa fa-tag"></i>  Finalizar Chamado</button>
                </form>
                @else
                <p class="lead">Agora é preciso que o solicitante finalize o chamado.</p>
                @endif

              </div>

        </div>
        <!-- List type card end -->
    </div>
    @elseif($ticket->logs->last()->status->id == 4)
      <div class="col-sm-12">
          <!-- List type card start -->
          <div class="card bg-c-green update-card">
              <div class="card-header">
                  <h4>Chamado Finalizado!</h4>
              </div>
          </div>
          <!-- List type card end -->
      </div>
    @elseif($ticket->logs->last()->status->id == 5)
      <div class="col-sm-12">
          <!-- List type card start -->
          <div class="card bg-c-pink update-card">
              <div class="card-header">
                  <h4>Chamado Cancelado!</h4>
              </div>

          </div>
          <!-- List type card end -->
      </div>
    @endif

    <div class="col-lg-9">

      <div class="card">
          <div class="card-header">
              <h5>Solicitação</h5>
              <div class="card-header-right">
                @if($ticket->logs->last()->status->id != 4 && $ticket->logs->last()->status->id != 5)
                  <div class="dropdown-inverse dropdown open">
                      <button class="btn btn-inverse btn-sm dropdown-toggle waves-effect waves-light " type="button" id="dropdown-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Opções</button>
                      <div class="dropdown-menu" aria-labelledby="dropdown-3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                        @if(auth()->user()->isAdmin() && $ticket->logs->last()->status->id == 1)
                          <a class="dropdown-item waves-light waves-effect" onclick="startTicket()" href="#">Executar Chamado</a>
                        @elseif(auth()->user()->isAdmin() && $ticket->logs->last()->status->id == 2)
                          <a class="dropdown-item waves-light waves-effect" onclick="concludeTicket()" href="#">Concluir Chamado</a>
                        @elseif($ticket->logs->last()->status->id == 3 && $ticket->user_id == auth()->user()->id)
                          <a class="dropdown-item waves-light waves-effect" onclick="finishTicket()" href="#">Finalizar Chamado</a>
                        @endif
                        @if($ticket->logs->last()->status->id == 1 || $ticket->logs->last()->status->id == 2 || $ticket->logs->last()->status->id == 3)
                          <a class="dropdown-item waves-light waves-effect" onclick="cancelTicket()" href="#">Cancelar Chamado</a>
                        @endif
                      </div>
                  </div>
                @endif
              </div>
          </div>

          <form style="display:none" id="ticket-start" class="dropdown-item waves-light waves-effect" action="{{ route('ticket_start', $ticket->uuid) }}" method="POST">
              @csrf
              <button class="btn btn-success btn-sm btn-round"><i class="fa fa-tag"></i>  Executar Chamado</button>
          </form>
          <form style="display:none" id="ticket-finish" class="dropdown-item waves-light waves-effect" style="display:inline" action="{{ route('ticket_finish', $ticket->uuid) }}" method="POST">
              @csrf
              <button class="btn btn-success btn-sm btn-round"><i class="fa fa-tag"></i>  Finalizar Chamado</button>
          </form>
          <form style="display:none" id="ticket-conclude" class="dropdown-item waves-light waves-effect" style="display:inline" action="{{ route('ticket_conclude', $ticket->uuid) }}" method="POST">
              @csrf
              <button class="btn btn-success btn-sm btn-round"><i class="fa fa-tag"></i>  Concluir Chamado</button>
          </form>
          <form style="display:none" id="ticket-cancel" class="dropdown-item waves-light waves-effect" style="display:inline" action="{{ route('ticket_cancel', $ticket->uuid) }}" method="POST">
              @csrf
              <button class="btn btn-success btn-sm btn-round"><i class="fa fa-tag"></i>  Cancelar Chamado</button>
          </form>

          <div class="card-block">
              <div class="row">

                  <div class="col-sm-12 col-xl-12">
                    <h4 class="sub-title">Titulo</h4>
                    <p class="text-muted m-b-30">
                        <b>{{$ticket->type->category->name}}: </b>{{$ticket->type->name}}
                    </p>
                  </div>

                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Código</h4>
                    <p class="text-muted m-b-30">
                        #{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT)  }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Cadastro</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->created_at->format('d/m/Y H:i:s') }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Solicitante</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->name }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Setor</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->department->name }} >>
                        <br/>
                        {{ $ticket->user->person->occupation->name }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Telefone</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->phone }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Ramal</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->branch }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Email</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->email }}
                    </p>
                  </div>

                  @php

                    $status = $ticket->logs->last()->status->id;

                    $bgColor = 'success';

                    switch($status) {
                      case '2':
                        $bgColor = 'warning';
                        break;
                      case '3':
                        $bgColor = 'primary';
                        break;
                      case '4':
                        $bgColor = 'primary';
                        break;
                      case '5':
                        $bgColor = 'danger';
                        break;
                    }

                  @endphp

                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Status</h4>
                    <p class="text-muted m-b-30">
                      <label class="label label-lg label-{{ $bgColor }}">{{ $ticket->logs->last()->status->name }}</label>
                    </p>
                  </div>

                  <div class="col-sm-12 col-xl-4">
                    <h4 class="sub-title">Responsável</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->responsible->person->name ?? '-' }}
                    </p>
                  </div>

                  <div class="col-sm-12 col-xl-12">
                      <h4 class="sub-title">Descrição</h4>
                      <p class="text-muted m-b-30">
                          {!! $ticket->description  !!}
                      </p>
                  </div>
              </div>
          </div>

      </div>

    </div>


    <div class="col-md-3 col-sm-12">

      <div class="card user-activity-card">
          <div class="card-header">
            <h5>Logs</h5>
          </div>
          <div class="card-block">

            @if($ticket->logs->isNotEmpty())

              @foreach($ticket->logs->sortByDesc('id') as $activity)

                <div class="row m-b-25">
                    <div class="col">
                        <h6 class="m-b-5">{{ $activity->created_at->format('d/m/Y H:i') }}</h6>
                        <p class="text-muted m-b-0">{{ $activity->description }} {{ html_entity_decode(\App\Helpers\Helper::getTagHmtlForModel($activity->subject_type, $activity->subject_id)) }}</p>
                        <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>{{ \App\Helpers\TimesAgo::render($activity->created_at) }}</p>
                    </div>
                </div>

              @endforeach

            @else

              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="fas fa-history fa-2x"></i></h1>
                      <br/>
                      <h6 class="font-bold no-margins">
                          Nenhum log registrado até o momento.
                      </h6>
                  </div>
              </div>

            @endif

          </div>
      </div>

    </div>

  </div>

</div>

@endsection

@section('scripts')

<script>
    function startTicket() {

        swal({
          title: 'Iniciar Chamado?',
          text: "O tempo de execução será contabilizado.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            $("#ticket-start").submit();

          }
        });

    }

    function concludeTicket() {

        swal({
          title: 'Concluir Chamado?',
          text: "Este chamado será concluído!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            $("#ticket-conclude").submit();

          }
        });

    }

    function finishTicket() {

        swal({
          title: 'Finalizar Chamado?',
          text: "Este chamado será finalizado!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            $("#ticket-conclude").submit();

          }
        });

    }


    function cancelTicket() {

        swal({
          title: 'Cancelar Chamado?',
          text: "Este chamado será cancelado!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            $("#ticket-cancel").submit();

          }
        });

    }
</script>

@endsection
