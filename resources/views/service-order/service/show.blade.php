@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Serviços</h4>
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
                        <a href="{{ route('services.index') }}"> Serviços </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h5>Informações do Serviço</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><a href="{{route('services.edit', ['id' => $service->uuid])}}" class="btn btn-primary text-white btn-sm">Editar</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
              <h2>{{ $service->name}}</h2>
              <p>{{ $service->description}}</p>

              <p>
                @if($service->active)
                    <i class="fa fa-circle text-success"></i> Ativo
                @else
                    <i class="fa fa-circle text-danger"></i> Inativo
                @endif
              </p>

              @foreach($values as $value)
                  <p>{{ $value->contract->name }}: {{ number_format($value->value, 2) }}</p>
              @endforeach

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Tabela de Contratos</h5>
                <span>Listagem dos valores e custos do serviço por contrato.</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>Contrato</th>
                                <th>Custo</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($values as $value)
                              <tr>
                                  <th scope="row">{{ $value->contract->name }}</th>
                                  <td>{{ number_format($value->cost, 2) }}</td>
                                  <td>{{ number_format($value->value, 2) }}</td>
                              </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

  </div>

</div>

@endsection

@section('scripts')

<script></script>

@endsection
