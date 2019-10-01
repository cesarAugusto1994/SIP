@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Serviços</h4>
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
                        <a href="{{ route('services.index') }}"> Serviços </a>
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
          <h5>Novo Serviço</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('services.store')}}">
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
                      <label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <input type="text" name="description" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Tipo</label>
                      <div class="input-group">
                        <select class="form-control select2" name="service_type_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::serviceTypes() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                @foreach(\App\Helpers\Helper::contracts() as $contract)

                  <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><b>Custo</b> {{ $contract->name }} </label>
                        <div class="input-group">
                          <input type="text" autocomplete="off" name="cost-{{ $contract->uuid }}" class="form-control inputMoney">
                        </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><b>Valor</b> {{ $contract->name }} </label>
                        <div class="input-group">
                          <input type="text" autocomplete="off" name="value-{{ $contract->uuid }}" class="form-control inputMoney">
                        </div>
                    </div>
                  </div>

                @endforeach

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('services.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
