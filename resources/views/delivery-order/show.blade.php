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
                    <li class="breadcrumb-item"><a href="{{ route('delivery-order.index') }}">Ordem de Entrega</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Conferência</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Informações do Cliente e Documento</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">

                        <div class="view-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Cliente</th>
                                                                <td>{{ $order->client->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Telefone</th>
                                                                <td>{{ $order->client->phone }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>{{ $order->client->email }}</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- end of table col-lg-6 -->
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Data Agendamento</th>
                                                                <td>{{ $order->delivery_date }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Data Entrega</th>
                                                                <td>{{ $order->delivery_at ? $order->delivery_at->format('d/m/Y H:i') : '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Entregador</th>
                                                                <td><span id="entregador"><span class="text-navy">Selecione o Entregador</span></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- end of table col-lg-6 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of general info -->
                                </div>
                                <!-- end of col-lg-12 -->
                            </div>
                            <!-- end of row -->
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
              <div class="card">
                  <div class="card-header">
                      <h5>Endereço</h5>
                      <div class="card-header-right">
                          <ul class="list-unstyled card-option">
                              <li><i class="feather icon-maximize full-card"></i></li>
                          </ul>
                      </div>
                  </div>
                  <div class="card-block">

                    <div class="view-info">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="general-info">
                                    <div class="row">

                                      <div class="col-lg-12 col-xl-12">
                                          <div class="table-responsive">
                                              <table class="table m-0">
                                                  <tbody>
                                                      <tr>
                                                          <th scope="row">Rua </th>
                                                          <td>{{ $document->address->street }}, {{ $document->address->number }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Bairro</th>
                                                          <td>{{ $document->address->district }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Cidade</th>
                                                          <td>{{ $document->address->city }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">CEP</th>
                                                          <td>{{ $document->address->zip }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Complemento</th>
                                                          <td>{{ $document->address->complement }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Referencia</th>
                                                          <td>{{ $document->address->reference }}</td>
                                                      </tr>

                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>

                  </div>
              </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Documentos</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">

                      <div class="table-responsive">
                          @if($documents->isNotEmpty())
                          <table class="table table-hover">

                              <thead>
                                  <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Tipo</th>
                                    <th>Cliente</th>
                                    <th>Status</th>
                                    <th>Adicionado por</th>
                                    <th>Adicionado em</th>
                                    <th>Opções</th>
                                  </tr>
                              </thead>

                              <tbody>
                              @foreach($documents as $document)
                              <tr>
                                  <td>
                                      <a>{{$document->id}}</a>
                                  </td>

                                  <td>
                                      <a>{{ $document->description }}</a>
                                  </td>

                                  <td>
                                      <a>{{ $document->type->name ?? '-' }}</a>
                                  </td>

                                  <td>
                                      <p><a href="{{route('clients.edit', ['id' => $document->client->uuid])}}">{{ $document->client->name }}</a></p>
                                  </td>

                                  <td>
                                      <a>{{ $document->status->name }}</a>
                                  </td>

                                  <td>
                                      <p><a>{{ $document->creator->person->name }}</a></p>
                                  </td>

                                  <td>
                                      <p><a>{{ $document->created_at->format('d/m/Y H:i') }}</a></p>
                                  </td>

                                  <td class="dropdown">

                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                      @permission('edit.documentos')
                                        @if($document->status_id == 1)
                                            <a href="{{route('delivery_order_conference', ['document[]' => $document->uuid])}}" class="dropdown-item"><i class="fa fa-truck"></i> Entrega</a>
                                        @endif
                                      @endpermission
                                      @permission('edit.documentos')
                                        @if($document->status_id == 1)
                                        <a href="{{route('documents.edit', ['id' => $document->uuid])}}" class="dropdown-item"><i class="fa fa-edit"></i> Editar</a>
                                        @endif
                                      @endpermission
                                      @permission('delete.documentos')
                                        @if($document->status_id == 1)
                                        <a href="#!" data-route="{{route('documents.destroy', ['id' => $document->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fa fa-trash"></i> Remover</a>
                                        @endif
                                      @endpermission

                                    </div>

                                  </td>

                              </tr>
                              @endforeach
                              </tbody>
                          </table>

                          <div class="text-center">{{ $documents->links() }}</div>

                          @else

                              <div class="widget white-bg no-padding">
                                  <div class="p-m text-center">
                                      <h1 class="m-md"><i class="far fa-folder-open fa-3x"></i></h1>
                                      <h4 class="font-bold no-margins">
                                          Nenhum documento encontrado.
                                      </h4>
                                  </div>
                              </div>

                          @endif
                      </div>

                    </div>
                </div>
            </div>

  </div>

</div>

@endsection

@section('scripts')
    <script>

      $(document).ready(function() {

        let selectEntregador = $(".select-entregador");
        let entregador = $("#entregador");

        selectEntregador.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

          let self = $(this);
          let route = self.data('search-user');
          let value = self.val();

          $.ajax({
            type: 'GET',
            url: route + '?param=' + value,
            async: true,
            success: function(response) {

              if(response.success) {

                let result = response.data;

                entregador.html("");
                let html = result.name + " - " + result.cpf;
                entregador.append(html);
              }


            }
          })


        });

      });

    </script>
@stop
