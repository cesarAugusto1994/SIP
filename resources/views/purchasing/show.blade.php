@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Pedidos de Compra</h4>
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
                        <a href="{{ route('purchasing.index') }}"> Pedidos de Compra </a>
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
          <h5>Informações do Pedido de Compra</h5>
      </div>
      <div class="card-block">

        <button class="btn btn-inverse f-right btnRequest" data-url="{{ route('purchasing_request', $purchasing->uuid) }}">Fazer Solicitação</button>

        <p class="lead text-primary">#{{ str_pad($purchasing->id, 6, "0", STR_PAD_LEFT) }}<p>

        <p class="text-muted">Solicitante: {{ $purchasing->user->person->name }}<p>
        <p class="text-muted">Setor / Unidade: {{ $purchasing->user->person->department->name }} - {{ $purchasing->user->person->unit->name }}<p>
        <p class="text-muted">Data de Solicitação: {{ $purchasing->created_at->format('d/m/Y H:i') ?? '-' }}<p>
        <p class="text-muted">Motivo: {{ $purchasing->motive ?? '-' }}<p>
        <p class="text-muted">Observações: {{ $purchasing->observations ?? '-' }}<p>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Itens do Pedido de Compra </h5>
          <span class="text-success">Itens do Pedido de Compra<span>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.ativos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('purchasing-item.create', ['purchasing_id' => $purchasing->uuid])}}">Novo Item</a></li>
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
                          <th>Unidade</th>
                          <th>Descrição</th>
                          <th>Quantidade</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($purchasing->items as $item)
                      <tr>
                          <th scope="row">#{{ $item->id }}</th>
                          <td>{{ $item->unit }}</td>
                          <td>{{ $item->description }}</td>
                          <td>{{ $item->quantity }}</td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('edit.ativos')
                                <a href="{{route('purchasing-item.edit', ['id' => $item->uuid])}}" class="dropdown-item">Editar </a>
                              @endpermission

                              @permission('edit.ativos')
                                <a data-route="{{ route('purchasing-item.destroy', ['id' => $item->uuid]) }}" style="cursor:pointer" class="dropdown-item text-danger btnRemoveItem">Remover </a>
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

<script>

	$(document).ready(function() {

    var btnRequest = $('.btnRequest');

    btnRequest.click(function() {

      var self = $(this);
      var url = self.data('url');

      swal({
        title: 'Fazer Solicitação?',
        text: "Não será possível adicionar mais itens!",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0ac282',
        cancelButtonColor: '#D46A6A',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
        }).then((result) => {
        if (result.value) {

          swal({
            title: 'Aguarde um instante.',
            text: 'Carregando os dados...',
            type: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
          });

          $.ajax({
            headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: url,
            type: 'POST',
            dataType: 'json',

          }).done(function(data) {

            swal({
              title: 'Solicitação Realizada.',
              text: 'As informações foram enviadas...',
              type: 'success',
              showConfirmButton: true,
              allowOutsideClick: false
            });

            self.hide();

          });;

        }
      });

    });

  });

</script>

@endsection
