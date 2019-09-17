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
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <form class="formValidation" data-parsley-validate method="post" action="{{route('delivery-order.update', $delivery->uuid)}}">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="row">

              <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-c-green update-card">
                        <h5 class="text-white">Editar Ordem de Entrega</h5>
                    </div>
                    <div class="card-block">

                        <div class="row m-b-30">

                            <div class="col-md-12 m-t-30">

                            <h4>{{ $delivery->client->name }}</h4>

                            </div>

                            <div class="col-md-12">

                              <div class="form-group {!! $errors->has('address_id') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Endereço</label>
                                  <div class="input-group">
                                    <select class="select2" id="select-address" name="address_id" required>
                                        @foreach($addresses as $address)
                                            <option value="{{$address->uuid}}" {{ $loop->first ? 'selected' : '' }}>{{$address->description}} - {{$address->zip}} - {{$address->street}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  {!! $errors->first('address_id', '<p class="help-block">:message</p>') !!}
                              </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('delivered_by') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Entregador</label>
                                    <div class="input-group">
                                      <select class="select2 select-entregador" data-search-user="{{ route('user_search') }}" name="delivered_by" required>

                                          <optgroup label="Entregadores">
                                            <option value="">Selecione um entregador</option>
                                            @foreach($delivers as $deliver)
                                                <option value="{{$deliver->uuid}}" {{ $deliver->id == $delivery->delivered_by ? 'selected' : '' }}>{{$deliver->name}}</option>
                                            @endforeach
                                          </optgroup>
                                          <optgroup label="Outros Usuários">
                                            @foreach($anotherPeople as $person)
                                                <option value="{{$person->uuid}}" {{ $person->user->id == $delivery->delivered_by ? 'selected' : '' }}>{{$person->name}}</option>
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
                                        <input type="text" required class="form-control inputDate" name="delivery_date" value="{{ $delivery->delivery_date ? $delivery->delivery_date->format('d/m/Y') : '' }}"/>
                                        {!! $errors->first('delivery_date', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="form-group {!! $errors->has('annotations') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Anotações</label>
                                    <div class="input-group">
                                        <textarea rows="5" class="form-control" name="annotations">{{ $delivery->annotations }}</textarea>
                                        {!! $errors->first('annotations', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <button class="btn btn-success btn-sm">Salvar</button>

                      </div>
                  </div>
              </div>

              <div class="col-lg-8">
                  <div class="card">
                      <div class="card-header">
                          <h5>Documentos</h5>
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
                                          $docs = $delivery->documents->pluck('document.uuid');

                                          $checked = '';

                                          if(in_array($document->uuid, $docs->toArray())) {
                                            $checked = 'checked';
                                          }

                                      @endphp

                                      <td><input class="js-switch select-item" type="checkbox" {{ $checked }} name="documents[]" value="{{ $document->uuid }}"/></td>
                                      <td>#{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</td>
                                      <td>{{ $document->type->name }}</td>
                                      <td>{{ $document->employee->name ?? '-' }}</td>
                                      <td>{{ $document->reference }}</td>
                                      <td><label class="label label-inverse-primary">{{ $document->status->name }}</label></td>
                                  </tr>
                                @endforeach

                                <tr class="table-primary">
                                  <th colspan="6">Adicionar novos documentos</th>
                                </tr>

                                @foreach($newDocuments as $document)
                                  <tr>
                                      <td><input class="js-switch select-item" type="checkbox" name="documents[]" value="{{ $document->uuid }}"/></td>
                                      <td>#{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</td>
                                      <td>{{ $document->type->name }}</td>
                                      <td>{{ $document->employee->name ?? '-' }}</td>
                                      <td>{{ $document->reference }}</td>
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
    var selectAddress = $("#div-select-address");
    var btnSubmitForm = $(".btnSubmitForm");

    selectClient.change(function() {
        clientId.val($(this).val());
    });

    checkboxNewAddress.change(function() {

      if(checkboxNewAddress.is(':checked')) {
          inputNewAddress.show();
          selectAddress.hide();
      } else {
          inputNewAddress.hide();
          selectAddress.show();
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
