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
                        <a href="{{ route('products.show', $stock->product->uuid) }}"> Detalhes </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar Item</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Item </h5>
          <span class="text-success">#{{ $stock->product->id }} - {{ $stock->product->name }}<span>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('stock.update', $stock->uuid)}}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Maticula de Patrimônio</label>
                      <div class="input-group">
                        <input type="number" name="equity_registration_code" class="form-control" value="{{ $stock->equity_registration_code }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Número de Série</label>
                      <div class="input-group">
                        <input type="number" name="serial" class="form-control" value="{{ $stock->serial }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Comprado Em</label>
                      <div class="input-group">
                        <input type="text" name="buyed_at" class="form-control inputDate" value="{{ $stock->buyed_at ? $stock->buyed_at->format('d/m/Y') : '' }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Situação</label>
                      <div class="input-group">
                        <select class="form-control" required name="status">
                            <option value="">Selecione a situação</option>
                            @foreach(\App\Helpers\Helper::stockStatus() as $item)
                                <option value="{{ $item }}" {{ $stock->status == $item ? 'selected' : '' }}>{{ $item }}</option>
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
                                <option value="{{ $item }}" {{ $stock->localization == $item ? 'selected' : '' }}>{{ $item }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-user" @if($stock->localization == 'Usuário')  @else style="display:none;" @endif>
                  <div class="form-group">
                      <label class="col-form-label">Usuário:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="user_id" required>
                            @foreach(\App\Helpers\Helper::users() as $user)
                                <option value="{{$user->id}}" {{ $stock->user_id == $user->id ? 'selected' : '' }}>{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-department" @if($stock->localization == 'Departamento')  @else style="display:none;" @endif>
                  <div class="form-group">
                      <label class="col-form-label">Departamento:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="department_id" required>
                            @foreach(\App\Helpers\Helper::departments() as $item)
                                <option value="{{$item->id}}" {{ $stock->department_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-unit" @if($stock->localization == 'Unidade')  @else style="display:none;" @endif>
                  <div class="form-group">
                      <label class="col-form-label">Unidade:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="unity_id" required>
                            @foreach(\App\Helpers\Helper::units() as $item)
                                <option value="{{$item->id}}" {{ $stock->unity_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4" id="div-vendor" @if($stock->localization == 'Fornecedor')  @else style="display:none;" @endif>
                  <div class="form-group">
                      <label class="col-form-label">Fornecedor:</label>
                      <div class="input-group">
                        <select class="form-control" data-style="btn-white" name="vendor_id">
                            @foreach(\App\Helpers\Helper::vendors() as $item)
                                <option value="{{$item->id}}" {{ $stock->vendor_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('products.show', $stock->product->uuid) }}">Cancelar</a>

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
