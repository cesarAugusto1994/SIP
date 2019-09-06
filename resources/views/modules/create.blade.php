@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Módulos</h4>
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
                        <a href="{{ route('modules.index') }}"> Módulos </a>
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
          <h5>Adicionar Módulo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" enctype="multipart/form-data" action="{{route('modules.store')}}">
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
                        <input type="text" required name="description" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Pai</label>
                      <div class="input-group">
                        <select class="form-control select2" name="parent" required>
                            <option value="1">Módulos</option>
                            @foreach($modules as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                <div class="col-md-3">

                  <div class="form-group">
                      <label class="col-form-label">Visualizar</label>
                      <div class="input-group">

                        <div class="checkbox-fade fade-in-primary d-">
                            <label>
                                <input type="checkbox" value="" name="show" checked>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>

                            </label>
                        </div>

                      </div>
                  </div>

                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Adicionar</label>
                      <div class="input-group">
                        <div class="checkbox-fade fade-in-primary d-">
                            <label>
                                <input type="checkbox" value="" name="create" checked>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            </label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Editar</label>
                      <div class="input-group">
                        <div class="checkbox-fade fade-in-primary d-">
                            <label>
                                <input type="checkbox" value="" name="edit" checked>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            </label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Remover</label>
                      <div class="input-group">
                        <div class="checkbox-fade fade-in-primary d-">
                            <label>
                                <input type="checkbox" value="" name="delete" checked>
                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            </label>
                        </div>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('modules.index') }}">Cancelar</a>

        </form>

      </div>
  </div>

</div>

@endsection
