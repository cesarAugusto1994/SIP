@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tarefas</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tarefas</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">
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
                <a href="{{route('tasks.create')}}" class="btn bottom-right btn-primary btn-sm pull-right">Criar Tarefa</a>
              @endpermission
          </div>

      </nav>
    </div>

  </div>

  <div class="row">
    @foreach ($tasks as $task)

    @php

      $status = $task->status->id;

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

    <div class="col-sm-4">
        <div class="card card-border-{{ $bgColor }}">
            <div class="card-header">
                <a href="{{ route('tasks.show', $task->uuid) }}" class="card-title">#{{$task->id}} </a>
                <a href="{{ route('tasks.show', $task->uuid) }}"><b>{{$task->name}}</b></a>
                <a href="{{ route('tasks.show', $task->uuid) }}">
                  <span class="label label-{{$bgColor}} f-right"> {{$task->status->name}} </span></a>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-sm-12">
                      <a href="{{ route('tickets.show', $task->uuid) }}">
                        <p class="task-detail">{{substr($task->description,0,150)}}...</p>
                        <br/>

                        <small>Tempo Previsto:  <b>
                          {{ App\Http\Controllers\HomeController::minutesToHour($task->time) }}
                        </b></small>


                        <p class="task-due"><strong> Aberto em : </strong>
                        <label class="label label-inverse-success">{{ $task->created_at->format('d/m/Y H:i') }}</label></a>
                        <label class="label label-inverse-primary">{{ $task->created_at->diffForHumans() }}</label></p>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="task-list-table">

                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->severity); !!}">G {{$task->severity}}</span>
                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->urgency); !!}">U {{$task->urgency}}</span>
                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->trend); !!}">T {{$task->trend}}</span>

                </div>
                <div class="task-board">

                  @if ($task->status_id == 1)
                    <a href="{{ route('task_initiate', ['id' => $task->id]) }}" class="btn btn-primary btn-sm"> Iniciar </a>
                  @elseif ($task->status_id == 2)
                    <a href="{{route('task_finish', ['id' => $task->id])}}" class="btn btn-success btn-sm"> Finalizar </a>
                  @endif

                </div>
            </div>
        </div>
    </div>

    @endforeach
  </div>
</div>

@endsection
