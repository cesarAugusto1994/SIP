@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ordem de Entrega</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">



  <div class="card">
      <div class="card-header">
          <h5>OEs</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.documentos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('delivery-order.create')}}">Novo</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="table-responsive">
            @if($orders->isNotEmpty())
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Cliente</th>
                      <th>Status</th>
                      <th>Entregador</th>
                      <th>Adicionado em</th>
                      <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders->sortByDesc('id') as $order)
                <tr>
                    <td>
                        <a href="{{route('delivery-order.show', ['id' => $order->uuid])}}">#{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}</a>
                    </td>

                    <td>
                        <a href="{{ route('clients.show', $order->client->uuid) }}"><b>{{ $order->client->name }}</b></a>
                        <br/>
                        <label class="label label-inverse-primary">{{$order->address->street}}, {{$order->address->number}} - {{$order->address->district}}, {{$order->address->city}}</label>
                    </td>

                    <td>
                        <label class="label label-inverse-success">{{ $order->status->name }}</label>
                    </td>

                    <td>
                        {{ $order->user->person->name }}
                    </td>

                    <td>
                        {{ $order->created_at->format('d/m/Y H:i') }}
                        <br/>
                        <label class="label label-inverse-danger">{{ $order->created_at->diffForHumans() }}</label>
                    </td>

                    <td class="dropdown">

                      <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                      <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                        @permission('edit.documentos')
                          <a href="{{route('delivery-order.show', ['id' => $order->uuid])}}" class="dropdown-item"> Visualizar </a>
                        @endpermission

                        @permission('edit.documentos')
                          <a href="{{route('print_tags', ['id' => $order->uuid])}}" target="_blank" class="dropdown-item"> Imprimir Etiqueta </a>
                        @endpermission

                        @permission('edit.documentos')
                          <a href="{{route('delivery-order.edit', ['id' => $order->uuid])}}" class="dropdown-item"> Editar </a>
                        @endpermission

                        @permission('delete.documentos')
                          <a href="#!" data-route="{{route('documents.destroy', ['id' => $order->uuid])}}" class="dropdown-item text-danger btnRemoveItem"> Cancelar </a>
                        @endpermission

                      </div>

                    </td>

                </tr>
                @endforeach
                </tbody>
            </table>
            @else

                <div class="widget white-bg no-padding">
                    <div class="p-m text-center">
                        <h1 class="m-md"><i class="far fa-bell-slash fa-2x"></i></h1>
                        <br/>
                        <h4 class="font-bold no-margins">
                            Nenhuma ordem de entrega foi registrada até o momento.
                        </h4>
                    </div>
                </div>

            @endif
        </div>

      </div>
  </div>
</div>

@endsection
