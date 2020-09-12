@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ativo: {{ $product->name }}</h4>
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
                        <a href="{{ route('products.index') }}"> Ativos </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.show', $product->uuid) }}"> {{ $product->name }} </a>
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
          <h5>Informações do Ativo</h5>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('edit.ativos')
                    <li><a class="btn btn-sm btn-primary" href="{{ route('stock.edit', ['id' => $stock->uuid]) }}">Editar</a></li>
                  @endpermission

              </ul>
          </div>

      </div>
      <div class="card-block">

        <p class="lead text-primary">Item: #{{ str_pad($stock->id, 6, "0", STR_PAD_LEFT) }}<p>

        <p class="">Situação: <span class="label label-inverse-success">{{ $stock->status }}</span><p>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Histórico de Tranferências do Ativo </h5>
          <span>Histórico do Ativo<span>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.transferencias')
                    <a href="{{route('transfer.create', ['stock' => $stock->uuid])}}" class="btn btn-sm btn-primary">Nova Transferência </a>
                  @endpermission

              </ul>
          </div>

      </div>
      <div class="card-block">
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>Assunto / Motivo</th>
                        <th>Destino</th>
                        <th>Situação</th>
                        <th>Agendamento</th>
                        <th>Retirada</th>
                        <th>Devolução</th>
                        <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($stock->items->sortByDesc('id') as $item)
                      @php
                          $transfer = $item->transfer;
                      @endphp
                      <tr>
                          <th scope="row">#{{ str_pad($transfer->id, 6, "0", STR_PAD_LEFT) }}</th>
                          <td>  <a href="{{route('transfer.show', ['id' => $transfer->uuid])}}">{{ $transfer->subject }}</a></td>
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
                          <td><span class="label label-inverse-success">{{ $transfer->status }}</span></td>
                          <td>{{ $transfer->scheduled_to ? $transfer->scheduled_to->format('d/m/Y') : '-' }}</td>
                          <td>{{ $transfer->withdrawn_at ? $transfer->withdrawn_at->format('d/m/Y') : '-' }}</td>
                          <td>{{ $transfer->returned_at ? $transfer->returned_at->format('d/m/Y') : '-' }}</td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('view.ativos')
                                <a href="{{route('transfer.show', ['id' => $transfer->uuid])}}" class="dropdown-item">Visualizar </a>
                              @endpermission

                            </div>
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

      $('#products-table').Tabledit({
          deleteButton: false,
          saveButton: false,
          columns: {
            identifier: [0, 'id'],
            editable: [[1, 'name'], [2, 'description']]
        }

      });
  });

</script>

@endsection
