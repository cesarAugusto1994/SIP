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
                    <li class="breadcrumb-item"><a href="#!">Nova</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Nova Tarefa</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('tasks.store')}}" data-parsley-validate>
            @csrf

            <div class="row m-b-30">

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Titulo</label>
                    <div class="input-group">
                      <input type="text" required name="name" class="form-control">

                    </div>
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Descrição</label>
                    <div class="input-group">
                      <textarea type="text" required name="description" id="description" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control"></textarea>

                    </div>
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('sponsor_id') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Responsável</label>
                    <div class="input-group">
                      <select class="form-control" data-style="btn-white" name="sponsor_id" required>
                          @foreach(\App\Helpers\Helper::users() as $user)
                              <option value="{{$user->id}}" {{ $user->id == Auth::user()->id ? 'selected' : '' }}>{{$user->person->name}}</option>
                          @endforeach
                      </select>
                      {!! $errors->first('sponsor_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
              </div>

              <div class="col-md-6">

                <div class="row">
                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('time_type') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tipo de Tempo</label>
                        <div class="input-group">
                          <select class="form-control" name="time_type">
                              <option value="day">Dia(s)</option>
                              <option value="hour">Hora(s)</option>
                              <option value="minute">Minuto(s)</option>
                          </select>
                        </div>
                        {!! $errors->first('time_type', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>
                  <div class="col-md-8">

                    <div class="form-group {!! $errors->has('time') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tempo</label>
                        <div class="input-group">
                          <input type="number" required name="time" id="time" class="form-control" value="1">
                        </div>
                        {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>
                </div>

              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('requester_id') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Solicitante</label>
                    <div class="input-group">
                      <select class="form-control" name="requester_id">
                          <option value="">Informe o Solicitante</option>
                          @foreach(\App\Helpers\Helper::users() as $user)
                              <option value="{{$user->id}}">{{$user->person->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    {!! $errors->first('requester_id', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('severity') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Gravidade</label>
                    <div class="input-group">
                      <select class="form-control" name="severity">
                          <option value="1" data-content="<span class='label label-default'>1 (baixissima)</span>">1 (baixissima)</option>
                          <option value="2" data-content="<span class='label label-primary'>2 (baixa)</span>">2 (baixa)</option>
                          <option value="3" data-content="<span class='label label-success'>3 (moderada)</span>">3 (moderada)</option>
                          <option value="4" data-content="<span class='label label-warning'>4 (alta)</span>">4 (alta)</option>
                          <option value="5" data-content="<span class='label label-danger'>5 (altissima)</span>">5 (altissima)</option>
                      </select>

                    </div>
                    {!! $errors->first('severity', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('urgency') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Urgencia</label>
                    <div class="input-group">
                      <select class="form-control" name="urgency">
                        <option value="1" data-content="<span class='label label-default'>1 (baixissima)</span>">1 (baixissima)</option>
                        <option value="2" data-content="<span class='label label-primary'>2 (baixa)</span>">2 (baixa)</option>
                        <option value="3" data-content="<span class='label label-success'>3 (moderada)</span>">3 (moderada)</option>
                        <option value="4" data-content="<span class='label label-warning'>4 (alta)</span>">4 (alta)</option>
                        <option value="5" data-content="<span class='label label-danger'>5 (altissima)</span>">5 (altissima)</option>
                      </select>

                    </div>
                    {!! $errors->first('urgency', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('trend') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Tendencia</label>
                    <div class="input-group">
                      <select class="form-control" name="trend">
                        <option value="1" data-content="<span class='label label-default'>1 (baixissima)</span>">1 (baixissima)</option>
                        <option value="2" data-content="<span class='label label-primary'>2 (baixa)</span>">2 (baixa)</option>
                        <option value="3" data-content="<span class='label label-success'>3 (moderada)</span>">3 (moderada)</option>
                        <option value="4" data-content="<span class='label label-warning'>4 (alta)</span>">4 (alta)</option>
                        <option value="5" data-content="<span class='label label-danger'>5 (altissima)</span>">5 (altissima)</option>
                      </select>

                    </div>
                    {!! $errors->first('trend', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a href="{{route('tasks.index')}}" class="btn btn-danger btn-sm">Cancelar</a>
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
