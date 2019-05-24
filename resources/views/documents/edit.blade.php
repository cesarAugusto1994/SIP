@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Documentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Documentos</a>
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
          <h5>Editar Documento</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('documents.update', $document->uuid)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">

                    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Descrição</label>
                        <div class="input-group">
                          <input type="text" required name="description" value="{{ $document->description }}" class="form-control">
                        </div>
                        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                    </div>

                    <div class="form-group {!! $errors->has('type_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Tipo</label>
                        <div class="input-group">
                          <select class="select2" name="type_id" required>
                                @foreach($types as $type)
                                    <option value="{{$type->uuid}}" {{ $document->type_id == $type->id ? 'selected' : '' }}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">



                    <div class="form-group {!! $errors->has('client_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label">Cliente</label>
                        <div class="input-group">
                          <select class="select2 select-client-addresses" data-search-addresses="{{ route('client_addresses_search') }}" name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{$client->uuid}}" {{ $document->client_id == $client->id ? 'selected' : '' }}>{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">


                  <div class="form-group {!! $errors->has('address_id') ? 'has-error' : '' !!}">
                      <label class="col-form-label">Endereço</label>
                      <div class="input-group">
                        <select class="select2" id="select-address" name="address_id" required>
                          @foreach($document->client->addresses as $address)
                              <option value="{{$address->uuid}}" {{ $document->address_id == $address->id ? 'selected' : '' }}>{{$address->description}}</option>
                          @endforeach
                        </select>
                      </div>
                      {!! $errors->first('address_id', '<p class="help-block">:message</p>') !!}
                  </div>


                </div>

            </div>

            <button class="btn btn-primary">Salvar</button>
            <a class="btn btn-white" href="{{ route('documents.index') }}">Cancelar</a>
        </form>

      </div>
  </div>
</div>

@endsection

@push('scripts')
    <script>

      $(document).ready(function() {

        let selectClientAddress = $(".select-client-addresses");
        let selectAddress = $("#select-address");

        selectClientAddress.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

          let self = $(this);
          let route = self.data('search-addresses');
          let value = self.val();

          $.ajax({
            type: 'GET',
            url: route + '?param=' + value,
            async: true,
            success: function(response) {

              let html = "";
              selectAddress.html("");
              selectAddress.selectpicker('refresh');

              $.each(response.data, function(idx, item) {

                  html += "<option value="+ item.uuid +">"+ item.description +"</option>";

              });

              selectAddress.append(html);
              selectAddress.selectpicker('refresh');

            }
          })

        });

      });

    </script>
@endpush
