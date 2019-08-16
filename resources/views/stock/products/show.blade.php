@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ativos</h4>
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
      </div>
      <div class="card-block">

        <p class="lead text-success">#{{ $product->id }} - {{ $product->name }}<p>

        <p class="text-muted">Descrição: {{ $product->description }}<p>
        <p class="text-muted">Fornecedor: {{ $product->vendor ? $product->vendor->name : '-' }}<p>
        <p class="text-muted">Marca: {{ $product->brand ? $product->brand->name : '-' }}<p>
        <p class="text-muted">Modelo: {{ $product->model ? $product->model->name : '-' }}<p>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Itens do Ativo </h5>
          <span class="text-success">Itens de Ativo<span>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.ativos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('stock.create', ['product_id' => $product->uuid])}}">Novo Item</a></li>
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
                          <th>Matricula</th>
                          <th>Situação</th>
                          <th>Localização</th>
                          <th>Com</th>
                          <th>Comprado Em</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($product->stocks as $stock)
                      <tr>
                          <th scope="row">#{{ $stock->id }}</th>
                          <td>{{ $stock->equity_registration_code }}</td>
                          <td>{{ $stock->status }}</td>
                          <td>{{ $stock->localization }}</td>
                          <td>
                            @if($stock->localization == 'Usuário')
                              {{ $stock->user->person->name }}
                            @elseif($stock->localization == 'Departamento')
                              {{ $stock->department->name }}
                            @elseif($stock->localization == 'Unidade')
                              {{ $stock->unit->name }}
                            @elseif($stock->localization == 'Fornecedor')
                              {{ $stock->vendor->name }}
                            @else
                              -
                            @endif
                          </td>
                          <td>{{ $stock->buyed_at ? $stock->buyed_at->format('d/m/Y') : '' }}</td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('edit.ativos')
                                <a href="{{route('stock.edit', ['id' => $stock->uuid])}}" class="dropdown-item">Editar </a>
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
