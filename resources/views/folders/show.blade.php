@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Arquivos:
                        @if($folder->parent)
                            {{$folder->parent->name}} / 
                        @endif

                        {{ $folder->name }}

                    </h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Arquivos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Pastas</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.tipo.de.chamados')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('folders.create', ['parent_folder_id' => $folder->uuid])}}">Nova Pasta</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  <tr>
                      <td colspan="2">
                        @if(!$folder->parent)
                            <a href="{{ route('folders.show', $folder->uuid) }}">..\</a>
                        @else
                            <a href="{{ route('folders.show', $folder->parent->uuid) }}">..\</a>
                        @endif
                      </td>
                  </tr>

                  @foreach($folder->folders as $item)

                      <tr>
                          <td><a href="{{ route('folders.show', $item->uuid) }}">{{$item->name}}</a></td>
                          <td class="text-right">
                              <a class="btn btn-primary btn-sm btn-round" href="{{ route('folders.edit', $item->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                          </td>
                      </tr>

                  @endforeach

                </tbody>
            </table>
        </div>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Arquivos</h5>
      </div>
      <div class="card-block">

        <div class="">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Proprietário</th>
                        <th>Adicionado Em</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($folder->archives as $archive)

                      <tr>
                          <td><a href="{{ route('folders.show', $archive->uuid) }}">{{$archive->filename}}</a></td>
                          <td><a href="{{ route('folders.show', $archive->uuid) }}">{{$archive->user->person->name}}</a></td>
                          <td><a href="{{ route('folders.show', $archive->uuid) }}">{{$archive->created_at->format('d/m/Y H:i')}}</a></td>
                          <td class="dropdown text-right">

                            <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              <a class="dropdown-item" target="_blank" href="{{ route('archive_preview', $archive->uuid) }}"><i class="fas fa-file"></i> Visualizar</a>
                              <a class="dropdown-item" href="{{ route('archives_download', $archive->uuid) }}"><i class="fas fa-cloud-download-alt"></i> Download</a>
                              <a class="dropdown-item" href="{{ route('archives.edit', $archive->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                              <a class="dropdown-item text-danger btnRemoveItem" href="#!" data-route="{{route('archives.destroy', ['id' => $archive->uuid])}}"><i class="fas fa-trash"></i> Remover </a>

                            </div>
                          </td>

                      </tr>

                  @endforeach

                </tbody>
            </table>
        </div>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Upload</h5>
      </div>
      <div class="card-block">
          <div class="sub-title">Upload de Arquivos</div>
          <input type="file" name="files[]" id="filer" data-route="{{ route('file_upload', $folder->uuid) }}" multiple="multiple">
      </div>
  </div>

</div>

@endsection
