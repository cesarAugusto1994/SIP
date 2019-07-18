@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Porta Arquivos</h4>
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
                        <a href="{{ route('folders.index') }}"> Pastas </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar Pasta</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Pasta</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('folders.store')}}">
            @csrf

            <div class="row m-b-30">

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" value="{{ $folder->name }}" class="form-control">
                    </div>
                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Pasta</label>
                    <div class="input-group">
                      <select class="form-control" name="folder_id">
                          <option value="">\</option>
                          @foreach($folders as $item)
                              @if($item->id == $folder->id)
                                  @continue;
                              @endif
                              <option value="{{$item->id ??''}}" {{ $item->parent_id == $folder->id ? 'selected' : '' }}>{{$item->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('read') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Leitura</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" {{ $folder->read ? 'checked' : '' }} data-switchery="true" value="1" name="read" class="js-switch">
                    </div>
                    {!! $errors->first('read', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('edit') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Alterar</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" {{ $folder->edit ? 'checked' : '' }} data-switchery="true" value="1" name="edit" class="js-switch">
                    </div>
                    {!! $errors->first('edit', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('share') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Compartilhar</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" {{ $folder->share ? 'checked' : '' }} data-switchery="true" value="1" name="share" class="js-switch">
                    </div>
                    {!! $errors->first('share', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('delete') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Remover</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" {{ $folder->delete ? 'checked' : '' }} data-switchery="true" value="1" name="delete" class="js-switch">
                    </div>
                    {!! $errors->first('delete', '<p class="help-block">:message</p>') !!}
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
