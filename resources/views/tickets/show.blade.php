@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Chamados: #{{ $ticket->id }} </h4>
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

    <div class="col-lg-12">

      <div class="card">
          <div class="card-header">
              <h5><b>{{$ticket->type->category->name}}: </b>{{$ticket->type->name}}</h5>
              <div class="card-header-right">
                <div class="dropdown-inverse dropdown open">
                    <button class="btn btn-inverse btn-sm dropdown-toggle waves-effect waves-light " type="button" id="dropdown-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Opções</button>
                    <div class="dropdown-menu" aria-labelledby="dropdown-3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                      @if($ticket->logs->last()->status->id == 1)
                        <a class="dropdown-item waves-light waves-effect" onclick="startTicket()" href="#">Executar Chamado</a>
                      @elseif($ticket->logs->last()->status->id == 2)
                        <a class="dropdown-item waves-light waves-effect" onclick="concludeTicket()" href="#">Concluir Chamado</a>
                      @elseif($ticket->logs->last()->status->id == 3 && $ticket->user_id == auth()->user()->id)
                        <a class="dropdown-item waves-light waves-effect" onclick="finishTicket()" href="#">Finalizar Chamado</a>
                      @endif
                      @if($ticket->logs->last()->status->id == 1 || $ticket->logs->last()->status->id == 2 || $ticket->logs->last()->status->id == 3)
                        <a class="dropdown-item waves-light waves-effect" onclick="cancelTicket()" href="#">Cancelar Chamado</a>
                      @endif
                    </div>
                </div>
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

                  @if($ticket->logs->last()->status->id == 3)
                    <div class="col-sm-12 col-xl-12">
                      <div class="alert alert-success background-success">
                          <strong>Chamado finalizado!</strong>
                      </div>
                    </div>
                  @elseif($ticket->logs->last()->status->id == 5)
                    <div class="col-sm-12 col-xl-12">
                      <div class="alert alert-danger background-danger">
                          <strong>Chamado cancelado!</strong>
                      </div>
                    </div>
                  @endif

                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Código</h4>
                    <p class="text-muted m-b-30">
                        #{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT)  }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Cadastro</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->created_at->format('d/m/Y H:i:s') }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Solicitante</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->name }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Setor</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->department->name }} >>
                        <br/>
                        {{ $ticket->user->person->occupation->name }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Telefone</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->person->phone }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Email</h4>
                    <p class="text-muted m-b-30">
                        {{ $ticket->user->email }}
                    </p>
                  </div>
                  <div class="col-sm-12 col-xl-3">
                    <h4 class="sub-title">Status</h4>

                    <label class="label label-inverse-primary">{{ $ticket->logs->last()->status->name }}</label>

                  </div>

                  <div class="col-sm-12 col-xl-3">
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
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
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
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            $("#ticket-finish").submit();

          }
        });

    }

    function finishTicket() {

        swal({
          title: 'Finalizar Chamado?',
          text: "Este chamado será finalizado!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
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
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
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
