@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('delivery-order.index') }}">Ordem de Entrega</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Conferência</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <form class="formValidation" data-parsley-validate method="post" action="{{route('delivery-order.store')}}">
        {{csrf_field()}}

        <div class="row">

              <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Nova Ordem de Entrega</h5>
                    </div>
                    <div class="card-block">

                        <div class="row m-b-30">

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                                    <label class="col-form-label">Cliente</label>
                                    <div class="input-group">
                                      <select class="select2 select-client-addresses select-client-documents"
                                        data-search-addresses="{{ route('client_addresses_search') }}"
                                        data-search-documents="{{ route('client_documents_search') }}"
                                        name="client_id" required>
                                            <option value="">Selecione um Cliente</option>
                                            @foreach($clients as $client)
                                                <option value="{{$client->uuid}}" {{ request()->get('client') == $client->uuid ? 'selected' : '' }}>{{$client->name}}</option>
                                            @endforeach
                                      </select>
                                    </div>
                                    {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                              <div class="form-group {!! $errors->has('address_id') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Endereço</label>
                                  <div class="input-group">
                                    <select class="form-control" id="select-address" name="address_id" required>
                                        <option value="">Selecione um Endereço</option>
                                        @foreach($addresses as $address)
                                            <option value="{{$address->uuid}}" {{ $loop->first ? 'selected' : '' }}>{{$address->description}}</option>
                                        @endforeach
                                    </select>
                                    <button data-toggle="modal" data-target="#delivery-modal" type="button" class="input-group-addon"><i class="feather icon-plus"></i></button>
                                  </div>
                                  {!! $errors->first('address_id', '<p class="help-block">:message</p>') !!}
                              </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('delivered_by') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Entregador</label>
                                    <div class="input-group">
                                      <select class="form-control select-entregador" data-search-user="{{ route('user_search') }}" name="delivered_by" required>
                                          <option value="">Selecione um entregador</option>
                                          @foreach($delivers as $deliver)
                                              <option value="{{$deliver->uuid}}">{{$deliver->name}}</option>
                                          @endforeach
                                      </select>
                                      {!! $errors->first('delivered_by', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('delivery_date') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Entrega</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control inputDate" name="delivery_date" required/>
                                        {!! $errors->first('delivery_date', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('annotations') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Anotações</label>
                                    <div class="input-group">
                                        <textarea rows="5" class="form-control" name="annotations"></textarea>
                                        {!! $errors->first('annotations', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <button class="btn btn-success btn-sm btn-block">Salvar</button>

                      </div>
                  </div>
              </div>

              <div class="col-lg-8">
                  <div class="card">
                      <div class="card-header">
                          <h5>Documentos</h5>
                      </div>
                      <div class="card-block">

                        <div class="table-responsive">

                        <table class="table table-hover">

                            <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Tipo</th>
                                  <th>Cliente</th>
                                  <th>Funcionário</th>
                                  <th>Referencia</th>
                                  <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="table-documents">

                                @foreach($documents as $document)
                                <tr>
                                    @php
                                        $docs = request()->get('document');

                                        $checked = '';

                                        if(in_array($document->uuid, $docs)) {
                                          $checked = 'checked';
                                        }
                                    @endphp

                                    <td><input class="js-switch" type="checkbox" {{ $checked }} name="documents[]" value="{{ $document->uuid }}"/></td>
                                    <td>{{ $document->type->name }}</td>
                                    <td>{{ $document->client->name ?? '' }}</td>
                                    <td>{{ $document->employee->name ?? '-' }}</td>
                                    <td>{{ $document->reference ?? '' }}</td>
                                    <td>{{ $document->status->name }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                        </div>

                      </div>
                  </div>
              </div>

          </div>
    </form>
</div>

<div class="modal inmodal" id="delivery-modal" tabindex="-1" role="dialog" aria-hidden="true"  style="z-index:1041">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
              <h4 class="modal-title">Novo Compromisso</h4>
            </div>

            <form class="formValidation" data-parsley-validate method="POST" action="{{ route('schedules.store') }}">
            <div class="modal-body">

                  {{  csrf_field() }}
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input autofocus required class="form-control" name="title" id="title">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Inicio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" id="start" name="start" required readonly class="form-control datetimepicker" data-date-format="dd/mm/yyyy hh:ii" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group ">
                            <label>Fim</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                  <input type="text" id="end" name="end" required readonly class="form-control datetimepicker" data-date-format="dd/mm/yyyy hh:ii" value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar convidados</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control select2" multiple title="Selecione um paciente" data-style="btn-white" data-live-search="true" show-tick show-menu-arrow data-width="100%" name="guests[]" id="guests">
                                  <option value="todos">Todos</option>
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
                                      <option value="{{$type->id}}">{{$type->name}}</option>
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
                                <input class="form-control" name="localization" id="pac-input">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Adicionar uma descrição</label>
                            <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                              <textarea class="form-control" rows="6" id="description" name="description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Criar Nova tarefa</label>
                            <div class="input-group">
                              <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="do_task" class="js-switch">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enviar e-mail de Notificação</label>
                            <div class="input-group">
                              <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="send_notification_mail" class="js-switch">
                            </div>
                        </div>
                    </div>

                  </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnConsulta" class="btn btn-success">Salvar</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script>

      $(document).ready(function() {

      });

    </script>
@stop
