@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Categoria de Chamados</h4>
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
                        <a href="{{ route('ticket-types.index') }}"> Categoria de Chamados </a>
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
          <h5>Nova Categoria de Chamado</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" method="post" action="{{route('ticket-type-categories.store')}}">
            @csrf

            <div class="row m-b-30">

              <div class="col-md-4">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" class="form-control">
                    </div>
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">
                    <label class="col-form-label">Ativo</label>
                    <div class="input-group">

                      <input class="js-switch" type="checkbox" value="" name="active" checked>

                    </div>
                </div>

              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('ticket-type-categories.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
