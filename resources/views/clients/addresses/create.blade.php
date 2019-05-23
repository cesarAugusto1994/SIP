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
                        <a href="{{ route('clients.show', $client->uuid) }}"> Cliente: {{ $client->name }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo Endereço</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Novo Endereço</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form action="{{route('client_addresses_store', [$client->uuid])}}" method="post">
            {{csrf_field()}}
            <div class="row">

            <input type="hidden" name="client_id" value="{{ $client->uuid }}"/>

            <div class="form-group col-md-12"><label class="control-label">Descrição</label>
                <input type="text" name="description" required class="form-control" id="description" placeholder="Ex: Matriz">
            </div>

            <div class="form-group col-md-3"><label class="control-label">CEP</label>
                <input type="text" data-cep="{{ route('cep') }}" name="zip" required class="form-control inputCep">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Rua</label>
                <input type="text" name="street" required class="form-control" id="street">
            </div>

            <div class="form-group col-md-3"><label class="control-label">Numero</label>
                <input type="text" name="number" class="form-control" id="number">
            </div>

            <div class="form-group col-md-4"><label class="control-label">Bairro</label>
                <input type="text" name="district" required class="form-control" id="district">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Cidade</label>
                <input type="text" name="city" required class="form-control" id="city">
            </div>

            <div class="form-group col-md-2"><label class="control-label">Estado</label>
                <input type="text" name="state" required class="form-control" id="state">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Complemento</label>
                <input type="text" name="complement" class="form-control" id="complement">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Referência</label>
                <input type="text" name="reference" class="form-control" id="reference">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Longitude</label>
                <input type="text" name="long" class="form-control" id="long">
            </div>

            <div class="form-group col-md-6"><label class="control-label">Latitude</label>
                <input type="text" name="lat" class="form-control" id="lat">
            </div>

            <div class="form-group col-md-6">
                <input type="checkbox" name="is_default" id="is_default" value="1"/>
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
