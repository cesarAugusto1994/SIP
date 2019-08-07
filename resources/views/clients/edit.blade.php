@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Clientes</h4>
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
                        <a href="{{ route('clients.index') }}"> Clientes</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar Cliente</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Editar Cliente</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('clients.update', $client->uuid)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">

                    <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="name">Nome</label>
                        <div class="input-group">
                            <input type="text" required id="name" name="name" value="{{ $client->name }}" class="form-control" placeholder="Informe o nome">
                        </div>
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('document') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="document">CPF/CNPJ</label>
                        <div class="input-group">
                            <input type="text" required id="document" name="document"  value="{{ $client->document }}" class="form-control" placeholder="Informe o CPF ou CNPJ">
                        </div>
                        {!! $errors->first('document', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('contract_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="document">Contrato</label>
                        <div class="input-group">
                          <select class="form-control" name="contract_id">
                              @foreach(\App\Helpers\Helper::contracts() as $contract)
                                  <option value="{{$contract->id}}" {{ $contract->id == $client->contract_id ? 'selected' : '' }}>{{$contract->name}}</option>
                              @endforeach
                          </select>
                        </div>
                        {!! $errors->first('contract_id', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-4">

                  <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="active">Ativo</label>
                      <div class="input-group">
                          <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" {{ $client->active ? 'checked' : '' }} value="{{ 1 }}">
                      </div>
                      {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                  </div>

                </div>

                <div class="col-md-4">
                  <div class="form-group {!! $errors->has('charge_delivery') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="charge_delivery">Cobrar Entrega</label>
                      <div class="input-group">
                          <input class="js-switch" type="checkbox" id="charge_delivery" name="charge_delivery" data-plugin="switchery" {{ $client->charge_delivery ? 'checked' : '' }} value="{{ 1 }}">
                      </div>
                      {!! $errors->first('charge_delivery', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('clients.show', $client->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
