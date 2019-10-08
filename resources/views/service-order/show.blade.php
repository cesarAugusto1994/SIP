@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Serviço</h4>
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
                        <a href="{{ route('service-order.index') }}"> Ordem de Serviço </a>
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
                <h5>Informações da Ordem de Serviço</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><a href="{{route('service-order.edit', ['id' => $order->uuid])}}" class="btn btn-primary text-white btn-sm">Editar</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
              <h2>#{{ str_pad($order->id, 6, "0", STR_PAD_LEFT) }}</h2>
              <p>Cliente: {{ $order->client->name}}</p>
              <p>Contrato: {{ $order->contract->name}}</p>
              <p>Situação: {{ $order->status->name}}</p>

            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Tabela de Serviços</h5>
                <span>Listagem dos valores e custos do serviço por contrato.</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>Serviço</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>

                          @foreach($order->services as $service)
                            @foreach($service->service->values->where('contract_id', $order->contract_id) as $value)
                              <tr>
                                  <th scope="row"><a href="{{ route('services.show', $service->service->uuid) }}">{{ $service->service->name }}</a></th>
                                  <td>{{ number_format($value->value, 2, ',', '.') }}</td>
                              </tr>
                            @endforeach
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
