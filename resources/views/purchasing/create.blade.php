@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordens de Compra</h4>
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
                        <a href="{{ route('purchasing.index') }}"> Ordens de Compra </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Nova Solicitação</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Nova Solicitação</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('purchasing.store')}}" data-parsley-validate>
            @csrf

            <div class="row m-b-30">

              <div class="col-md-6">
                <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Motivo</label>
                    <div class="input-group">
                      <textarea type="text" required name="description" id="description" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control">{{ old('description') }}</textarea>

                    </div>
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
              </div>


              <div class="col-md-6">
                <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Observações</label>
                    <div class="input-group">
                      <textarea type="text" required name="description" id="description" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control">{{ old('description') }}</textarea>

                    </div>
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

              <div class="col-md-12">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Quantidade</th>
                                <th>Unidade</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary waves-effect waves-light add" onclick="add_row();">Add Row</button>
              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a href="{{route('tasks.index')}}" class="btn btn-danger btn-sm">Cancelar</a>
        </form>

      </div>
  </div>
</div>

@endsection

@push('scripts')

<script type="text/javascript" src="{{ asset('adminty\pages\edit-table\jquery.tabledit.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\pages\edit-table\editable.js') }}"></script>

@endpush
