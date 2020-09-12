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

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
      <div class="card">
          <div class="card-header">
              <h5>Pendente</h5>
          </div>
          <div class="card-block">
            <ul class="scroll-list wave basic-list list-icons-img" style="height:600px">
              @foreach($tasks->where('status_id', 1) as $task)

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

                <li>
                    <img style="left: -50px;" src="{{ route('image', ['user' => $task->sponsor->uuid ?? '', 'link' => $task->sponsor->avatar ?? '', 'avatar' => true])}}" class="img-fluid p-absolute d-block text-center" alt="">
                    <h6 style="margin-bottom: .5rem;"><b><a href="{{ route('tasks.show', $task->uuid) }}">{{ $task->name }}</a></b></h6>
                    <p>{{substr($task->description,0,150)}}...</p>
                    <hr/>
                    <span class="label label-{{$bgColor}}"> {{$task->status->name}} </span>
                </li>
              @endforeach

            </ul>
          </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
      <div class="card">
          <div class="card-header">
              <h5>Em Andamento</h5>
          </div>
          <div class="card-block">
            <ul class="scroll-list wave basic-list list-icons-img" style="height:600px">
              @foreach($tasks->where('status_id', 2) as $task)

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

                <li>
                    <img style="left: -50px;" src="{{ route('image', ['user' => $task->sponsor->uuid ?? '', 'link' => $task->sponsor->avatar ?? '', 'avatar' => true])}}" class="img-fluid p-absolute d-block text-center" alt="">
                    <h6 style="margin-bottom: .5rem;"><b><a href="{{ route('tasks.show', $task->uuid) }}">{{ $task->name }}</a></b></h6>
                    <p>{{substr($task->description,0,150)}}...</p>
                    <hr/>
                    <span class="label label-{{$bgColor}}"> {{$task->status->name}} </span>
                </li>
              @endforeach

            </ul>
          </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
      <div class="card">
          <div class="card-header">
              <h5>Em Pausa</h5>
          </div>
          <div class="card-block">
            <ul class="scroll-list wave basic-list list-icons-img" style="height:600px">
              @foreach($tasks->where('status_id', 5) as $task)

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

                <li>
                    <img style="left: -50px;" src="{{ route('image', ['user' => $task->sponsor->uuid ?? '', 'link' => $task->sponsor->avatar ?? '', 'avatar' => true])}}" class="img-fluid p-absolute d-block text-center" alt="">
                    <h6 style="margin-bottom: .5rem;"><b><a href="{{ route('tasks.show', $task->uuid) }}">{{ $task->name }}</a></b></h6>
                    <p>{{substr($task->description,0,150)}}...</p>
                    <hr/>
                    <span class="label label-{{$bgColor}}"> {{$task->status->name}} </span>
                </li>
              @endforeach

            </ul>
          </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
      <div class="card">
          <div class="card-header">
              <h5>Finalizados</h5>
          </div>
          <div class="card-block">
            <ul class="scroll-list wave basic-list list-icons-img" style="height:600px">
              @foreach($tasks->where('status_id', 3) as $task)

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

                <li>
                    <img style="left: -50px;" src="{{ route('image', ['user' => $task->sponsor->uuid ?? '', 'link' => $task->sponsor->avatar ?? '', 'avatar' => true])}}" class="img-fluid p-absolute d-block text-center" alt="">
                    <h6 style="margin-bottom: .5rem;"><b><a href="{{ route('tasks.show', $task->uuid) }}">{{ $task->name }}</a></b></h6>
                    <p>{{substr($task->description,0,150)}}...</p>
                    <hr/>
                    <span class="label label-{{$bgColor}}"> {{$task->status->name}} </span>
                </li>
              @endforeach

            </ul>
          </div>
      </div>
    </div>

  </div>

</div>

@endsection
