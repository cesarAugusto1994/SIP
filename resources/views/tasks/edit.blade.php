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
                    <li class="breadcrumb-item">
                        <a href="{{ route('tasks.index') }}"> Tarefas </a>
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
          <h5>Editar Tarefa</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('tasks.update', $task->uuid)}}" data-parsley-validate>
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

              <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" value="{{$task->name}}" class="form-control">
                    </div>
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label">Descrição</label>
                    <div class="input-group">
                      <textarea type="text" required name="description" id="description" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control">{{$task->description}}</textarea>

                    </div>
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label">Responsável</label>
                    <div class="input-group">
                      <select class="form-control" name="sponsor_id" required>
                          @foreach(\App\Helpers\Helper::users() as $user)
                              <option value="{{$user->id}}" {{ $user->id == $task->sponsor_id ? 'selected' : '' }}>{{$user->person->name}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>
              </div>

              <div class="col-md-6">

                <div class="row">
                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('time_type') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tipo de Tempo</label>
                        <div class="input-group">
                          <select class="form-control" name="time_type" required>
                              <option value="">Selecione um item</option>
                              <option value="day" {{ $task->time_type == 'day' ? 'selected' : '' }}>Dia(s)</option>
                              <option value="hour" {{ $task->time_type == 'hour' ? 'selected' : '' }}>Hora(s)</option>
                              <option value="minute" {{ $task->time_type == 'minute' ? 'selected' : '' }}>Minuto(s)</option>
                          </select>
                        </div>
                        {!! $errors->first('time_type', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>
                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('time') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tempo</label>
                        <div class="input-group">
                          <input type="number" min="1" max="100" required value="{{ $task->time ?? 1 }}" name="time" id="time" class="form-control" value="1">
                        </div>
                        {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('percent_conclusion') ? 'has-error' : '' !!}">
                        <label class="col-form-label">% Conclusão</label>
                        <div class="input-group">
                          <select class="form-control" name="percent_conclusion">
                              <option value="0" {{ $task->percent_conclusion == '0' ? 'selected' : '' }}>0</option>
                              <option value="10" {{ $task->percent_conclusion == '10' ? 'selected' : '' }}>10</option>
                              <option value="20" {{ $task->percent_conclusion == '20' ? 'selected' : '' }}>20</option>
                              <option value="30" {{ $task->percent_conclusion == '30' ? 'selected' : '' }}>30</option>
                              <option value="40" {{ $task->percent_conclusion == '40' ? 'selected' : '' }}>40</option>
                              <option value="50" {{ $task->percent_conclusion == '50' ? 'selected' : '' }}>50</option>
                              <option value="60" {{ $task->percent_conclusion == '60' ? 'selected' : '' }}>60</option>
                              <option value="70" {{ $task->percent_conclusion == '70' ? 'selected' : '' }}>70</option>
                              <option value="80" {{ $task->percent_conclusion == '80' ? 'selected' : '' }}>80</option>
                              <option value="90" {{ $task->percent_conclusion == '90' ? 'selected' : '' }}>90</option>
                              <option value="100" {{ $task->percent_conclusion == '100' ? 'selected' : '' }}>100</option>
                          </select>
                        </div>
                        {!! $errors->first('percent_conclusion', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                </div>

              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label">Solicitante</label>
                    <div class="input-group">
                      <select class="form-control" name="requester_id">
                            @foreach(\App\Helpers\Helper::users() as $user)
                                <option value="{{$user->id}}" {{ $user->id == $task->requester_id ? 'selected' : '' }}>{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      {!! $errors->first('requester_id', '<p class="help-block">:message</p>') !!}
                    </div>
                    </div>
                </div>

              <div class="col-md-6">

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group {!! $errors->has('start') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Data de Início</label>
                        <div class="input-group">
                          <input autocomplete="off" type="text" name="start" class="form-control inputDate" value="{{ $task->start ? $task->start->format('d/m/Y') : '' }}">
                        </div>
                        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group {!! $errors->has('end') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Data de Término</label>
                        <div class="input-group">
                          <input autocomplete="off" type="text" name="end" class="form-control inputDate" value="{{ $task->end ? $task->end->format('d/m/Y') : '' }}">
                        </div>
                        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                </div>

              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label">Gravidade</label>
                    <div class="input-group">

                      <select class="form-control" data-live-search="true" data-style="btn-white" show-tick show-menu-arrow data-width="100%"  name="severity">
                        <option value="1" {{ 1 == $task->severity ? 'selected' : '' }}>1 (baixissima)</option>
                        <option value="2" {{ 2 == $task->severity ? 'selected' : '' }}>2 (baixa)</option>
                        <option value="3" {{ 3 == $task->severity ? 'selected' : '' }}>3 (moderada)</option>
                        <option value="4" {{ 4 == $task->severity ? 'selected' : '' }}>4 (alta)</option>
                        <option value="5" {{ 5 == $task->severity ? 'selected' : '' }}>5 (altissima)</option>
                      </select>

                    </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label">Urgencia</label>
                    <div class="input-group">
                      <select class="form-control" data-live-search="true" data-style="btn-white" show-tick show-menu-arrow data-width="100%"  name="urgency">
                        <option value="1" {{ 1 == $task->urgency ? 'selected' : '' }}>1 (baixissima)</option>
                        <option value="2" {{ 2 == $task->urgency ? 'selected' : '' }}>2 (baixa)</option>
                        <option value="3" {{ 3 == $task->urgency ? 'selected' : '' }}>3 (moderada)</option>
                        <option value="4" {{ 4 == $task->urgency ? 'selected' : '' }}>4 (alta)</option>
                        <option value="5" {{ 5 == $task->urgency ? 'selected' : '' }}>5 (altissima)</option>
                      </select>
                    </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label">Tendencia</label>
                    <div class="input-group">
                      <select class="form-control" data-live-search="true" data-style="btn-white" show-tick show-menu-arrow data-width="100%"  name="trend">
                        <option value="1" {{ 1 == $task->trend ? 'selected' : '' }}>1 (baixissima)</option>
                        <option value="2" {{ 2 == $task->trend ? 'selected' : '' }}>2 (baixa)</option>
                        <option value="3" {{ 3 == $task->trend ? 'selected' : '' }}>3 (moderada)</option>
                        <option value="4" {{ 4 == $task->trend ? 'selected' : '' }}>4 (alta)</option>
                        <option value="5" {{ 5 == $task->trend ? 'selected' : '' }}>5 (altissima)</option>
                      </select>
                    </div>
                </div>
              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a href="{{route('tasks.show', ['id' => $task->uuid])}}" class="btn btn-danger btn-sm">Cancelar</a>
        </form>

      </div>
  </div>
</div>

@endsection

@push('scripts')

  <script>

      $('.clockpicker').clockpicker();

      $(document).ready(function() {
        $('#select-processes').change(function() {
            //$('#description').val($('#select-processes option:selected').text());
        });
        //$('#description').val($('#select-processes option:selected').text());
      });
  </script>

@endpush
