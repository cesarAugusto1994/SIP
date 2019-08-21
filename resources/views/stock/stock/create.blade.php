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
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.show', $product->uuid) }}"> Detalhes </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo Item</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Novo Item </h5>
          <span class="text-success">#{{ $product->id }} - {{ $product->name }}<span>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('stock.store')}}">
            @csrf

            <input type="hidden" name="product_id" value="{{ request()->get('product_id') }}">

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Maticula de Patrimônio</label>
                      <div class="input-group">
                        <input type="number" name="equity_registration_code" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Número de Série</label>
                      <div class="input-group">
                        <input type="number" name="serial" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Comprado Em</label>
                      <div class="input-group">
                        <input type="text" name="buyed_at" class="form-control inputDate">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Situação</label>
                      <div class="input-group">
                        <select class="form-control" required>
                            <option value="">Selecione a situação</option>
                            @foreach(\App\Helpers\Helper::stockStatus() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Em posse de:</label>
                      <div class="input-group">
                        <select class="form-control" id="select-owner" name="localization" required>
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::stockLocalization() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-user" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Usuário:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="user_id" required>
                            @foreach(\App\Helpers\Helper::users() as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-department" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Departmaneto:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="department_id" required>
                            @foreach(\App\Helpers\Helper::departments() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-unit" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Unidade:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="unity_id" required>
                            @foreach(\App\Helpers\Helper::units() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-vendor" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Fornecedor:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="vendor_id">
                            @foreach(\App\Helpers\Helper::vendors() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('products.show', $product->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection

@section('scripts')

<script>

	$(document).ready(function() {

    var owner = $("#select-owner");

    var divUser = $("#div-user");
    var divDepartment = $("#div-department");
    var divUnit = $("#div-unit");
    var divVendor = $("#div-vendor");

    owner.change(function() {

      var self = $(this);
      var value = self.val();

      divUser.hide();
      divDepartment.hide();
      divUnit.hide();
      divVendor.hide();

      if(value == 'Usuário') {

          divUser.show();

      } else if(value == 'Departamento') {

          divDepartment.show();

      } else if(value == 'Unidade') {

          divUnit.show();

      } else if(value == 'Fornecedor') {

          divVendor.show();

      }

    });


  });

</script>

@endsection
