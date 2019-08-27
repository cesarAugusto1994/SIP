@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Transferencia de Ativos</h4>
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
                        <a href="{{ route('transfer.index') }}"> Transferencia de Ativos </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalhes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Informações da transferência</h5>
          <div class="card-header-right">

              <div class="dropdown-inverse dropdown open">
                  <button class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light " type="button" id="dropdown-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Opções</button>
                  <div class="dropdown-menu" aria-labelledby="dropdown-3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                      <a target="_blank" class="dropdown-item waves-light waves-effect" href="{{ route('transfer_term_signature', $transfer->uuid) }}">Termo de Compromisso</a>
                      @if($transfer->status == 'Pendente')
                        <a class="dropdown-item waves-light waves-effect btnTransfer" data-route="{{ route('transfer_itens_options', ['id' => $transfer->uuid, 'action' => 'approve']) }}">Aprovar</a>
                        <a class="dropdown-item waves-light waves-effect btnTransfer" data-route="{{ route('transfer_itens_options', ['id' => $transfer->uuid, 'action' => 'deny']) }}">Cancelar</a>
                      @elseif($transfer->status == 'Autorizado')
                        <a class="dropdown-item waves-light waves-effect btnTransfer" data-route="{{ route('transfer_itens_options', ['id' => $transfer->uuid, 'action' => 'withdrawn']) }}">Rerirar Itens</a>
                      @elseif($transfer->status == 'Em Uso')
                        <a class="dropdown-item waves-light waves-effect btnTransfer" data-route="{{ route('transfer_itens_options', ['id' => $transfer->uuid, 'action' => 'return']) }}">Devolver</a>
                      @endif
                  </div>
              </div>

          </div>
      </div>
      <div class="card-block">

          <div class="row">
              <div class="col-lg-12 col-xl-6">
                  <div class="table-responsive">
                      <table class="table m-0">
                          <tbody>
                              <tr>
                                  <th scope="row">ID</th>
                                  <td>#{{ $transfer->id }}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Assunto/Motivo: </th>
                                  <td>{{ $transfer->subject }}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Descrição: </th>
                                  <td>{{ $transfer->description }}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Agendamento</th>
                                  <td>{{ $transfer->scheduled_to ? $transfer->scheduled_to->format('d/m/Y') : '-' }}</td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <!-- end of table col-lg-6 -->
              <div class="col-lg-12 col-xl-6">
                  <div class="table-responsive">
                      <table class="table">
                          <tbody>
                              <tr>
                                  <th scope="row">Situação: </th>
                                  <td><span class="label label-inverse-success">{{ $transfer->status }}</span></td>
                              </tr>
                              <tr>
                                  <th scope="row">Destino</th>
                                  <td>

                                  @if($transfer->localization == 'Usuário')
                                    {{ $transfer->user->person->name }} - {{ $transfer->user->person->department->name }}
                                  @elseif($transfer->localization == 'Departamento')
                                    {{ $transfer->department->name }}
                                  @elseif($transfer->localization == 'Unidade')
                                    {{ $transfer->unit->name }}
                                  @elseif($transfer->localization == 'Fornecedor')
                                    {{ $transfer->vendor->name }}
                                  @else
                                    -
                                  @endif
                                  </td>

                              </tr>
                              <tr>
                                  <th scope="row">Retirada: </th>
                                  <td>{{ $transfer->withdrawn_at ? $transfer->withdrawn_at->format('d/m/Y') : '-' }}</td>
                              </tr>
                              <tr>
                                  <th scope="row">Devolução: </th>
                                  <td>{{ $transfer->returned_at ? $transfer->returned_at->format('d/m/Y') : '-' }}</td>
                              </tr>

                          </tbody>
                      </table>
                  </div>
              </div>
              <!-- end of table col-lg-6 -->
          </div>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Itens do Ativo </h5>
          <span class="text-success">Itens de Ativo<span>

      </div>
      <div class="card-block">
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Item</th>
                          <th>Matricula</th>
                          <th>Situação Atual</th>
                          <th>Localização Atual</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($transfer->items as $stock)
                      @php
                          $stock = $stock->stock;
                      @endphp
                      <tr>
                          <th scope="row">#{{ $stock->id }}</th>
                          <td>{{ $stock->product->name }}</td>
                          <td>{{ $stock->equity_registration_code }}</td>
                          <td>{{ $stock->status }}</td>
                          <td>{{ $stock->localization }}
                            @if($stock->localization == 'Usuário')
                              {{ $stock->user->person->name }}
                            @elseif($stock->localization == 'Departamento')
                              {{ $stock->department->name }}
                            @elseif($stock->localization == 'Unidade')
                              {{ $stock->unit->name }}
                            @elseif($stock->localization == 'Fornecedor')
                              {{ $stock->vendor->name }}
                            @else

                            @endif
                          </td>

                      </tr>
                    @endforeach

                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{ asset('adminty\pages\edit-table\jquery.tabledit.js') }}"></script>

<script>

	$(document).ready(function() {

    $(".btnTransfer").click(function(e) {
        var self = $(this);

        swal({
          title: 'Confirmar esta ação?',
          text: "O processo de transferência não pode ser alterado depois desta ação.",
          showCancelButton: true,
          confirmButtonColor: '#0ac282',
          cancelButtonColor: '#D46A6A',
          confirmButtonText: 'Sim',
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
              data: {

              }
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

@endsection
