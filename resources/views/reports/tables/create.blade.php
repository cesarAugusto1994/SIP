@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tabelas</h4>
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
                        <a href="{{ route('menus.index') }}"> Tabelas </a>
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
          <h5>Adicionar Tabela</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('tables.store')}}">
            @csrf
            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Tabela</label>
                      <div class="input-group">
                        <select class="form-control select2" name="name" required>
                            @foreach($tables as $table)
                                <option value="{{$table['name']}}">{{$table['name']}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="label" class="form-control">
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

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('menus.index') }}">Cancelar</a>

        </form>

      </div>
  </div>

</div>

@endsection
