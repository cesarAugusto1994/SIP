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
          <h5>Nova Ativo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('products.store')}}">
            @csrf

            <div class="row m-b-30">

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <input type="text" name="description" class="form-control">
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
                                <option value="{{$item->id}}">{{$item->name}}</option>
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
                                <option value="{{$item->id}}">{{$item->name}}</option>
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
                                <option value="{{$item->id}}">{{$item->name}}</option>
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
                                <option value="years">Anos(s)</option>
                                <option value="months">Mes(es)</option>
                                <option value="days">Dia(s)</option>
                            </select>
                          </div>
                      </div>

                    </div>

                    <div class="col-md-5">

                      <div class="form-group">
                          <label class="col-form-label">Periodo</label>
                          <div class="input-group">
                            <input type="number" name="lifetime" min="1" max="365" class="form-control">
                          </div>
                      </div>

                    </div>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Estoque Minimo</label>
                      <div class="input-group">
                        <input type="number" name="min_stock" min="1" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Estoque Máximo</label>
                      <div class="input-group">
                        <input type="number" name="max_stock" min="1" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Estoque Atual</label>
                      <div class="input-group">
                        <input type="number" name="actual_stock" min="1" required class="form-control">
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
