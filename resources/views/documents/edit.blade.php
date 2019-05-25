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
                          <select class="select2 select-client-employees"
                            data-search-employees="{{ route('client_employees_search') }}"
                            name="client_id" required>
                                @foreach($clients as $client)
                                    <option value="{{$client->uuid}}" {{ $document->client_id == $client->id ? 'selected' : '' }}>{{$client->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {!! $errors->first('client_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group {!! $errors->has('employee_id') ? 'has-error' : '' !!}">
                      <label class="col-form-label">Funcionário</label>
                      <div class="input-group">
                        <select class="select2" id="select-employee" name="employee_id">
                              <option value="">Selecione um Funcionário</option>
                              @foreach($employees as $employee)
                                  <option value="{{$employee->uuid}}" {{ $document->employee_id == $employee->id ? 'selected' : '' }}>{{$employee->name}}</option>
                              @endforeach
                        </select>
                      </div>
                      {!! $errors->first('employee_id', '<p class="help-block">:message</p>') !!}
                  </div>

                </div>

                <div class="col-md-12">

                  <div class="form-group {!! $errors->has('annotations') ? 'has-error' : '' !!}">
                      <label class="col-form-label">Anotações</label>
                      <div class="input-group">
                        <textarea class="form-control" rows="4" name="annotations">{{ $document->annotations }}</textarea>
                      </div>
                      {!! $errors->first('annotations', '<p class="help-block">:message</p>') !!}
                  </div>

                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('documents.index') }}">Cancelar</a>
            
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
