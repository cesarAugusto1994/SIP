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

          @php

            $countMessages = $user->messages()->where('receiver_id', auth()->user()->id)->where('read_at', null)->count();

          @endphp

          @if(Auth::user()->id != $user->id)

          <div class="col-lg-6 col-xl-3 col-md-6">
              <div class="card rounded-card user-card">

                  <div class="card-block">
                      <div class="img-hover" style="width:64px">
                          <img class="img-fluid img-radius" src="{{ route('image', ['user' => $user->uuid, 'link' => $user->person->user->avatar, 'avatar' => true])}}" alt="">
                      </div>
                      <div class="user-content">
                          <h4 class="">{{ $user->person->name }}</h4>
                          <p class="m-b-0 text-muted">{{$user->person->department->name}}</p>
                          <a href="{{ route('chat_user', $user->uuid) }}" class="btn btn-outline-success btn-sm btn-round">Mensagem</a>

                      </div>

                  </div>
                  @if($countMessages)
                    <div class="card-footer bg-c-green">
                        <h6 class="text-white m-b-0">{{ $countMessages }} mensagens pendentes.</h6>
                    </div>
                  @endif
              </div>
          </div>

          @endif

        @endforeach

    </div>
</div>

@endsection
