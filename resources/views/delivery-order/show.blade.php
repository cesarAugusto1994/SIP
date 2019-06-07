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
                    <li class="breadcrumb-item"><a href="#!">Informações</a>
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
            <div class="card-block">

              @permission('edit.documentos')
                <a href="{{route('print_tags', ['id' => $order->uuid])}}" target="_blank" class="btn btn-success btn-round btn-sm"> Imprimir Etiqueta </a>
              @endpermission

              @permission('edit.documentos')
                <a href="{{route('delivery-order.edit', ['id' => $order->uuid])}}" class="btn btn-primary btn-round btn-sm"> Editar </a>
              @endpermission

              @permission('delete.documentos')
                <a href="#!" data-route="{{route('documents.destroy', ['id' => $order->uuid])}}" class="btn btn-danger btn-round btn-sm"> Cancelar </a>
              @endpermission

            </div>

        </div>

      </div>

      <div class="col-lg-6">
          <div class="card">
              <div class="card-header">
                  <h5>Informações Gerais</h5>
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
                                          <div class="">
                                              <table class="table m-0">
                                                  <tbody>
                                                      <tr>
                                                          <th scope="row">Código</th>
                                                          <td>#{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Cadastro</th>
                                                          <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                                      </tr>
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

                                                      <tr>
                                                          <th scope="row">Situação</th>
                                                          <td><label class="label label-inverse-success">{{ $order->status->name ?? '-' }}</label></td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Data Agendamento</th>
                                                          <td>{{ $order->delivery_date ? $order->delivery_date : '-' }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Data Entrega</th>
                                                          <td>{{ $order->delivery_at ? $order->delivery_at->format('d/m/Y H:i') : '-' }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Entregador</th>
                                                          <td>{{ $order->user->person->name ?? '-' }}</td>
                                                      </tr>

                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
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

      <div class="col-lg-6">
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
                                                    <td>{{ $order->address->street }}, {{ $order->address->number }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Bairro</th>
                                                    <td>{{ $order->address->district }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Cidade</th>
                                                    <td>{{ $order->address->city }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">CEP</th>
                                                    <td>{{ $order->address->zip }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Complemento</th>
                                                    <td>{{ $order->address->complement }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Referencia</th>
                                                    <td>{{ $order->address->reference }}</td>
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
                    <table class="table table-hover">

                        <thead>
                            <tr>
                              <th>Tipo</th>
                              <th>Cliente</th>
                              <th>Funcionário</th>
                              <th>Status</th>
                              <th>Anotações</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($order->documents as $document)
                        @php
                          $document = $document->document;
                        @endphp
                        <tr>
                            <td>
                                <a>{{ $document->type->name ?? '-' }}</a>
                            </td>

                            <td>
                                <p><a href="{{route('clients.edit', ['id' => $order->client->uuid])}}">{{ $order->client->name }}</a></p>
                            </td>

                            <td>
                                <a>{{$document->employee->name ?? '-'}}</a>
                            </td>

                            <td>
                                <a>{{ $document->status->name }}</a>
                            </td>

                            <td>
                                <a>{{$document->annotations}}</a>
                            </td>

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
