@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Documentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Documentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Documentos</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.documentos')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('documents.create')}}">Novo</a></li>
                  @endpermission

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
                        <a class="label label-{{ array_random(['info', 'success', 'primary', 'danger', 'warning']) }}">{{ $document->type->name ?? '-' }}</a>
                    </td>

                    <td>
                        <p><a href="{{route('clients.edit', ['id' => $document->client->uuid])}}">{{ $document->client->name }}</a></p>
                    </td>

                    <td>
                      @if($document->status->id == 1)
                          <label class="label label-inverse-primary">{{ $document->status->name }}</label>
                      @elseif ($document->status->id == 2)
                          <label class="label label-inverse-warning">{{ $document->status->name }}</label>
                      @else
                          <label class="label label-inverse-success">{{ $document->status->name }}</label>
                      @endif
                    </td>

                    <td>
                        <p><a>{{ $document->creator->person->name }}</a></p>
                    </td>

                    <td>
                        <p><a>{{ $document->created_at->format('d/m/Y H:i') }}</a></p>
                    </td>

                    <td class="dropdown">

                      <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                      <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                        @permission('edit.documentos')
                          @if($document->status_id == 1)
                              <a href="{{route('delivery-order.create', ['client' => $document->client->uuid, 'document[]' => $document->uuid])}}" class="dropdown-item"><i class="fa fa-truck"></i>Gerar Entrega</a>
                          @endif
                        @endpermission
                        @permission('edit.documentos')
                          <a href="{{route('documents.edit', ['id' => $document->uuid])}}" class="dropdown-item"><i class="fa fa-edit"></i> Editar</a>
                        @endpermission
                        @permission('delete.documentos')
                          <a href="#!" data-route="{{route('documents.destroy', ['id' => $document->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fa fa-trash"></i> Remover</a>
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

@endsection
