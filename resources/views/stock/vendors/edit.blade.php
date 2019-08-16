@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Fornecedores</h4>
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
                        <a href="{{ route('vendors.index') }}"> Fornecedores </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Novo Fornecedor</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('vendors.update', $vendor->uuid)}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" class="form-control" value="{{ $vendor->name }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Telefone</label>
                      <div class="input-group">
                        <input type="text" name="phone" class="form-control inputPhone" value="{{ $vendor->phone }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">E-mail</label>
                      <div class="input-group">
                        <input type="email" name="email" class="form-control" value="{{ $vendor->email }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Ativo</label>
                      <div class="input-group">
                        <input class="js-switch" type="checkbox" id="active" name="active" {{ $vendor->active ? 'checked' : '' }} data-plugin="switchery" value="{{ 1 }}">
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('vendors.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
