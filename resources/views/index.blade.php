@extends('base')

@section('content')

<!-- Page-header start -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Bem Vindo ao SIP</h4>
                    <span>Sistema Integrado Provider</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">

      <!--

        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-yellow text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">New Customer</p>
                            <h4 class="m-b-0">852</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-user f-50 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-green text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Income</p>
                            <h4 class="m-b-0">$5,852</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-credit-card f-50 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-pink text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Ticket</p>
                            <h4 class="m-b-0">42</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-book f-50 text-c-pink"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-c-blue text-white">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Orders</p>
                            <h4 class="m-b-0">$5,242</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-shopping-cart f-50 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-pie-chart bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Use Space</span>
                    <h4>49/50GB</h4>
                    <div>
                        <span class="f-left m-t-10 text-muted">
                            <i class="text-c-blue f-16 feather icon-alert-triangle m-r-10"></i>Get more space
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-home bg-c-pink card1-icon"></i>
                    <span class="text-c-pink f-w-600">Revenue</span>
                    <h4>$23,589</h4>
                    <div>
                        <span class="f-left m-t-10 text-muted">
                            <i class="text-c-pink f-16 feather icon-calendar m-r-10"></i>Last 24 hours
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-alert-triangle bg-c-green card1-icon"></i>
                    <span class="text-c-green f-w-600">Fixed Issue</span>
                    <h4>45</h4>
                    <div>
                        <span class="f-left m-t-10 text-muted">
                            <i class="text-c-green f-16 feather icon-tag m-r-10"></i>Tracked at microsoft
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-twitter bg-c-yellow card1-icon"></i>
                    <span class="text-c-yellow f-w-600">Followers</span>
                    <h4>+562</h4>
                    <div>
                        <span class="f-left m-t-10 text-muted">
                            <i class="text-c-yellow f-16 feather icon-watch m-r-10"></i>Just update
                        </span>
                    </div>
                </div>
            </div>
        </div>

      -->

        <div class="col-md-8 col-sm-12">
            <div class="card latest-update-card">
                <div class="card-header">
                    <h5>Gestão à Vista</h5>
                    <span>Mural de recados com informes e anúncios da empresa ou setor</span>

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
                                <a class="" href="{{ route('message-board.show', $message->uuid) }}">
                                  <h6>{{ $message->subject }}</h6>
                                  <p class="text-muted m-b-0">
                                      {{ html_entity_decode(strip_tags(substr($message->content, 0, 240))) }}...
                                  </p>
                                </a>
                                  <br/>
                                  <span class="label label-{{ array_random(['info', 'success', 'primary', 'danger']) }}">{{ $message->type->name }}</span>
                                  @if($message->important)
                                      <span class="label label-danger }}">Importante</span>
                                  @endif
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

        <div class="col-md-4 col-sm-12">

          <div class="card user-activity-card">
              <div class="card-header">
                <h5>Atividades</h5>
                <span>Fluxo de atividades do usuário</span>

              </div>
              <div class="card-block">

                @if($activities->isNotEmpty())

                  @foreach($activities->take(4) as $activity)

                    <div class="row m-b-25">
                        <div class="col">
                            <h6 class="m-b-5">{{ $activity->created_at->format('H:i') }}</h6>
                            <p class="text-muted m-b-0">{{ $activity->description }} {{ html_entity_decode(\App\Helpers\Helper::getTagHmtlForModel($activity->subject_type, $activity->subject_id)) }}</p>
                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>{{ \App\Helpers\TimesAgo::render($activity->created_at) }}</p>
                        </div>
                    </div>

                  @endforeach

                  <div class="text-center">
                      <a href="{{ route('activities.index') }}" class="b-b-primary text-primary">Visualizar todas atividades</a>
                  </div>

                @else

                  <div class="widget white-bg no-padding">
                      <div class="p-m text-center">
                          <h1 class="m-md"><i class="fas fa-history fa-2x"></i></h1>
                          <br/>
                          <h6 class="font-bold no-margins">
                              Nenhum log registrado até o momento.
                          </h6>
                      </div>
                  </div>

                @endif

              </div>
          </div>

        </div>
    </div>
</div>

@stop
