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



        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Chamados</p>
                            <h4 class="m-b-0">{{ \App\Helpers\Helper::ticketsTotal() }}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-bookmark f-50 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Cham. Realizados</p>
                            <h4 class="m-b-0">{{ \App\Helpers\Helper::ticketsClosedTotal() }}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-check-square f-50 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Tarefas</p>
                            <h4 class="m-b-0">{{ \App\Helpers\Helper::tasksTotal() }}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-layers f-50 text-c-pink"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <p class="m-b-5">Mensagens Recentes</p>
                            <h4 class="m-b-0">{{ \App\Helpers\Helper::unSeenEmailsCount() }}</h4>
                        </div>
                        <div class="col col-auto text-right">
                            <i class="feather icon-bell f-50 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-pie-chart bg-c-blue card1-icon"></i>
                    <span class="text-c-blue f-w-600">Espaço Usado</span>
                    <h4>{{ \App\Helpers\Helper::usedSpace() }}/{{ \App\Helpers\Helper::totalSpace() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-users bg-c-pink card1-icon"></i>
                    <span class="text-c-pink f-w-600">Usuários</span>
                    <h4>{{ \App\Helpers\Helper::users()->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-message-square bg-c-green card1-icon"></i>
                    <span class="text-c-green f-w-600">Mensagens</span>
                    <h4>{{ \App\Helpers\Helper::messages() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card widget-card-1">
                <div class="card-block-small">
                    <i class="feather icon-activity bg-c-yellow card1-icon"></i>
                    <span class="text-c-yellow f-w-600">Usuários Online</span>
                    <h4>{{ \App\Helpers\Helper::onlineUsers() }}</h4>
                </div>
            </div>
        </div>
        @endif

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
                                  <p class="text-muted m-b-0 d-inline">{{ $message->created_at->diffForHumans() }}</p>
                                  <i class="feather icon-briefcase bg-info update-icon"></i>
                              </div>
                              <div class="col">
                                <a class="" href="{{ route('message-board.show', $message->uuid) }}">
                                  <h6>{{ $message->subject }}</h6>
                                  <p class="text-muted m-b-0">
                                      {{ html_entity_decode(strip_tags(substr($message->content, 0, 500))) }} ...
                                  </p>
                                </a>
                                  <br/>
                                  <span class="label label-{{ array_random(['info', 'success', 'primary', 'warning']) }}">{{ $message->type->name }}</span>
                                  @if($message->important)
                                      <span class="label label-danger }}">Importante</span>
                                  @endif

                                  <span class="badge badge-inverse-success">Visualizado por: {{ $message->messages->where('status', 'VISUALIZADO')->count() }}</span>
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

        <div class="col-xl-4 col-md-12">

          <div class="row">

            <div class="col-xl-12 col-md-12">
                <div class="card feed-card">
                    <div class="card-header">
                        <h5>Próximos Compromissos</h5>
                    </div>
                    <div class="card-block">
                      @forelse(\App\Helpers\Helper::listNextSchedules() as $schedule)
                        <div class="row m-b-30">
                            <div class="col-auto p-r-0">
                                <i class="feather icon-bell bg-simple-c-blue feed-icon"></i>
                            </div>
                            <div class="col">
                                <h6 class="m-b-5"><a href="{{ route('schedules.show', $schedule['uuid']) }}">{{ $schedule['title'] }} </a><span class="text-muted f-right f-13">{{ $schedule['start'] }}</span></h6>
                            </div>
                        </div>
                      @empty
                        <div class="widget white-bg no-padding">
                            <div class="p-m text-center">
                                <h1 class="m-md"><i class="fas fa-history fa-2x"></i></h1>
                                <br/>
                                <h6 class="font-bold no-margins">
                                    Nenhum compromisso agendado.
                                </h6>
                            </div>
                        </div>
                      @endforelse
                    </div>
                </div>
            </div>

          </div>

        </div>

    </div>
</div>

@stop
