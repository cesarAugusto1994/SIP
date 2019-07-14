@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Conversas</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Chat</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="row">

        @foreach($users as $user)

          @if(Auth::user()->id != $user->person->user->id)

          <div class="col-lg-6 col-xl-3 col-md-6">
              <div class="card rounded-card user-card">
                  <div class="card-block">
                      <div class="img-hover" style="width:64px">
                          <img class="img-fluid img-radius" src="{{ route('image', ['user' => $user->person->user->uuid, 'link' => $user->person->user->avatar, 'avatar' => true])}}" alt="round-img">
                      </div>
                      <div class="user-content">
                          <h4 class="">{{ $user->person->name }}</h4>
                          <p class="m-b-0 text-muted">{{$user->person->department->name}}</p>
                          <a href="{{ route('chat_user', $user->person->user->uuid) }}" class="btn btn-outline-success btn-sm btn-round">Mensagem</a>
                      </div>

                  </div>
              </div>
          </div>

          @endif

        @endforeach

    </div>
</div>

@endsection
