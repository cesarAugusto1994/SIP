@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Arquivos</h4>
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
                        <a href="{{ route('folders.index') }}"> Arquivos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Nova Pasta</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Nova Pasta</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('folders.store')}}">
            @csrf

            <div class="row m-b-30">

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" class="form-control">
                    </div>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Pasta</label>
                    <div class="input-group">
                      <select class="form-control" name="folder_id">
                          <option value="">\</option>
                          @foreach($folders as $folder)
                              <option value="{{$folder->id ??''}}" {{ $folder->uuid == \Request::get('parent_folder_id') ? 'selected' : '' }}>{{$folder->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('folders.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
