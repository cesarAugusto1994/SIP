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

    <form class="formValidation" data-parsley-validate method="post" autocomplete="off" action="{{route('delivery-order.store')}}">
        {{csrf_field()}}

        <div class="row">

              <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-c-green update-card">
                        <h5 class="text-white">Nova Ordem de Entrega</h5>
                    </div>
                    <div class="card-block">

                        <div class="row m-b-30">

                            <div class="col-md-12 m-t-30">

                                <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                                    <label class="col-form-label">Cliente</label>
                                    <div class="input-group">
                                      <select class="select-client select-client-addresses select-client-emails select-client-documents"
                                        data-search-addresses="{{ route('client_addresses_search') }}"
                                        data-search-emails="{{ route('client_emails_search') }}"
                                        data-search-documents="{{ route('client_documents_search') }}"
                                        name="client_id" required>
                                            @if($client)
                                              <option value="{{$client->uuid}}">{{$client->name}}</option>
                                            @endif
                                      </select>
                                    </div>
                                    {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                                </div>

                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <div class="input-group">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <input type="checkbox" name="checkbox_address" value="1" id="checkbox-new-address">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span class="text-inverse">Adicionar NOVO Endereço</span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12" id="div-select-address">
                              <div class="form-group {!! $errors->has('address_id') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Endereço</label>
                                  <div class="input-group">
                                    <select class="form-control select2" id="select-address" name="address_id">
                                        <option value="">Selecione um Endereço</option>
                                        @foreach($addresses as $address)
                                            <option value="{{$address->uuid}}" {{ $loop->first ? 'selected' : '' }}>{{$address->description}} - {{$address->street}}, {{$address->number}} - {{$address->district}}, {{$address->city}} - {{$address->zip}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  {!! $errors->first('address_id', '<p class="help-block">:message</p>') !!}
                              </div>
                            </div>

                            <div class="col-md-12" style="display:none">
                              <div class="form-group">
                                  <div class="input-group">
                                    <div class="checkbox-fade fade-in-primary d-">
                                        <label>
                                            <input type="checkbox" name="checkbox_address" value="1" id="checkbox-new-address">
                                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                            <span class="text-inverse">Adicionar NOVO Endereço</span>
                                        </label>
                                    </div>
                                  </div>
                              </div>
                            </div>

                            <div class="col-md-12" id="input-new-address" style="display:none;">

                                <div class="form-group {!! $errors->has('address') ? 'has-error' : '' !!}">
                                  <label class="col-form-label text-primary">Novo Endereço</label>
                                    <div class="input-group" id="pac-container">
                                        <span class="input-group-addon"><i class="fas fa-map-marked-alt"></i></span>
                                        <input class="form-control" name="address" id="pac-input" autocomplete="off"/>
                                    </div>

                                    <input type="hidden" name="street_number" id="street_number">
                                    <input type="hidden" name="route" id="route">
                                    <input type="hidden" name="sublocality_level_1" id="sublocality_level_1">
                                    <input type="hidden" name="administrative_area_level_2" id="administrative_area_level_2">
                                    <input type="hidden" name="administrative_area_level_1" id="administrative_area_level_1">
                                    <input type="hidden" name="postal_code" id="postal_code">

                                    <input type="hidden" name="lng" id="lng">
                                    <input type="hidden" name="lat" id="lat">

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('emails') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">E-mail de Notificação</label>
                                    <div class="input-group">
                                      <select class="form-control select2" id="select-email" name="emails[]" multiple>
                                          <option value="">Selecione um e-mail</option>
                                          @foreach($emails as $email)
                                              <option value="{{$email->email}}">{{$email->email}}</option>
                                          @endforeach
                                      </select>
                                      {!! $errors->first('emails', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('delivered_by') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Entregador</label>
                                    <div class="input-group">
                                      <select class="form-control select-entregador select2" data-search-user="{{ route('user_search') }}" name="delivered_by" required>
                                        <optgroup label="Entregadores">
                                          <option value="">Selecione um entregador</option>
                                          @foreach($delivers as $deliver)
                                              <option value="{{$deliver->uuid}}">{{$deliver->name}}</option>
                                          @endforeach
                                        </optgroup>
                                        <optgroup label="Outros Usuários">
                                          @foreach($anotherPeople as $person)
                                              <option value="{{$person->uuid}}">{{$person->name}}</option>
                                          @endforeach
                                        </optgroup>
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

                            <div class="col-md-6">

                                <div class="form-group">
                                  <label class="col-form-label">Cobrar Entrega</label>
                                    <div class="input-group">
                                        <input type="checkbox" class="js-switch" name="charge_delivery" checked/>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                  <label class="col-form-label">Retirado pelo Cliente</label>
                                    <div class="input-group">
                                        <input type="checkbox" class="js-switch" name="withdrawal_by_client"/>
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

                        <button class="btn btn-success btn-sm btn-block btnSubmitForm">Salvar</button>

                      </div>
                  </div>
              </div>

              <div class="col-lg-8">

                  <div class="card">
                      <div class="card-header">
                          <h5>Documentos Pendentes</h5>
                      </div>
                      <div class="card-block table-border-style">
                          <div class="table-responsive">
                              <table class="table table-lg table-styling">
                                  <thead>
                                      <tr class="table-primary">
                                        <th>
                                            <input class="js-switch" type="checkbox" id="select-all" name="select_all" value="1"/>
                                        </th>
                                        <th>ID</th>
                                        <th>Tipo</th>
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

                                          <td><input class="js-switch select-item" type="checkbox" {{ $checked }} name="documents[]" value="{{ $document->uuid }}"/></td>
                                          <td>{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</td>
                                          <td>{{ $document->type->name }}</td>
                                          <td>{{ $document->employee->name ?? '-' }}</td>
                                          <td>{{ $document->reference ?? '' }}</td>
                                          <td><label class="label label-inverse-primary">{{ $document->status->name }}</label></td>
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

@endsection

@section('scripts')

<script>

    var clientId = $("#client-id");
    var selectClient = $(".select-client-modal-address");

    var checkboxNewAddress = $("#checkbox-new-address");
    var inputNewAddress = $("#input-new-address");
    var divSelectAddress = $("#div-select-address");
    var btnSubmitForm = $(".btnSubmitForm");

    selectClient.change(function() {
        //clientId.val($(this).val());
    });

    checkboxNewAddress.change(function() {

      if(checkboxNewAddress.is(':checked')) {
          inputNewAddress.show();
          divSelectAddress.hide();
      } else {
          inputNewAddress.hide();
          divSelectAddress.show();
      }

    });

    var clickCheckbox = document.querySelector('#select-all');

    $(document).on('change','#select-all',function(){

      var itemsCheckbox = $('.select-item');

      if (clickCheckbox.checked) {

          $.each(itemsCheckbox, function(idx, elem) {

              if(!$(elem).is(':checked')) {
                  $(elem).trigger('click');
              }

          });

      } else {

          $.each(itemsCheckbox, function(idx, elem) {
            if($(elem).is(':checked')) {
                $(elem).trigger('click');
            }
          });

      }
    });

</script>

@endsection
