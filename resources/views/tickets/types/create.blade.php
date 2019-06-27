@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Chamados</h4>
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
                        <a href="{{ route('ticket-types.index') }}"> Tipos de Chamados </a>
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
          <h5>Novo Tipo de Chamado</h5>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('ticket-types.store')}}">
            @csrf

            <div class="row m-b-30">

              <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" class="form-control">
                    </div>
                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label">Departamentos</label>
                    <div class="input-group">
                      <select class="form-control m-b select2" multiple name="departments[]" required>
                          <option value="">Informe o departamento</option>
                          @foreach(\App\Helpers\Helper::departments() as $department)
                              <option value="{{$department->id}}">{{$department->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label">Ativo</label>
                    <div class="input-group">

                      <div class="checkbox-fade fade-in-primary d-">
                          <label>
                              <input type="checkbox" value="" name="active" checked>
                              <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>

                          </label>
                      </div>

                    </div>
                </div>

              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('ticket-types.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
