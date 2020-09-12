@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Telefones do Cliente</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Novo Telefone</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Novo Telefone</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate action="{{ route('phones.store') }}" method="post">
            {{csrf_field()}}
            <div class="row">

              <input type="hidden" name="client_id" value="{{ $client->uuid }}"/>

              <div class="form-group col-md-12"><label class="control-label">Telefone</label>
                  <input type="text" required id="phone" name="phone" value="{{ old('phone') }}" class="form-control inputPhone" placeholder="Informe o Telefone">
              </div>

            </div>

            <button type="submit" class="btn btn-success btn-sm">Salvar</button>
            <a href="{{ route('clients.show', $client->uuid) }}" class="btn btn-danger btn-sm">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
