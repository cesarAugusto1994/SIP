@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ativos</h4>
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
                        <a href="{{ route('products.index') }}"> Ativos </a>
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
          <h5>Editar Ativo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('products.update', $product->uuid)}}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" class="form-control" value="{{ $product->name }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <input type="text" name="description" class="form-control" value="{{ $product->description }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Tipo</label>
                      <div class="input-group">
                        <select class="form-control select2" name="type_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::productTypes() as $item)
                                <option value="{{$item->id}}" {{ $product->type_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Fornecedor</label>
                      <div class="input-group">
                        <select class="form-control" name="vendor_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::vendors() as $item)
                                <option value="{{$item->id}}" {{ $product->vendor_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Marca</label>
                      <div class="input-group">
                        <select class="form-control" name="brand_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::brands() as $item)
                                <option value="{{$item->id}}" {{ $product->brand_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Modelo</label>
                      <div class="input-group">
                        <select class="form-control" name="model_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::models() as $item)
                                <option value="{{$item->id}}" {{ $product->model_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">

                  <div class="row">

                    <div class="col-md-7">

                      <div class="form-group">
                          <label class="col-form-label">Vida útil</label>
                          <div class="input-group">
                            <select class="form-control" name="lifetime_type">
                                <option value="">Selecione</option>
                                <option value="years" {{ $product->lifetime_type == 'years' ? 'selected' : '' }}>Anos(s)</option>
                                <option value="months" {{ $product->lifetime_type == 'months' ? 'selected' : '' }}>Mes(es)</option>
                                <option value="days" {{ $product->lifetime_type == 'days' ? 'selected' : '' }}>Dia(s)</option>
                            </select>
                          </div>
                      </div>

                    </div>

                    <div class="col-md-5">

                      <div class="form-group">
                          <label class="col-form-label">Periodo</label>
                          <div class="input-group">
                            <input type="number" name="lifetime" min="1" max="365" class="form-control" value="{{ $product->lifetime }}">
                          </div>
                      </div>

                    </div>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Estoque Minimo</label>
                      <div class="input-group">
                        <input type="number" name="min_stock" min="1" class="form-control" value="{{ $product->min_stock }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Estoque Máximo</label>
                      <div class="input-group">
                        <input type="number" name="max_stock" min="1" class="form-control" value="{{ $product->max_stock }}">
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('products.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
