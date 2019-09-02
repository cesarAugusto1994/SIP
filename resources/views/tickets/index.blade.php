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
                    <li class="breadcrumb-item"><a href="#!">Chamados</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow f-w-600">{{ $total }}</h4>
                        <h6 class="text-muted m-b-0">Total</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green f-w-600">{{ $opened }}</h4>
                        <h6 class="text-muted m-b-0">Abertos</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue f-w-600">{{ $finished }}</h4>
                        <h6 class="text-muted m-b-0">Finalizados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-calendar f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-pink f-w-600">{{ $canceled }}</h4>
                        <h6 class="text-muted m-b-0">Cancelados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-download f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

  </div>

  <div class="row">
      <div class="col-xl-3 col-lg-12 push-xl-9">
          <div class="card">
              <div class="card-block p-t-10">
                  <div class="task-right">
                      <div class="task-right-header-status">
                          <span data-toggle="collapse">Prioridades</span>
                          <i class="icofont icofont-rounded-down f-right"></i>
                      </div>

                      <div class="taskboard-right-progress">
                          <h6>Altissima</h6>
                          <div class="progress progress-striped progress-mini">
                            <div style="width:{{ $highest }}%;background-color: #fe5d70;"
                              class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('highest') }}">
                              {{ $highest }}</div>
                          </div>

                          <hr/>

                          <h6>Alta</h6>
                          <div class="progress progress-striped progress-mini">
                            <div style="width:{{ $high }}%;background-color: #fe9365;"
                              class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('high') }}">
                              {{ $high }}</div>
                          </div>

                          <hr/>

                          <h6>Normal</h6>
                          <div class="progress progress-striped progress-mini">
                            <div style="width:{{ $normal }}%;background-color: #0ac282;"
                              class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('normal') }}">
                              {{ $normal }}</div>
                          </div>

                          <hr/>

                          <h6>Baixa</h6>
                          <div class="progress progress-striped progress-mini">
                            <div style="width:{{ $low }}%;background-color: #01a9ac;"
                              class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('low') }}">
                              {{ $low }}</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-9 col-lg-12 pull-xl-3 filter-bar">
          <nav class="navbar navbar-light bg-faded m-b-30 p-10">
              <ul class="nav navbar-nav">
                  <li class="nav-item active">
                      <a class="nav-link" href="#!">Filtros: <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#!" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> Data</a>
                      <div class="dropdown-menu" aria-labelledby="bydate">
                          <a class="dropdown-item" href="?date=recente">Recente</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="?date=hoje">Hoje</a>
                          <a class="dropdown-item" href="?date=ontem">Ontem</a>
                          <a class="dropdown-item" href="?date=semana">Nesta Semana</a>
                          <a class="dropdown-item" href="?date=mes">Neste Mês</a>
                          <a class="dropdown-item" href="?date=ano">Neste Ano</a>
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-chart-histogram-alt"></i>Situação</a>
                      <div class="dropdown-menu" aria-labelledby="bystatus">
                          <a class="dropdown-item" href="?status=">Todos</a>
                          <div class="dropdown-divider"></div>
                          @foreach(\App\Helpers\Helper::ticketStatus() as $status)
                              <a class="dropdown-item" href="?status={{$status->id}}">{{$status->name}}</a>
                          @endforeach
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#!" id="bypriority" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-sub-listing"></i> Prioridade</a>
                      <div class="dropdown-menu" aria-labelledby="bypriority">
                          <a class="dropdown-item" href="?priority=">Todas</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="?priority=Altissima">Altissima</a>
                          <a class="dropdown-item" href="?priority=Alta">Alta</a>
                          <a class="dropdown-item" href="?priority=Normal">Normal</a>
                          <a class="dropdown-item" href="?priority=Baixa">Baixa</a>
                      </div>
                  </li>
                  @if(auth()->user()->isAdmin())
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-users-alt-5"></i>Usuário</a>
                          <div class="dropdown-menu" aria-labelledby="bystatus">
                              <a class="dropdown-item" href="?user=">Todos</a>
                              <div class="dropdown-divider"></div>
                              @foreach(\App\Helpers\Helper::users() as $user)
                                  <a class="dropdown-item" href="?user={{$user->id}}">{{$user->person->name}}</a>
                              @endforeach
                          </div>
                      </li>
                  @endif
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-automation"></i>Tipo</a>
                      <div class="dropdown-menu" aria-labelledby="bystatus">
                          <a class="dropdown-item" href="?type=">Todos</a>
                          <div class="dropdown-divider"></div>
                          @foreach(\App\Helpers\Helper::ticketCategories() as $category)
                            @foreach($category->types as $type)
                              @if(!$type->active) @continue; @endif
                              <a class="dropdown-item" href="?type={{$type->id}}">{{$type->name}}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                          @endforeach
                      </div>
                  </li>
              </ul>
              <div class="nav-item nav-grid">
                  @permission('create.chamados')
                    <a class="btn btn-sm btn-success btn-round" href="{{route('tickets.create')}}">Novo Chamado</a>
                  @endpermission
              </div>

          </nav>
          <!-- Nav Filter tab end -->
          <!-- Task board design block start-->
          <div class="row">

            @forelse($tickets->sortByDesc('id') as $ticket)

                <div class="col-sm-6">
                    <div class="card card-border-{{ \App\Helpers\Helper::statusTaskCollor($ticket->status->id) }}">
                        <div class="card-header">
                            <a href="{{ route('tickets.show', $ticket->uuid) }}" class="card-title">#{{ $ticket->id }} </a>
                            <a href="{{ route('tickets.show', $ticket->uuid) }}"><b>{{$ticket->type->category->name}}</b></a>
                            <a href="{{ route('tickets.show', $ticket->uuid) }}">
                              <span class="label label-{{ \App\Helpers\Helper::statusTaskCollor($ticket->status->id) }} f-right"> {{ $ticket->status->name }} </span></a>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                  <a href="{{ route('tickets.show', $ticket->uuid) }}">
                                    <p class="task-detail"><b>{{$ticket->type->name}}</b>: {{substr($ticket->description,0,150)}}...</p>
                                    <br/>
                                    <p class="task-due"><strong> Aberto em : </strong>
                                    <label class="label label-inverse-success">{{$ticket->created_at->format('d/m/Y H:i')}}</label></a>
                                    <label class="label label-inverse-primary">{{ $ticket->created_at->diffForHumans() }}</label></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="task-list-table">
                                <a href="#!"><img class="img-fluid img-radius" src="{{ route('image', ['user' => $ticket->user->uuid, 'link' => $ticket->user->avatar, 'avatar' => true])}}" title="{{ $ticket->user->person->name }}" alt="{{ $ticket->user->person->name }}"></a>
                            </div>
                            <div class="task-board">
                                <label class="label label-{{ \App\Helpers\Helper::statusTaskPriorityCollor($ticket->priority) }}">{{ $ticket->priority }}</label>
                                @if($ticket->status_id != 4)
                                    <div class="dropdown-secondary dropdown">
                                        <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                            <a class="dropdown-item waves-light waves-effect" href="{{route('tickets.edit', $ticket->uuid)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                            <div class="dropdown-divider"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @empty

                <div class="col-md-12 col-lg-12">

                  <div class="widget white-bg no-padding">
                      <div class="p-m text-center">
                          <h1 class="m-md"><i class="fas fa-bullhorn fa-2x"></i></h1>
                          <br/>
                          <h6 class="font-bold no-margins">
                              Nenhum chamado encontrado.
                          </h6>
                      </div>
                  </div>

                </div>

            @endforelse

            {{ $tickets->links() }}

          </div>
          <!-- Task board design block end -->
      </div>
      <!-- Left column end -->
  </div>
</div>
</div>

@endsection
