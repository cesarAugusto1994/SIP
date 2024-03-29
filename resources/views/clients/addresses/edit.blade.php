@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Endereços do Cliente</h4>
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
                        <a href="{{ route('clients.show', $client->uuid) }}"> Cliente </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar Endereço</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Editar Endereço</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate action="{{route('client_addresses_update', [$client->uuid, $address->uuid])}}" method="post">
            {{csrf_field()}}
            {{method_field('PUT')}}
          <div class="row">

          <div class="form-group col-md-6"><label class="control-label">Descrição</label>
              <input type="text" name="description" value="{{ $address->description }}" required class="form-control" id="description" placeholder="Ex: Matriz">
          </div>

          <div class="form-group col-md-6"><label class="control-label">CNPJ</label>
              <input type="text" name="document" id="document" value="{{ $address->document }}" class="form-control" id="document">
          </div>

          <div class="form-group col-md-3"><label class="control-label">CEP</label>
              <input type="text" data-cep="{{ route('cep') }}" value="{{ $address->zip }}" name="zip" required class="form-control inputCep">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Rua</label>
              <input type="text" name="street" required class="form-control" id="street" value="{{ $address->street }}">
          </div>

          <div class="form-group col-md-3"><label class="control-label">Numero</label>
              <input type="text" name="number" class="form-control" id="number" value="{{ $address->number }}">
          </div>

          <div class="form-group col-md-4"><label class="control-label">Bairro</label>
              <input type="text" name="district" required class="form-control" id="district" value="{{ $address->district }}">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Cidade</label>
              <input type="text" name="city" required class="form-control" id="city" value="{{ $address->city }}">
          </div>

          <div class="form-group col-md-2"><label class="control-label">Estado</label>
              <input type="text" name="state" required class="form-control" id="state" value="{{ $address->state }}">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Complemento</label>
              <input type="text" name="complement" class="form-control" id="complement" value="{{ $address->complement }}">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Referência</label>
              <input type="text" name="reference" class="form-control" id="reference" value="{{ $address->reference }}">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Longitude</label>
              <input type="text" name="long" class="form-control" id="long" value="{{ $address->long }}">
          </div>

          <div class="form-group col-md-6"><label class="control-label">Latitude</label>
              <input type="text" name="lat" class="form-control" id="lat" value="{{ $address->lat }}">
          </div>

          <div class="form-group col-md-6">
              <input class="js-switch" type="checkbox" name="is_default" id="is_default" value="1" {{ $address->is_default ? 'checked' : '' }}/>
              <label class="control-label">Endereço Principal</label>
          </div>

          </div>

          <button type="submit" class="btn btn-success btn-sm">Salvar</button>
          <a href="{{ route('clients.show', $client->uuid) }}" class="btn btn-danger btn-sm">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
