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
                    <li class="breadcrumb-item"><a href="#!">Ativos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Ativos</h5>
          <span>Ativos</span>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.ativos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('products.create')}}">Novo Ativo</a></li>
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
                          <th>Nome</th>
                          <th>Inventário</th>
                          <th>Disponíveis</th>
                          <th>Fornecedor</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($products as $product)
                      <tr>
                          <th scope="row">{{ $product->id }}</th>
                          <td>  <a href="{{route('products.show', ['id' => $product->uuid])}}">{{ $product->name }}</a></td>
                          <td>{{ $product->stocks ? $product->stocks->count() : 0 }}</td>
                          <td>{{ $product->stocks ? $product->stocks->filter(function($stock, $index) { return $stock->status == 'Disponível'; })->count() : 0 }}</td>
                          <td>{{ $product->vendor ? $product->vendor->name : '' }}</td>
                          <td>{{ $product->brand ? $product->brand->name : '' }}</td>
                          <td>{{ $product->model ? $product->model->name : '' }}</td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('view.ativos')
                                <a href="{{route('products.show', ['id' => $product->uuid])}}" class="dropdown-item">Visualizar </a>
                              @endpermission

                              @permission('edit.ativos')
                                <a href="{{route('products.edit', ['id' => $product->uuid])}}" class="dropdown-item">Editar </a>
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
