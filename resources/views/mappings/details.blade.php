@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mapeamentos {{ $mapper->name }}</h4>
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
                        <a href="{{ route('mappings') }}"> Mapeamentos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalhes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="row">

    <div class="col-lg-3 col-md-4">
      <div class="card">
          <div class="card-header">
              <h5>Mapeamento Detalhes</h5>
          </div>
          <div class="card-block">

            <h4><strong>{{$mapper->user->name}}</strong> @if($mapper->user->department)<small>{{$mapper->user->department->name}}</small>@endif</h4>

            <table class="table matrics-table">
                <tbody>
                    <tr>
                        <td>
                            <strong>Tempo Pevisto</strong>
                        </td>
                        <td class="txt-primary">{{ App\Helpers\Helper::taskTimeToHour($mapper->tasks) }}</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Tempo Trabalhado</strong>
                        </td>
                        <td class="txt-danger">{{App\Helpers\Mapper::getDoneTimeByUser($mapper->user->id) }}</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Tempo Total</strong>
                        </td>
                        <td class="txt-primary">{{ App\Http\Controllers\HomeController::minutesToHour($mapper->tasks->sum('time')) }}</td>
                    </tr>
                </tbody>
            </table>

          </div>
      </div>
    </div>

    <div class="col-lg-9 col-md-8">
      <div class="card">
          <div class="card-header">
              <h5>Tarefas</h5>
          </div>
          <div class="card-block">

            <div class="project-list table-responsive">
              @if($mapper->tasks->isNotEmpty())

              <table class="table table-hover">
                  <tbody>
                  @forelse ($mapper->tasks as $task)

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

                    <tr {!! App\Http\Controllers\TaskController::taskDelayed($task) !!} >
                        <td class="project-title">
                            <a href="{{route('tasks.show', ['id' => $task->id])}}">{{$task->name}}</a>
                            <br/>

                            <label class="label label-inverse-success">{{ $task->created_at->format('d/m/Y H:i') }}</label>
                            <label class="label label-inverse-primary">{{ $task->created_at->diffForHumans() }}</label>

                        </td>
                        <td class="project-completion hidden-xs">
                            <small>GUT:  <b>
                              <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->severity); !!}">{{$task->severity}}</span>
                              <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->urgency); !!}">{{$task->urgency}}</span>
                              <span class="label label-{!! App\Http\Controllers\TaskController::getColorFromValue($task->trend); !!}">{{$task->trend}}</span>
                            </b></small>
                        </td>
                        <td class="project-completion hidden-xs">
                            <label class="label label-{{$bgColor}}"> {{$task->status->name}} </label>
                        </td>

                        <td class="project-title text-center">
                            Tempo <a>{{ App\Http\Controllers\HomeController::minutesToHour($task->time) }}</a>
                        </td>
                        <td class="project-actions">
                          @if ($task->status_id == 1)
                            <a href="{{ route('task_initiate', ['id' => $task->id]) }}" class="btn btn-primary btn-sm btn-round" onclick="openSwalScreen();"> Iniciar </a>
                          @elseif ($task->status_id == 2)
                            <a href="{{route('task_finish', ['id' => $task->id])}}" class="btn btn-success btn-sm btn-round" onclick="openSwalScreen();"> Finalizar </a>
                          @endif
                        </td>
                    </tr>
                      @empty
                      <tr>
                          <td>Nenhuma tarefa até o momento.</td>
                      </tr>

                  @endforelse
                  </tbody>
              </table>
              @else
              <div class="alert alert-warning">
                  Nenhuma tarefa registrada até o momento.
              </div>
              @endif
            </div>

          </div>
      </div>
    </div>

  </div>
</div>

    <div class="modal inmodal" id="editar" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                </div>
                <form action="{{route('user_update', ['id' => $mapper->user->id])}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
