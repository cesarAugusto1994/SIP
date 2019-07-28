@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Agenda</h4>
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
                        <a href="{{ route('schedules.index') }}"> Agenda </a>
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

  <div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h5><i class="icofont icofont-tasks-alt m-r-5"></i>{{ $schedule->title }}</h5>
            <span class="label label-lg label-success f-right"> {{ $schedule->type->name }}  </span></a>
        </div>

        <div class="card-block">
            <div class="">
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Informações</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="m-b-10 f-w-600">Inicio</p>
                            <h6 class="text-muted f-w-400">{{ $schedule->start->format('d/m/Y H:i') }}</h6>
                        </div>
                        <div class="col-sm-6">
                            <p class="m-b-10 f-w-600">Fim</p>
                            <h6 class="text-muted f-w-400">{{ $schedule->end->format('d/m/Y H:i') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Descrição</h6>
                    {{ $schedule->description }}
                </div>
                <div class="m-b-20">
                    <h6 class="sub-title m-b-15">Localização</h6>
                    {{ $schedule->localization }}
                </div>
            </div>
        </div>
        <div class="card-footer">

          <div class="f-left">

              <a data-route="{{ route('schedules.destroy', $schedule->uuid) }}" class="btn btn-danger text-white btn-sm waves-effect waves-light btnRemoveItemToBack" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remover"><i class="icofont icofont-close"></i>Remover</a>

          </div>

          <div class="f-right d-flex">
              <a href="{{ route('schedules.edit', ['id' => $schedule->uuid]) }}" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="icofont icofont-edit"></i>Editar</a>
          </div>

        </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-header-text"><i class="icofont icofont-users-alt-4"></i> Participantes</h5>
        </div>
        <div class="card-block user-box assign-user">

          @foreach($schedule->guests as $guest)
            <div class="media">
                <div class="media-left media-middle photo-table">
                    <a href="#">
                        <img class="img-radius" src="{{ route('image', ['user' => $guest->user->uuid, 'link' => $guest->user->avatar, 'avatar' => true])}}" alt="chat-user">
                    </a>
                </div>
                <div class="media-body">
                    <h6>{{ $guest->user->person->name }}</h6>
                    <p>{{ $guest->user->person->department->name }}</p>
                </div>
                <div>
                    <a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
                </div>
            </div>
          @endforeach

        </div>
    </div>
  </div>

  </div>

</div>

@endsection
