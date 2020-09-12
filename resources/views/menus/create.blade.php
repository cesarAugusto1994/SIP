@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Menus</h4>
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
                        <a href="{{ route('menus.index') }}"> Menus </a>
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
          <h5>Adicionar Menu</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" enctype="multipart/form-data" action="{{route('menus.store')}}">
            @csrf
            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Titulo</label>
                      <div class="input-group">
                        <input type="text" required name="title" class="form-control">
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
                      <label class="col-form-label">Rota</label>
                      <div class="input-group">
                        <input type="text" name="route" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Permissão</label>
                      <div class="input-group">
                        <select class="form-control select2" name="permission" required>
                            @foreach($permissions as $permission)
                                <option value="{{$permission->slug}}">{{$permission->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Pai</label>
                      <div class="input-group">
                        <select class="form-control select2" name="parent">
                            <option value="">Sem Ancoragem</option>
                            @foreach($menus as $item)
                                <option value="{{$item->id}}">{{$item->title}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Icone</label>
                      <div class="input-group">
                        <input type="text" required name="icon" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">

                  <div class="form-group">
                      <label class="col-form-label">Ordem</label>
                      <div class="input-group">
                        <input type="number" min="1" autocomplete="off" max="1000" maxlength="4" required name="order" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">
                  <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="active">Ativo</label>
                      <div class="input-group">
                          <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" value="{{ 1 }}">
                      </div>
                      {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
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
