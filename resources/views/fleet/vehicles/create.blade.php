@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cliente Veículos</h4>
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
                        <a href="{{ route('vehicles.index') }}"> Veículos </a>
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
          <h5>Novo Veículo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('vehicles.store')}}">
            {{csrf_field()}}

            <div class="row m-b-30">

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Nome</label>
                      <div class="input-group"><input type="text" name="name" class="form-control" autofocus required/></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Modelo</label>
                      <div class="input-group"><input type="text" name="model" class="form-control" required/></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Marca</label>
                      <div class="input-group"><input type="text" name="brand" class="form-control" required/></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Ano</label>
                      <div class="input-group">
                        <input type="number" maxlength="4" min="2000" value="2015" name="year" class="form-control" required/>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Comprado Em:</label>
                      <div class="input-group">
                        <input type="text" name="bought_at" class="form-control inputDate"/>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Ultima Manutenção</label>
                      <div class="input-group">
                        <input type="text" name="last_maintenance" class="form-control inputDate"/>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Situação</label>
                      <div class="input-group">
                        <select class="form-control" name="status_id" required>
                            @foreach(\App\Helpers\Helper::vehicleStatus() as $status)
                                <option value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group"><label class="col-form-label">Ativo</label>
                      <div class="input-group">
                        <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" checked value="{{ 1 }}">
                      </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group"><label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <textarea class="form-control" rows="4" name="description"></textarea>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('vehicles.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
