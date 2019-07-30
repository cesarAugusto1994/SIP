@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Atividades</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Atividades</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Log de Atividades</h5>
      </div>
      <div class="card-block">

        @if($activities->isNotEmpty())

          @foreach($activities as $activity)

            <div class="row m-b-25">
                <div class="col">
                    <h6 class="m-b-5">{{ $activity->created_at->format('d/m/Y H:i') }}</h6>
                    <p class="text-muted m-b-0">{{ $activity->description }} {{ html_entity_decode(\App\Helpers\Helper::getTagHmtlForModel($activity->subject_type, $activity->subject_id)) }}</p>
                    <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>{{ \App\Helpers\TimesAgo::render($activity->created_at) }}</p>
                </div>
            </div>

          @endforeach

        @else

          <div class="widget white-bg no-padding">
              <div class="p-m text-center">
                  <h1 class="m-md"><i class="far fa-bell-slash fa-2x"></i></h1>
                  <br/>
                  <h5 class="font-bold no-margins">
                      Nenhum log registrado até o momento.
                  </h4>
              </div>
          </div>

        @endif

      </div>
  </div>
</div>

@endsection
