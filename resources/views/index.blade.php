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

      <div class="col-xl-6 col-md-12">
          <div class="card user-card-full">
              <div class="row m-l-0 m-r-0">
                  <div class="col-sm-4 bg-c-green user-profile">
                      <div class="card-block text-center text-white">
                          <div class="m-b-25">
                              <img style="width:100%" src="{{ route('image', ['link' => \Auth::user()->avatar, 'avatar' => true])}}" class="img-radius" alt="">
                          </div>
                          <h6 class="f-w-600">{{ Auth()->user()->person->name }}</h6>
                          <p>{{ Auth()->user()->person->department->name }}</p>
                          <a href="{{route('user')}}"><i class="feather icon-edit m-t-10 f-16"></i></a>
                      </div>
                  </div>
                  <div class="col-sm-8">
                      <div class="card-block">
                          <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Suas Informações</h6>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">E-mail</p>
                                  <h6 class="text-muted f-w-400">{{ Auth()->user()->email }}</h6>
                              </div>
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Ramal</p>
                                  <h6 class="text-muted f-w-400">{{ Auth()->user()->person->branch }}</h6>
                              </div>
                          </div>
                          <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Suas Atividades</h6>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Último Login</p>
                                  <h6 class="text-muted f-w-400">{{ Auth()->user()->lastLoginAt() ? Auth()->user()->lastLoginAt()->format('d/m/Y H:i') : '-' }}</h6>
                              </div>
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Última Atividade</p>
                                  <h6 class="text-muted f-w-400">{{ auth()->user()->activities->last()->description }}</h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-6 col-md-12">

        <div class="row">

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::ticketsTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Chamados</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::ticketsClosedTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Chamados Concluídos</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::tasksTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Tarefas</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::documentsTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Documentos</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::deliveriesTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Ordens de Entrega</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::teamsTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Treinamentos</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::teamEmloyeesTotal() }}</h4>
                              <h6 class="text-inverse m-b-0">Alunos dos Treinamentos</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::clients()->count() }}</h4>
                              <h6 class="text-inverse m-b-0">Clientes</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-xl-4 col-md-6">
              <div class="card update-card">
                  <div class="card-block">
                      <div class="row align-items-end">
                          <div class="col-12">
                              <h4 class="text-inverse">{{ \App\Helpers\Helper::employees()->count() }}</h4>
                              <h6 class="text-inverse m-b-0">Funcionários</h6>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

        </div>

      </div>



        <div class="col-xl-8 col-md-12 col-sm-12">
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
                        <span>Lista de seus compromissos</span>
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
