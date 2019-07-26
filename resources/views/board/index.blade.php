@extends('base')

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
