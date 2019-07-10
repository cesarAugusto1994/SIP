@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mural de Recados</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Mural de Recados</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="card latest-update-card">
        <div class="card-header">
            <h5>Gestão à Vista</h5>
            <span>Mural de recados com informes e anúncios da empresa ou setor</span>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">

                    @permission('create.chamados')
                      <li><a class="btn btn-sm btn-success btn-round" href="{{route('message-board.create')}}">Novo Recado</a></li>
                    @endpermission

                </ul>
            </div>
        </div>
        <div class="card-block">

          @if($messages->isNotEmpty())

            <div class="latest-update-box">
              @foreach($messages as $message)
                  <div class="row p-t-20 p-b-30">
                      <div class="col-auto text-right update-meta">
                          <p class="text-muted m-b-0 d-inline">{{ \App\Helpers\TimesAgo::render($message->created_at) }}</p>

                          <i class="feather icon-briefcase bg-info update-icon"></i>
                      </div>
                      <div class="col">
                          <h6><a class="" href="{{ route('message-board.show', $message->uuid) }}">{{ $message->subject }}</a></h6>
                          <p class="text-muted m-b-0 d-inline">{{ $message->created_at->format('d/m/Y H:i') }}</p>
                          <p class="text-muted m-b-0">
                              {{ html_entity_decode(strip_tags(substr($message->content, 0, 240))) }}...
                          </p>
                          <br/>
                          <span class="label label-{{ array_random(['info', 'success', 'primary', 'danger']) }}">{{ $message->type->name }}</span>
                      </div>
                  </div>

              @endforeach
            </div>

            @else

              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-bell-slash fa-2x"></i></h1>
                      <br/>
                      <h6 class="font-bold no-margins">
                          Voce não possui nenhum recado até o momento.
                      </h6>
                  </div>
              </div>

            @endif

        </div>
    </div>

</div>

@endsection
