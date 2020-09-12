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
                              <option value="{{$folder->id ??''}}" {{ $folder->uuid == \Request::get('parent_folder_id') ? 'selected' : '' }}>
                                @if($folder->parent)
                                    @if($folder->parent->parent)
                                        @if($folder->parent->parent->parent)
                                            @if($folder->parent->parent->parent->parent)
                                                {{$folder->parent->parent->parent->parent->name}} /
                                            @endif
                                            {{$folder->parent->parent->parent->name}} /
                                        @endif
                                        {{$folder->parent->parent->name}} /
                                    @endif
                                    {{$folder->parent->name}} /
                                @endif
                                {{$folder->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

              <div class="col-md-12">

                <div class="form-group">
                    <label class="col-form-label">Grupos de Acesso</label>
                    <span class="text-danger">Informe os grupos de usuários que terão acesso à pasta.</span>
                    <div class="input-group">
                      <select class="form-control m-b select2" multiple name="departments[]" required>
                          @foreach($departments as $department)
                              <option value="{{$department->id}}">{{$department->name}}</option>
                          @endforeach
                      </select>

                    </div>
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('edit') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Alterar</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="edit" class="js-switch">
                    </div>
                    {!! $errors->first('edit', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('share') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Compartilhar</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="share" class="js-switch">
                    </div>
                    {!! $errors->first('share', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('download') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Baixar</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="download" class="js-switch">
                    </div>
                    {!! $errors->first('download', '<p class="help-block">:message</p>') !!}
                </div>

              </div>

              <div class="col-md-3">

                <div class="form-group {!! $errors->has('delete') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Remover</label>
                    <div class="input-group">
                      <input type="checkbox" data-plugin="switchery" data-switchery="true" value="1" name="delete" class="js-switch">
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
