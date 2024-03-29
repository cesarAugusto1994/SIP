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

                  @permission('create.pastas')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('folders.create')}}">Nova Pasta</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
  </div>

  @if($folders->isNotEmpty())

  <div class="row">
    @foreach($folders as $folder)

    @if($folder->parent_id)
      @continue;
    @endif

    @php
    
        $permission = $folder->permissionsForUser->where('user_id', auth()->user()->id)->first();
        $read = $permission->read ?? false;
        $edit = $permission->edit ?? false;
        $share = $permission->share ?? false;
        $delete = $permission->delete ?? false;

        if(auth()->user()->isAdmin()) {
            $read = $edit = $share = $download = true;
        }

    @endphp

    @if($read)

        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-block text-center">
                    <h2 class="m-t-20"><a style="font-size: 2rem;" href="{{ route('folders.show', $folder->uuid) }}">{{$folder->name}}</a></h2>

                    @if(auth()->user()->isAdmin())
                        <p class="m-b-20">{{$folder->created_at->format('d/m/Y H:i')}}<br/>
                          <label class="label label-inverse-primary">{{ $folder->created_at->diffForHumans() }}</p>
                        <a class="btn btn-success btn-sm" href="{{ route('folders.show', $folder->uuid) }}"><i class="fas fa-check"></i> Acessar</a>
                    @endif

                    @if($edit)
                        <a class="btn btn-primary btn-sm" href="{{ route('folders.edit', $folder->uuid) }}"><i class="fas fa-edit"></i> Editar</a>
                    @endif
                </div>
                <div class="card-footer bg-c-green">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <p class="text-white m-b-0">{{ $folder->archives->count() }} Arquivos</p>
                        </div>
                        <div class="col-6 text-right text-white">
                            {{ \App\Helpers\Helper::formatBytes($folder->archives->sum('size')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    @endforeach

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

@endsection
