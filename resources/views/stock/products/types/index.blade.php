@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Produtos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Tipos de Produtos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Tipos</h5>
          <span class="text-success">Tipos<span>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.tipos.de.produto')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('product-types.create')}}">Novo Tipo de Produto</a></li>
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
                          <th>Ativo</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                    @foreach($types as $type)
                      <tr>
                          <th scope="row">{{ $type->id }}</th>
                          <td>{{ $type->name }}</td>
                          <td>{{ $type->active ? 'Ativo' : 'Inativo' }}</td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('edit.tipos.de.produto')
                                <a href="{{route('product-types.edit', ['id' => $type->uuid])}}" class="dropdown-item">Editar </a>
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
