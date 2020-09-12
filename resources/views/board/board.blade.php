@extends('base')

@section('css')

  <style>

      html, body, #app {
    max-height: 100vh;
    height: 100vh;
    }
    #header {
    background: rgba(0,0,0,.15);
    overflow: hidden;
    padding: 5px 8px;
    position: relative;
    height: 40px;
    text-align: center;
    margin: 0 0 20px;
    .header-logo {
        background-position: top right;
        background-repeat: no-repeat;
        background-size: 5pc 30px;
        right: 0;
        top: 0;
        height: 30px;
        width: 5pc;
        position: absolute;
        text-align: center;
        bottom: 0;
        display: block;
        left: 50%;
        margin-left: -40px;
        top: 5px;
        text-align: center;
        -webkit-transition: .1s ease;
        transition: .1s ease;
        z-index: 2;
    }
    }
    #boards {
    .board {
        width: 304px;
        padding-left: 5px;
        padding-right: 5px;
        float: left;
        .kanban-wrapper {
            background-color: #E2E4E6;
            border-radius: 5px;
            overflow: hidden;
            .board-title {
                padding: 10px;
                h2 {
                    margin: 0;
                    font-size: 14px;
                    font-weight: 600;
                    color: #272727;
                }
            }
            .cards {
                list-style: none;
                margin: 0;
                padding: 0 10px;
                > div {
                    min-height: 5px;
                    padding: 5px 0;
                }
                .card {
                    overflow: hidden;
                    padding: 8px;
                    background-color: #fff;
                    border-bottom: 1px solid #ccc;
                    border-radius: 3px;
                    cursor: pointer;
                    margin-bottom: 6px;
                    max-width: 300px;
                    min-height: 20px;
                    &:hover {
                        background-color: #edeff0;
                    }
                }
            }
            .add-card {
                color: #838c91;
                display: block;
                flex: 0 0 auto;
                padding: 8px 10px;
                position: relative;
                &[disabled], &[disabled]:hover {
                    cursor: not-allowed;
                    text-decoration: none;
                }
            }
        }
    }
    }

  </style>

@stop

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Board</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Board</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">


  <div class="row">
      @foreach($users->sortBy('person.name') as $user)

      @if($user->do_task && $user->active && $user->tasks->isNotEmpty())

      <div class="col-md-6 col-xl-3">
          <div class="card user-card">
              <div class="card-header-img">
                @if(config('app.env') == 'production')
                  <img class="img-fluid img-radius" width="128" src="{{ route('image', ['user' => $user->uuid, 'link' => $user->avatar, 'avatar' => true])}}" alt="">
                @endif
                  <h4>{{ $user->person->name }}</h4>
              </div>

              <br/>

              <div class="card-block">

                  <h2>{!! App\Http\Controllers\UsersController::getTaskPercentage($user->id) !!}%</h2>
                  <div class="progress progress-mini">
                      <div style="width: {!! App\Http\Controllers\UsersController::getTaskPercentage($user->id) !!}%;" class="progress-bar {!! App\Http\Controllers\UsersController::getTaskPercentageProgress($user->id) !!}"></div>
                  </div>

                  <br/>

                  @forelse($user->tasks->sortBy('status_id') as $task)

                    @if($task->status_id == 4)
                      @continue
                    @endif

                      <span><a href="{{ route('tasks.show', ['id' => $task->uuid]) }}" class="text-navy">{{ substr($task->name, 0, 26) }}</a>:<br/>
                          <small>{{ $task->owner->name ?? '' }}</small>
                      </span>
                      <div class="progress progress-striped active progress-mini">
                        <div style="width:{{ \App\Helpers\Helper::percent($task->status_id) }}"
                          class="progress-bar {{ \App\Helpers\Helper::progressBarCollor($task->status_id) }}">
                          {{ \App\Helpers\Helper::percent($task->status_id) }}</div>
                      </div>

                  @empty

                  @endforelse

                  <hr/>

                  @if($user->logs->isNotEmpty())
                  <div class="feed-activity-list text-center">

                    <hr/>

                    <h3>Histórico</h3>

                      <div>

                          @forelse(App\Http\Controllers\UsersController::getTodayLogs($user->id) as $log)
                          <div class="feed-element">
                              <a href="{{ route('user', ['id' => $log->user->uuid]) }}" class="pull-left">
                                  <img width="32" alt="" class="img" src="{{ route('image', ['user' => $log->user->uuid, 'link' => $log->user->avatar, 'avatar' => true])}}">
                              </a>
                              <div class="media-body ">
                                  <small class="pull-right"></small>
                                  <strong>{{$log->user->name == Auth::user()->name ? 'Você' : $log->user->name}}</strong> {{ $log->message }} <br>
                                  <small class="text-muted">{{ $log->created_at->format('H:i - d.m.Y') }}</small>

                              </div>
                          </div>
                          @empty
                          <div class="text-center">
                              <p>Nenhum registro encontrado.</p>
                          </div>
                          @endforelse

                      </div>

                  </div>
                  @endif
                  <br/>


              </div>

              <a href="{{ route('tasks.index', ['user' => $user->id]) }}" class="btn btn-success btn-sm btn-round">Tarefas</a>

          </div>
      </div>


      @endif

      @endforeach
    </div>

</div>

@endsection
