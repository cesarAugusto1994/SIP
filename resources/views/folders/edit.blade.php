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

        <form class="formValidation" method="post" action="{{route('folders.update', $folder->uuid)}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

              <div class="col-md-6">

                <div class="form-group">
                    <label class="col-form-label">Nome</label>
                    <div class="input-group">
                      <input type="text" required name="name" readonly value="{{ $folder->name }}" class="form-control">
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
                              <option value="{{$item->id ??''}}" {{ $folder->parent && $folder->parent->id == $item->id ? 'selected' : '' }}>
                                @if($item->parent)
                                    @if($item->parent->parent)
                                        @if($item->parent->parent->parent)
                                            @if($item->parent->parent->parent->parent)
                                                {{$item->parent->parent->parent->parent->name}} /
                                            @endif
                                            {{$item->parent->parent->parent->name}} /
                                        @endif
                                        {{$item->parent->parent->name}} /
                                    @endif
                                    {{$item->parent->name}} /
                                @endif
                                {{$item->name}}
                              </option>
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
