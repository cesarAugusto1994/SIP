@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Unidades</h4>
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
                        <a href="{{ route('units.index') }}"> Unidades </a>
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
          <h5>Editar Unidade</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('units.update', $unit->uuid)}}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row m-b-30">

                <div class="col-md-12">
                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" value="{{ $unit->name }}" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="col-form-label">Endereço</label>
                      <div class="input-group">
                        <input type="text" name="address" value="{{ $unit->address }}" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="col-form-label">Horário de Trabalho</label>
                      <div class="input-group">
                        <input type="text" name="workload" value="{{ $unit->workload }}" class="form-control">
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('units.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
