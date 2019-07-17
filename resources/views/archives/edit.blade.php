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
                        <a href="{{ route('archives.index') }}"> Arquivos </a>
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
          <h5>Editar Informações do Arquivo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" method="post" action="{{route('archives.update', $archive->uuid)}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" value="{{$archive->filename }}" class="form-control">
                    </div>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Pasta</label>
                    <span class="text-danger">Altere este campo se tiver certeza, pois irá mover o arquivo.</span>
                    <div class="input-group">
                      <select class="form-control" name="folder_id" required>
                          <option value="">Informe a Pasta</option>
                          @foreach($folders as $folder)
                              <option value="{{$folder->id}}" {{ $folder->id == $archive->folder_id ? 'selected' : '' }}>{{$folder->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('folders.show', $folder->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
