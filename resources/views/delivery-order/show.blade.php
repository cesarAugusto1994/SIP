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

              @permission('view.ordem.entrega')
                <a href="{{route('print_tags', ['id' => $order->uuid])}}" target="_blank" class="btn btn-primary btn-sm"> Imprimir Etiqueta </a>
              @endpermission

              @if($order->status_id == 1 || $order->status_id == 2 || $order->status_id == 10)
                @permission('view.ordem.entrega')
                  <a href="{{ route('start_delivery_client', $order->uuid) }}" class="btn btn-primary btn-sm"> Retirada Pelo Cliente </a>
                @endpermission
              @endif

              @if($order->status_id == 1)
                @permission('view.ordem.entrega')
                  <a href="{{route('start_delivery', $order->uuid)}}" class="btn btn-primary btn-sm"> Iniciar Entrega </a>
                @endpermission
              @endif

              @if($order->status_id == 2)
                @permission('view.ordem.entrega')
                  <a href="{{route('start_delivery', $order->uuid)}}" class="btn btn-primary btn-sm"> Realizar Entrega </a>
                @endpermission
              @endif

              @if($order->status_id == 3 || $order->status_id == 5)
                @permission('view.ordem.entrega')
                  <a href="{{route('start_delivery', $order->uuid)}}" target="_blank" class="btn btn-primary btn-sm"> Ver Comprovante </a>
                @endpermission
              @endif

              @if($order->status_id == 3)
                  @permission('edit.ordem.entrega')
                    <a data-route="{{route('delivery_confirm', $order->uuid)}}" class="btn btn-primary text-white btn-sm btnConfirm"> Finalizar </a>
                  @endpermission
              @endif


              @if($order->status_id == 1 || $order->status_id == 2)

                  @permission('edit.ordem.entrega')
                    <a href="{{route('delivery-order.edit', ['id' => $order->uuid])}}" class="btn btn-info btn-sm"> Editar </a>
                  @endpermission

                  @permission('delete.ordem.entrega')
                    <a data-route="{{route('delivery_cancel', $order->uuid)}}" class="btn btn-danger text-white btn-sm btnCancel"> Cancelar </a>
                  @endpermission

              @endif

            </div>
        </div>

        @if($order->status_id == 4)

            <div class="card text-center text-white bg-c-pink">
                <div class="card-block text-center">
                  <h4>Ordem de Entrega Cancelada.</h4>
                </div>
            </div>

        @endif

        @if($order->status_id == 5)

            <div class="card text-center text-white bg-c-green">
                <div class="card-block text-center">
                  <h4>Ordem de Entrega Finalizada.</h4>
                </div>
            </div>

        @endif

      </div>

      @if($order->shipment)
        <div class="col-lg-12">
          <div class="alert alert-primary background-primary">
              <strong>Atenção!</strong> Esta é uma Remessa de Entrega.
          </div>
        </div>
      @endif

      <div class="col-lg-6">
          <div class="card">
              <div class="card-header bg-c-green update-card">
                  <h5 class="text-white">Informações Gerais</h5>
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
                                                          <th scope="row">Código</th>
                                                          <td>#{{ str_pad($order->id, 6, "0", STR_PAD_LEFT)  }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Cadastro</th>
                                                          <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Cliente</th>
                                                          <td><a href="{{route('clients.show', ['id' => $order->client->uuid])}}" target="_blank">{{ $order->client->name }}</a></td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Telefone</th>
                                                          <td>
                                                            @foreach($order->client->phones as $phone)
                                                                <p>{{ $phone->number }}</p>
                                                            @endforeach
                                                          </td>
                                                      </tr>

                                                      <tr>
                                                          <th scope="row">Email</th>
                                                          <td>
                                                            @foreach($order->client->emails as $email)
                                                                <p>{{ $email->email }}</p>
                                                            @endforeach
                                                          </td>
                                                      </tr>

                                                      @php

                                                        $status = $order->status->id;

                                                        $bgColor = 'success';

                                                        switch($status) {
                                                          case '1':
                                                            $bgColor = 'primary';
                                                            break;
                                                          case '2':
                                                            $bgColor = 'warning';
                                                            break;
                                                          case '3':
                                                            $bgColor = 'success';
                                                            break;
                                                          case '4':
                                                            $bgColor = 'danger';
                                                            break;
                                                        }

                                                      @endphp

                                                      <tr>
                                                          <th scope="row">Situação</th>
                                                          <td><label class="label label-{{ $bgColor }} label-lg">{{ $order->status->name ?? '-' }}</label></td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Data Agendamento</th>
                                                          <td>{{ $order->delivery_date ? $order->delivery_date->format('d/m/Y') : '-' }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Data Entrega</th>
                                                          <td>{{ $order->delivery_at ? $order->delivery_at->format('d/m/Y H:i') : '-' }}</td>
                                                      </tr>
                                                      <tr>
                                                          <th scope="row">Entregador</th>
                                                          <td>{{ $order->user->person->name ?? '-' }}</td>
                                                      </tr>

                                                      <tr>
                                                          <th scope="row">Anotações</th>
                                                          <td>{{ $order->annotations ?? '-' }}</td>
                                                      </tr>

                                                      @if(auth()->user()->isAdmin())

                                                        <tr>
                                                            <th scope="row">Cobrar Entrega</th>
                                                            <td>
                                                              @if($order->charge_delivery)
                                                                  <label class="label label-success">Sim</label>
                                                              @else
                                                                  <label class="label label-danger">Não</label>
                                                              @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Reirada pelo Cliente</th>
                                                            <td>
                                                              @if($order->withdrawal_by_client)
                                                                  <label class="label label-success">Sim</label>
                                                              @else
                                                                  <label class="label label-danger">Não</label>
                                                              @endif
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">R$ Valor</th>
                                                            <td>
                                                              <label class="label label-primary">{{ $order->amount ? number_format($order->amount, 2) : 'Valor não cobrado' }}</label>
                                                            </td>
                                                        </tr>

                                                      @endif

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

      <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-c-green update-card">
                <h5 class="text-white">Endereço</h5>
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
                                                    <th scope="row">Cidade / Estado</th>
                                                    <td>{{ $order->address->city }} / {{ $order->address->state }}</td>
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

      <div class="col-lg-6">
          <div class="card">
              <div class="card-header bg-c-green update-card">
                  <h5 class="text-white">Documentos</h5>
              </div>
              <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">

                        <thead>
                            <tr class="table-inverse">
                              <th>ID</th>
                              <th>Tipo</th>
                              @if($order->shipment)
                                <th>Empresa</th>
                              @else
                                <th>Funcionário / Referência</th>
                              @endif
                              <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($order->documents->sortBy('document.employee.name') as $document)
                        @php
                          $document = $document->document;
                        @endphp
                        <tr>
                            <td><a href="{{route('documents.show', ['id' => $document->uuid])}}">#{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</a></td>

                            <td>
                                <a>{{ $document->type->name ?? '-' }}</a>
                            </td>
                            <td>
                              @if($order->shipment)

                                    {{ $document->client->name ?? '' }}

                                    @if($document->deliveryDocument)
                                      <br/><br/>
                                      <a href="{{ route('delivery-order.show', $document->deliveryDocument->deliveryOrder->uuid) }}" class="label label-inverse-success">Ordem de Entrega #{{ str_pad($document->deliveryDocument->deliveryOrder->id, 6, "0", STR_PAD_LEFT) }}</a>
                                    @endif

                                    @if($document->employee)
                                      <br/>
                                      <small>Funcionário: <a href="{{ route('employees.show', $document->employee->uuid) }}">{{ $document->employee->name ?? '' }}</a></small>
                                    @endif

                              @elseif($document->employee)
                                  <a href="{{ route('employees.show', $document->employee->uuid) }}">{{ $document->employee->name ?? '' }}</a>
                              @elseif($document->reference)
                                  {{ $document->reference }}
                              @endif

                              @if($document->address)
                                  <br/>
                                  <small>Endereço: <a href="{{ route('client_addresses', $document->address->uuid) }}">{{ $document->address->description ?? '' }}</a></small>
                              @endif
                            </td>
                            @php

                              $status = $document->status->id;

                              $bgColor = 'success';

                              switch($status) {
                                case '1':
                                  $bgColor = 'primary';
                                  break;
                                case '2':
                                  $bgColor = 'warning';
                                  break;
                                case '3':
                                  $bgColor = 'success';
                                  break;
                                case '4':
                                  $bgColor = 'danger';
                                  break;
                              }

                              @endphp

                            <td>
                                <label class="label label-{{$bgColor}}">{{ $document->status->name }}</label>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

              </div>
          </div>
      </div>

      <div class="col-lg-6">
          <div class="card">
              <div class="card-header card bg-c-green update-card">
                  <h5 class="text-white">Comprovante</h5>
              </div>
              <div class="card-block task-attachment">

                <input type="file" name="receipt" id="filer2" data-route="{{ route('delivery_receipt_upload', $order->uuid) }}">

                <ul class="media-list">

                  @if($order->receipt)
                    <li class="media d-flex m-b-10 mediaFile">
                        <div class="m-r-20 v-middle">
                            <i class="icofont icofont-file-pdf f-28 text-muted"></i>
                        </div>
                        <div class="media-body">
                            <a target="_blank" href="{{ route('delivery_get_receipt', $order->uuid) }}" class="m-b-5 d-block">Visualizar Comprovante</a>
                        </div>
                    </li>
                  @endif
                </ul>


              </div>
          </div>
      </div>

  </div>

  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="card-header-text text-white"><i class="icofont icofont-certificate-alt-2 m-r-10"></i> Atividades</h5>
      </div>
      <div class="card-block revision-block">
          <div class="form-group">
              <div class="row">
                  <ul class="media-list revision-blc">
                    @foreach($order->logs->sortByDesc('id') as $log)
                      <li class="media d-flex m-b-15">
                          <div class="p-l-15 p-r-20 d-inline-block v-middle">
                            <img width="40" class="img-radius" src="{{ route('image', ['user' => $log->user->uuid, 'link' => $log->user->avatar, 'avatar' => true])}}" alt="chat-user">
                          </div>
                          <div class="d-inline-block">
                              {{ $log->message }}
                              <div class="media-annotation">{{ $log->created_at->format('d/m/Y H:i:s') }} - {{ $log->created_at->diffForHumans() }}</div>
                          </div>
                      </li>
                      @endforeach
                  </ul>
              </div>
          </div>
      </div>
  </div>

</div>

@endsection

@section('scripts')
    <script>

      $(document).ready(function() {

          var cancel = $(".btnCancel");

          cancel.click(function(e) {

              var self = $(this);

              swal({
                title: 'Cancelar Ordem de Entrega?',
                text: "Os documentos voltarão a ficar disponiveis para serem incluídos em outra Ordem.",
                showCancelButton: true,
                confirmButtonColor: '#0ac282',
                cancelButtonColor: '#D46A6A',
                confirmButtonText: 'Sim, Cancelar',
                cancelButtonText: 'Não'
                }).then((result) => {
                if (result.value) {

                  e.preventDefault();

                  window.swal({
                    title: 'Em progresso...',
                    text: 'Aguarde enquanto a requisição é processada.',
                    type: 'success',
                    showConfirmButton: false,
                    allowOutsideClick: false
                  });

                  $.ajax({
                    headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                    url: self.data('route'),
                    type: 'POST',
                    dataType: 'json',
                    data: {}
                  }).done(function(data) {

                    swal.close();

                    if(data.success) {

                      notify(data.message, 'inverse');

                      window.location.href = data.route;

                    } else {

                      notify(data.message, 'danger');

                    }

                  });
                }
              });
          });

          var finish = $(".btnConfirm");

          finish.click(function(e) {

              var self = $(this);

              swal({
                title: 'Finalizar Ordem de Entrega?',
                text: "Esta Ordem de entrega será finalizada, e não poderá sofrer alterações após a sua confirmação.",
                showCancelButton: true,
                confirmButtonColor: '#0ac282',
                cancelButtonColor: '#D46A6A',
                confirmButtonText: 'Sim, Finalizar',
                cancelButtonText: 'Não'
                }).then((result) => {
                if (result.value) {

                  e.preventDefault();

                  window.swal({
                    title: 'Em progresso...',
                    text: 'Aguarde enquanto a requisição é processada.',
                    type: 'success',
                    showConfirmButton: false,
                    allowOutsideClick: false
                  });

                  $.ajax({
                    headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                    url: self.data('route'),
                    type: 'POST',
                    dataType: 'json',
                    data: {}
                  }).done(function(data) {

                    swal.close();

                    if(data.success) {

                      notify(data.message, 'inverse');

                      window.location.href = data.route;

                    } else {

                      notify(data.message, 'danger');

                    }

                  });
                }
              });
          });

      });

    </script>
@stop
