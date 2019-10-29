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

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.tarefas')
                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('tasks.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Tarefa</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">
                <form method="get" action="?">
                    <input type="hidden" name="find" value="1"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="code" placeholder="Código da Tarefa, Titulo, Descrição">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" id="daterange" class="form-control" placeholder="Periodo">
                            <input type="hidden" name="start" id="start" value="{{ now()->format('d/m/Y') }}"/>
                            <input type="hidden" name="end" id="end" value="{{ now()->format('d/m/Y') }}"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-controls select2" name="status">
                              <option value="">Situação</option>
                              @foreach(\App\Helpers\Helper::taskStatus() as $status)
                                  <option value="{{$status->id}}">{{$status->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-controls select2" name="status">
                              <option value="">Situação</option>
                              @foreach(\App\Helpers\Helper::users() as $user)
                                  <option value="{{$user->id}}">{{$user->person->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5>Tarefas Recentes</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>No.</th>
                                <th>Titulo</th>
                                <th>Usuário</th>
                                <th>Situação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($tasks as $task)

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

                            <tr>
                                <td><a href="{{ route('tasks.show', $task->uuid) }}" class="card-title">#{{ str_pad($task->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                <td><a href="{{ route('tasks.show', $task->uuid) }}" class="card-title">{{ $task->name }}<br/>
                                  <small>Descrição: {{ html_entity_decode(strip_tags(substr($task->description, 0, 80))) }}</small></a>
                                </td>
                                <td>
                                  <a href="#!"><img width="24" class="img-fluid img-radius" src="{{ route('image', ['user' => $task->sponsor->uuid ?? '', 'link' => $task->sponsor->avatar ?? '', 'avatar' => true])}}" title="{{ $task->user->person->name }}" alt=""> {{ $task->user->person->name }}</a>
                                </td>
                                <td>
                                  <span class="label label-{{$bgColor}}"> {{$task->status->name}} </span>
                                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->severity); !!}">G {{$task->severity}}</span>
                                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->urgency); !!}">U {{$task->urgency}}</span>
                                  <span class="label label-{!! \App\Helpers\Helper::getColorFromValue($task->trend); !!}">T {{$task->trend}}</span>
                                </td>

                                <td>
                                  @if($task->start)
                                  {{ $task->start->format('d/m/Y') }}
                                  <br/>
                                  <label class="label label-inverse-primary">{{ $task->start->diffForHumans() }}</label>
                                  @endif
                                </td>

                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{ $tasks->links() }}

  </div>

</div>

@endsection
