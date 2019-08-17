@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Pedidos de Compra</h4>
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
                        <a href="{{ route('purchasing.index') }}"> Pedidos de Compra </a>
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
          <h5>Editar Ordem de Compra</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" method="post" action="{{route('purchasing.update', $purchasing->uuid)}}" data-parsley-validate>
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

              <div class="col-md-12">
                <div class="form-group {!! $errors->has('motive') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Motivo</label>
                    <div class="input-group">
                      <textarea type="text" required name="motive" id="motive" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control">{{ $purchasing->motive }}</textarea>

                    </div>
                    {!! $errors->first('motive', '<p class="help-block">:message</p>') !!}
                </div>
              </div>


              <div class="col-md-12">
                <div class="form-group {!! $errors->has('observations') ? 'has-error' : '' !!}">
                    <label class="col-form-label">Observações</label>
                    <div class="input-group">
                      <textarea type="text" required name="observations" id="observations" rows="3"
                             placeholder="Descreva a tarefa e informações relevantes." class="form-control">{{ $purchasing->observations }}</textarea>

                    </div>
                    {!! $errors->first('observations', '<p class="help-block">:message</p>') !!}
                </div>
              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a href="{{route('purchasing.index')}}" class="btn btn-danger btn-sm">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

  </script>

@endsection
