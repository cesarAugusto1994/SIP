@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cliente Cargo</h4>
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
                        <a href="{{ route('client-occupations.index') }}"> Cargos </a>
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
          <h5>Editar Cargo</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('client-occupations.update', $occupation->uuid)}}">
            @csrf
            {{method_field('PUT')}}

            <div class="row m-b-30">

                <div class="col-md-4">

                  <div class="form-group"><label class="col-form-label">Nome</label>
                      <div class="input-group"><input type="text" name="name" value="{{ $occupation->name }}" class="form-control" autofocus required/></div>
                  </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group {!! $errors->has('company_id') ? 'has-error' : '' !!}">
                        <label class="col-form-label" for="company_id">Empresa</label>
                        <div class="input-group">

                            <select class="form-control select-client" name="company_id" required>
                                <option value="{{$occupation->company->uuid}}">{{$occupation->company->name}}</option>
                            </select>

                        </div>
                        {!! $errors->first('company_id', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>

            </div>



            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('client-occupations.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
