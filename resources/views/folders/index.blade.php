@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Porta Arquivos</h4>
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
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('folders.create')}}">Nova Pasta</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block">

        @if($folders->isNotEmpty())

        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($folders as $folder)

                      @if($folder->parent_id)
                        @continue;
                      @endif

                      <tr>
                          <td><a href="{{ route('folders.show', $folder->uuid) }}">{{$folder->name}}</a></td>
                          <td class="text-right">
                              <a class="btn btn-primary btn-sm btn-round" href="{{ route('folders.edit', $folder->uuid) }}"><i class="fa fa-edit"></i> Editar</a>
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
                <p class="font-bold no-margins">Nenhum registro encontrado.</p>
              </div>
          </div>

        @endif

      </div>
  </div>

</div>

@endsection
