@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Chamados</h4>
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
                        <a href="{{ route('departments.index') }}"> Chamados </a>
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
          <h5>Novo Chamado</h5>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('tickets.store')}}">
            @csrf

            <div class="row m-b-30">

              <div class="col-md-4">

                <div class="form-group">
                    <label class="col-form-label">Tipo</label>
                    <div class="input-group">
                      <select class="form-control m-b" name="type_id" required>
                          <option value="">Informe o tipo de chamado</option>
                          @foreach(\App\Helpers\Helper::ticketTypes() as $type)
                              <option value="{{$type->id}}">{{$type->name}}</option>
                          @endforeach
                      </select>
                    </div>
                </div>

              </div>

              <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label">Descrição</label>
                    <div class="input-group">
                      <textarea required name="description" class="form-control ckeditor"></textarea>
                    </div>
                </div>

              </div>


            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('departments.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
