@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Remessa de Entrega</h4>
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

    <form class="formValidation" data-parsley-validate method="post" autocomplete="off" action="{{route('delivery_order_store_many')}}">
        {{csrf_field()}}

        <div class="row">

              <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-c-green update-card">
                        <h5 class="text-white">Nova Remessa de Entrega</h5>
                    </div>
                    <div class="card-block">

                        <div class="row m-b-30">

                            <div class="col-md-12 m-t-30">

                                <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                                    <label class="col-form-label">Empresa</label>
                                    <div class="input-group">
                                      <select class="select2"
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
                              <div class="form-group {!! $errors->has('address_id') ? 'has-error' : '' !!}">
                                  <label class="col-form-label">Endereço</label>
                                  <div class="input-group">
                                    <select class="form-control select2" id="select-address" name="address_id">
                                        <option value="">Selecione um Endereço</option>
                                        @foreach($client->addresses as $address)
                                            <option value="{{$address->uuid}}" {{ $loop->first ? 'selected' : '' }}>{{$address->description}} - {{$address->street}}, {{$address->number}} - {{$address->district}}, {{$address->city}} - {{$address->zip}}</option>
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
                                        <th>Cliente</th>
                                      </tr>
                                  </thead>
                                  <tbody id="table-documents">

                                      @foreach($documents as $document)
                                        <tr>
                                            <td><input class="js-switch select-item" type="checkbox" name="documents[]" value="{{ $document->uuid }}"/></td>
                                            <td>{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</td>
                                            <td>{{ $document->type->name }}</td>
                                            <td>{{ $document->client->name ?? '' }}
                                              <br/><small>Funcionário: {{ $document->employee->name ?? '' }}</small>
                                              <br/>
                                              <br/>Endereço
                                              <select class="form-control select2" data-client="{{ $document->client->id }}" id="select-address"
                                                name="address_id-{{ $document->id }}">
                                                  <option value="">Selecione um Endereço</option>
                                                  @foreach($document->client->addresses as $address)
                                                      <option value="{{$address->uuid}}" {{ $loop->first ? 'selected' : '' }}>{{$address->description}} - {{$address->street}}, {{$address->number}} - {{$address->district}}, {{$address->city}} - {{$address->zip}}</option>
                                                  @endforeach
                                              </select>
                                              <br/>
                                              <br/>
                                              <input type="checkbox" value="1" class="js-switch" name="charge_delivery-{{ $document->id }}" checked/>
                                              Cobrar Entrega<br/>
                                              <br/>
                                              <input type="checkbox" value="1" class="js-switch" name="withdrawal_by_client-{{ $document->id }}"/>
                                              Retirado pelo Cliente
                                            </td>

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
