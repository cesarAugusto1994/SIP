@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Documentos</h4>
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
                        <a href="{{ route('types.index') }}"> Tipos de Documentos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!"> Editar </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Tipos de Documentos</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('types.update', $type->uuid)}}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}"><label class="col-form-label">Nome</label>
                      <div class="input-group">
                          <input type="text" required name="name" value="{{ $type->name }}" class="form-control"/>
                          {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group {!! $errors->has('price') ? 'has-error' : '' !!}"><label class="col-form-label">Valor Cobrado (R$)</label>
                      <div class="input-group">
                          <input type="text" name="price" value="{{ number_format($type->price, 2, '.', ',') }}" class="form-control inputMoney"/>
                          {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                      </div>
                  </div>

                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('types.index') }}">Cancelar</a>
        </form>

      </div>
  </div>
</div>

@endsection
