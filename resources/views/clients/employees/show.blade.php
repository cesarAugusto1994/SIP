@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Funcionários</h4>
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
                        <a href="{{ route('employees.index') }}"> Funcionários </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações do Funcionário</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('edit.cliente.funcionarios')
                    <a href="{{route('employees.edit', ['id' => $employee->uuid])}}" class="btn btn-primary text-white btn-sm">Editar</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h5>Informações do Funcionário</h5>
            </div>
            <div class="card-block">
              <h2>{{ $employee->name}} </h2>
              <p>
                @if($employee->active)
                    <i class="fa fa-circle text-success"></i> Ativo
                @else
                    <i class="fa fa-circle text-danger"></i> Inativo
                @endif

              </p>
              <p>E-mail: {{ $employee->email }}</p>
              <p>CPF: {{ $employee->cpf }}</p>
              <p>RG: {{ $employee->rg }}</p>
              <p>Empresa: <a href="{{route('clients.show', $employee->company->uuid)}}"><b>{{ $employee->company->name }}</b></a></p>
              <p>Função: {{ $employee->occupation->name }}</p>

            </div>
        </div>

    </div>

  </div>

</div>

@endsection

@section('scripts')

<script></script>

@endsection
