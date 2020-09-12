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
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.index') }}"> Clientes </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.show', $client->uuid) }}"> Detalhes </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Documentos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-md-4">

      <div class="card">
          <div class="card-header">
              <h5>Upload</h5>
          </div>
          <div class="card-block">
                <input type="file" name="files[]" id="filer" data-route="{{ route('client_documents_upload', $client->uuid) }}" multiple="multiple">
          </div>
      </div>

    </div>

    <div class="col-md-8">

      <div class="card">
          <div class="card-header">
              <h5>Documentos</h5>
          </div>
          <div class="card-block">

            @if($client->files->isNotEmpty())
              <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>Arquivo</th>
                          <th>Adionado por</th>
                          <th>Upload em</th>
                          <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->files as $document)
                            <tr>

                                <td>
                                    <a target="_blank" href="{{ route('document_preview', ['id' => $document->uuid, 'filename' => $document->filename]) }}">{{$document->filename}}</a>
                                </td>

                                <td>
                                    <a>{{$document->creator->person->name}}</a>
                                </td>

                                <td>
                                      <span>{{$document->created_at->diffForHumans() }}</span><br/>
                                      <small>({{$document->created_at->format('d/m/Y H:i:s') }})</small>
                                </td>

                                <td class="dropdown">
                                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @permission('edit.clientes')
                                      <a target="_blank" href="{{ route('document_preview', $document->uuid) }}" class="dropdown-item"><i class="fas fa-eye"></i> Visualizar</a>
                                    @endpermission

                                    @permission('edit.clientes')
                                      <a href="{{route('document_download', [$document->uuid])}}" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Download</a>
                                    @endpermission

                                    @permission('delete.clientes')
                                      <a href="#!" data-route="{{route('document_delete', ['id' => $document->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
                                    @endpermission

                                  </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            @else
              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                      <p class="font-bold no-margins">Nenhum documento encontrado.</p>
                  </div>
              </div>
            @endif

      </div>

    </div>

    </div>

  </div>

</div>

@endsection
