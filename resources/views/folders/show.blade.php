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
                    <li class="breadcrumb-item">
                        <a href="{{ route('folders.index') }}"> Arquivos </a>
                    </li>

                    @if($folder->parent)

                        <li class="breadcrumb-item">
                            <a href="{{ route('folders.show', $folder->parent->uuid) }}"> {{$folder->parent->name}} </a>
                        </li>

                    @endif

                    <li class="breadcrumb-item"><a href="#!">{{ $folder->name }}</a></li>
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

                  @permission('create.pastas')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('folders.create', ['parent_folder_id' => $folder->uuid])}}">Nova Pasta</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="">
            <table class="table table-hover">
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
                            <a class="label label-inverse-primary" href="{{ route('folders.index') }}">..\</a>
                        @else
                            <a class="label label-inverse-primary" href="{{ route('folders.show', $folder->parent->uuid) }}">..\</a>
                        @endif
                      </td>
                  </tr>

                  @foreach($folder->folders as $item)

                      @php
                          $permission = $item->permissionsForUser->where('user_id', auth()->user()->id)->first();
                          $read = $permission->read ?? false;
                          $edit = $permission->edit ?? false;
                          $share = $permission->share ?? false;
                          $download = $permission->download ?? false;
                          $delete = $permission->delete ?? false;

                          if(auth()->user()->isAdmin()) {
                              $read = $edit = $share = $download = true;
                          }

                      @endphp

                      @if($read)

                      <tr>
                          <td><a class="lead m-t-0" href="{{ route('folders.show', $item->uuid) }}">{{$item->name}}</a><br/>
                              <span class="text-muted">{{ \App\Helpers\Helper::formatBytes($item->archives->sum('size')) }}</span>
                          </td>
                          <td class="dropdown text-right">

                            <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              <a class="dropdown-item" href="{{ route('folders.show', $item->uuid) }}"><i class="fas fa-file"></i> Visualizar</a>
                              @if($download)
                                <a class="dropdown-item" href="{{route('folders_download', $item->uuid)}}"><i class="fas fa-cloud-download-alt"></i> Download</a>
                              @endif
                              @if($edit)
                                <a class="dropdown-item" href="{{ route('folders.edit', $item->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                              @endif
                              @if($delete)
                                <a class="dropdown-item text-danger btnRemoveItem" href="#!" data-route="{{route('folders.destroy', ['id' => $item->uuid])}}"><i class="fas fa-trash"></i> Remover </a>
                              @endif
                            </div>
                          </td>

                      </tr>

                      @endif

                  @endforeach

                </tbody>
            </table>
        </div>

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Arquivos da Pasta</h5>
          <span class="text-muted">{{ $folder->archives->count() }} Arquivo(s) e {{ \App\Helpers\Helper::formatBytes($folder->archives->sum('size')) }}</span>

          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @php

                      $btnListClass = 'btn-danger';
                      $btnGridClass = 'btn-outline-danger';

                      if($listStyle == 'grid') {

                        $btnGridClass = 'btn-danger';
                        $btnListClass = 'btn-outline-danger';

                      }

                  @endphp

                  <li><a class="btn btn-sm {{ $btnListClass }} btn-round" href="?list=list">Lista</a></li>
                  <li><a class="btn btn-sm {{ $btnGridClass }} btn-round" href="?list=grid">Grid</a></li>

                  @php
                      $permission = $folder->permissionsForUser->where('user_id', auth()->user()->id)->first();
                      $download = $permission->download ?? false;

                      if(auth()->user()->isAdmin()) {
                          $download = true;
                      }
                  @endphp

                  @if($download)
                    <li><a class="btn btn-sm btn-primary btn-round" href="{{route('folders_download', $folder->uuid)}}">Baixar Pasta</a></li>
                  @endif

              </ul>
          </div>
      </div>
      <div class="card-block">

        @if($folder->archives->isNotEmpty())

          @if($listStyle == 'grid')

            <div class="row">
            @foreach($folder->archives as $archive)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block text-center">
                            <h4 class="m-t-20"><a target="_blank" href="{{ route('archive_preview', $archive->uuid) }}">{{$archive->filename}}</a></h4>
                            <p class="">{{$archive->created_at->format('d/m/Y H:i')}}<br/>
                                <label class="label label-inverse-primary">{{ $archive->created_at->diffForHumans() }}</label>
                            </p>
                        </div>

                        <div class="card-footer bg-c-green">
                            <div class="row align-items-center">
                                <div class="col-6 text-white">
                                    <span>{{ \App\Helpers\Helper::formatBytes($archive->size) }}</span>
                                </div>
                                <div class="col-6 text-right text-white">

                                    <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu" style="z-index: 9999;">

                                      <a class="dropdown-item" target="_blank" href="{{ route('archive_preview', $archive->uuid) }}"><i class="fas fa-file"></i> Visualizar</a>
                                      <a class="dropdown-item" href="{{ route('archives_download', $archive->uuid) }}"><i class="fas fa-cloud-download-alt"></i> Download</a>
                                      <a class="dropdown-item" href="{{ route('archives.edit', $archive->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
                                      <a class="dropdown-item text-danger btnRemoveItem" href="#!" data-route="{{route('archives.destroy', ['id' => $archive->uuid])}}"><i class="fas fa-trash"></i> Remover </a>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
            </div>

          @else

          <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Proprietário</th>
                        <th>Upload Em</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($folder->archives as $archive)

                      <tr>
                          <td><a target="_blank" href="{{ route('archive_preview', $archive->uuid) }}">{{$archive->filename}}</a>
                            <br/><span class="text-muted">{{ \App\Helpers\Helper::formatBytes($archive->size) }}</span>
                          </td>
                          <td>{{$archive->user->person->name}}</td>
                          <td><span class="text-muted">{{$archive->created_at->format('d/m/Y H:i')}}</span>
                            <label class="label label-inverse-primary">{{ $archive->created_at->diffForHumans() }}</label>
                          </td>
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

          @endif

        </div>
        @else
          <div class="widget white-bg no-padding">
              <div class="p-m text-center">
                <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                <p class="font-bold no-margins">Nenhum registro encontrado.</p>
              </div>
          </div>
        @endif

      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Upload</h5>
      </div>
      <div class="card-block table-responsive">
          <div class="sub-title">Upload de Arquivos</div>
          <input type="file" name="files[]" id="filer" data-route="{{ route('file_upload', $folder->uuid) }}" multiple="multiple">
      </div>
  </div>

</div>

@endsection
