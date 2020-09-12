@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Modelos</h4>
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
                        <a href="{{ route('models.index') }}"> Modelos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Nova</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Novo Modelo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('models.store')}}">
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
                      <label class="col-form-label">Marca</label>
                      <div class="input-group">
                        <select class="form-control" name="brand_id" required>
                            @foreach(\App\Helpers\Helper::brands() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Ativo</label>
                      <div class="input-group">
                        <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" checked value="{{ 1 }}">
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('models.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
