@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mural de Recados</h4>
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
                        <a href="{{ route('home') }}"> Mural de Recados </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo Recado</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card">
        <div class="card-header">
            <h5>Novo Recado</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="feather icon-maximize full-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block">

          <form method="post" action="{{ route('message-board.store') }}" enctype="multipart/form-data">

              {{ csrf_field() }}

              <div class="form-group row"><label class="col-sm-2 col-form-label">Departamento:</label>
                  <div class="col-sm-10">
                    <select class="select2" id="select-department" data-route="{{ route('departments_users_search') }}" name="departments[]" multiple="multiple" required>
                      <option value="0">Todos Departamentos</option>
                      @foreach($departments as $department)
                          <option value="{{ $department->id }}">{{ $department->name }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>

              <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Para:</label>
                  <div class="col-sm-10">
                    <select class="select2" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%" id="select-user" name="to[]" multiple="multiple">
                      <option value="0">Todos Usuários</option>
                    </select>
                  </div>
              </div>

              <div class="form-group row"><label class="col-sm-2 col-form-label">Tipo:</label>
                  <div class="col-sm-10">
                    <select class="select2" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%" name="type_id" required>
                      @foreach($types as $type)
                          <option value="{{ $type->id }}">{{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
              </div>

              <div class="form-group row"><label class="col-sm-2 col-form-label">Assunto:</label>
                  <div class="col-sm-10"><input required name="subject" type="text" class="form-control" value=""></div>
              </div>

              <div class="form-group row"><label class="col-sm-2 col-form-label">Anexos:</label>

                  <div class="col-sm-10">
                    <input name="files[]" data-buttonText="Selecionar Arquivos" data-dragdrop="true"  data-buttonName="btn-primary" data-badge="true" type="file" data-input="true" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*" class="filestyle" multiple/>
                  </div>

              </div>

              <div class="form-group row"><label class="col-sm-2 col-form-label">Importante:</label>
                  <div class="col-sm-10"><input name="important" type="checkbox" data-plugin="switchery" value=""></div>
              </div>

              <div class="form-group row">
                  <div class="col-sm-12">
                    <textarea class="form-control ckeditor" name="content"></textarea>
                  </div>
              </div>

              <div class="text-right">
                  <a href="{{ route('message-board.index') }}" class="btn btn-danger btn-sm"> Cancelar</a>
                  <button type="submit" class="btn btn-success btn-sm">Enviar</button>
              </div>

          </form>

        </div>
    </div>
</div>

@endsection
