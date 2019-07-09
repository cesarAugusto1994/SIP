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
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><i class="feather icon-maximize full-card"></i></li>
              </ul>
          </div>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('clients.update', $client->uuid)}}">
            {{csrf_field()}}
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="name">Nome</label>
                        <div class="input-group">
                            <input type="text" id="name" name="name" value="{{ $client->name }}" class="form-control" placeholder="Informe o nome">
                        </div>
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('phone') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="phone">Telefone</label>
                        <div class="input-group">
                            <input type="text" id="phone" name="phone" value="{{ $client->phone }}" class="form-control" placeholder="Informe o Telefone">
                        </div>
                        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('document') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="document">CPF/CNPJ</label>
                        <div class="input-group">
                            <input type="text" id="document" name="document"  value="{{ $client->document }}" class="form-control" placeholder="Informe o CPF ou CNPJ">
                        </div>
                        {!! $errors->first('document', '<p class="help-block">:message</p>') !!}
                    </div>
                    <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="active">Ativo</label>
                        <div class="input-group">
                            <input type="checkbox" id="active" name="active" data-plugin="switchery" {{ $client->active ? 'checked' : '' }} value="{{ 1 }}">
                        </div>
                        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="email">Email</label>
                        <div class="input-group">
                            <input type="text" id="email" name="email"  value="{{ $client->email }}" class="form-control" placeholder="Informe o email">
                        </div>
                        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
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
