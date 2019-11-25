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
                        <a href="{{ route('departments.index') }}"> Agenda </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Agenda</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('schedules.update', ['id' => $schedule->uuid])}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <input type="hidden" name="updateByForm" value="1"/>

            <div class="row">

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Titulo</label>
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input autofocus required class="form-control" name="title" id="title" value="{{ $schedule->title }}">
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group ">
                      <label>Inicio</label>
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                          <input type="text" value="{{ $schedule->start->format('d/m/Y H:i') }}" id="start" name="start" required class="form-control inputDateTime">
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="form-group ">
                      <label>Fim</label>
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" value="{{ $schedule->end->format('d/m/Y H:i') }}" id="end" name="end" required class="form-control inputDateTime">
                      </div>
                  </div>
              </div>

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Dia Inteiro</label>
                      <div class="input-group">
                        <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="all_day" class="js-switch">
                      </div>
                  </div>
              </div>

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Adicionar convidados</label>
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-users"></i></span>
                          <select class="form-control select2" multiple title="Selecione um paciente" data-style="btn-white" data-live-search="true" show-tick show-menu-arrow data-width="100%" name="guests[]" id="guests">
                            @foreach(App\Helpers\Helper::users() as $user)
                                @if($user->id == auth()->user()->id) @continue; @endif
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
              </div>

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Tipo Evento</label>
                      <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                          <select class="form-control" name="event_type" id="event_type">
                            @foreach(App\Helpers\Helper::scheduleTypes() as $type)
                                <option value="{{$type->id}}" {{ $type->id == $schedule->type_id ? 'selected' : '' }}>{{$type->name}}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
              </div>

              <div class="col-md-12">
                  <div class="form-group" id="pac-card">
                      <label>Localização</label>
                      <div class="input-group" id="pac-container">
                          <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                          <input class="form-control" name="localization" value="{{ $schedule->localization }}" id="pac-input">
                      </div>
                  </div>
              </div>

              <div class="col-md-12">
                  <div class="form-group">
                      <label>Adicionar uma descrição</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                        <textarea class="form-control" rows="6" id="description" name="description">{{ $schedule->description }}</textarea>
                      </div>
                  </div>
              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('schedules.show', $schedule->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
