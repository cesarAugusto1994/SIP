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
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Nova Tarefa</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('tasks.store')}}" data-parsley-validate>
            @csrf

            <div class="row m-b-30">

              <div class="col-md-12">
                <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Titulo</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-heading"></i></span>
                      <input type="text" placeholder="Titulo da Tarefa" required name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Descrição</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-font"></i></span>
                      <textarea type="text" name="description" id="description" rows="4"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control ckeditor">{{ old('description') }}</textarea>
                    </div>
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('sponsor_id') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Responsável</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <select class="form-control select2" data-style="btn-white" name="sponsor_id" required>
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
                          <span class="input-group-addon"><i class="far fa-clock"></i></span>
                          <select class="form-control select2" name="time_type">
                              <option value="day">Dia(s)</option>
                              <option value="hour" selected>Hora(s)</option>
                              <option value="minute">Minuto(s)</option>
                          </select>
                        </div>
                        {!! $errors->first('time_type', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>
                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('time') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tempo</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="far fa-clock"></i></span>
                          <input type="number" min="1" required name="time" id="time" class="form-control" value="1">
                        </div>
                        {!! $errors->first('time', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('percent_conclusion') ? 'has-error' : '' !!}">
                        <label class="col-form-label">% Conclusão</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                          <select class="form-control select2" name="percent_conclusion">
                              <option value="0">0</option>
                              <option value="10">10</option>
                              <option value="20">20</option>
                              <option value="30">30</option>
                              <option value="40">40</option>
                              <option value="50">50</option>
                              <option value="60">60</option>
                              <option value="70">70</option>
                              <option value="80">80</option>
                              <option value="90">90</option>
                              <option value="100">100</option>
                          </select>
                        </div>
                        {!! $errors->first('percent_conclusion', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                </div>

              </div>

              <div class="col-md-3">
                <div class="form-group {!! $errors->has('requester_id') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Solicitante</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <select class="form-control select2" name="requester_id">
                          <option value="">Informe o Solicitante</option>
                          @foreach(\App\Helpers\Helper::users() as $user)
                              <option value="{{$user->id}}">{{$user->person->name}}</option>
                          @endforeach
                      </select>
                    </div>
                    {!! $errors->first('requester_id', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Cliente</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <select class="form-control select-client" name="client_id">
                      </select>
                    </div>
                    {!! $errors->first('label', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-6">

                <div class="row">

                  <div class="col-md-4">
                    <div class="form-group {!! $errors->has('start') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Data de Início</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                          <input autocomplete="off" type="text" name="start" class="form-control inputDate" value="{{ old('start') }}">
                        </div>
                        {!! $errors->first('start', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group {!! $errors->has('end') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Data de Término</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                          <input autocomplete="off" type="text" name="end" class="form-control inputDate" value="{{ old('end') }}">
                        </div>
                        {!! $errors->first('end', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>


                  <div class="col-md-4">

                    <div class="form-group {!! $errors->has('frequency') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Frequencia</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fas fa-percent"></i></span>
                          <select class="form-control select2" name="frequency">

                              <option value="Nao se repete">Não se repete</option>
                              <!--
                              <option value="Diariamente">Diariamente</option>
                              <option value="Semanalmente">Semanalmente</option>
                              <option value="Mensalmente">Mensalmente</option>
                              <option value="Segunda">Segunda-Feira</option>
                              <option value="Terca">Terça-Feira</option>
                              <option value="Quarta">Quarta-Feira</option>
                              <option value="Quinta">Quinta-Feira</option>
                              <option value="Sexta">Sexta-Feira</option>
                              -->
                          </select>
                        </div>
                        {!! $errors->first('frequency', '<p class="help-block">:message</p>') !!}
                    </div>

                  </div>

                </div>

              </div>

              <div class="col-md-4">
                <div class="form-group {!! $errors->has('severity') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Gravidade (Risco)</label>
                    <div class="input-group">
                      <select class="form-control select2" name="severity">
                          <option value="1">1 (baixissima)</option>
                          <option value="2">2 (baixa)</option>
                          <option value="3">3 (moderada)</option>
                          <option value="4">4 (alta)</option>
                          <option value="5">5 (altissima)</option>
                      </select>

                    </div>
                    {!! $errors->first('severity', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group {!! $errors->has('urgency') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Urgência (Prioridade)</label>
                    <div class="input-group">
                      <select class="form-control select2" name="urgency">
                        <option value="1">1 (baixissima)</option>
                        <option value="2">2 (baixa)</option>
                        <option value="3">3 (moderada)</option>
                        <option value="4">4 (alta)</option>
                        <option value="5">5 (altissima)</option>
                      </select>

                    </div>
                    {!! $errors->first('urgency', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group {!! $errors->has('trend') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Tendência (Importância)</label>
                    <div class="input-group">
                      <select class="form-control select2" name="trend">
                        <option value="1">1 (baixissima)</option>
                        <option value="2">2 (baixa)</option>
                        <option value="3">3 (moderada)</option>
                        <option value="4">4 (alta)</option>
                        <option value="5">5 (altissima)</option>
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
