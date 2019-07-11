@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Seus Chamados</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Chamados</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-yellow f-w-600">{{ $tickets->count() }}</h4>
                        <h6 class="text-muted m-b-0">Total</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-bar-chart f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-green f-w-600">{{ $opened }}</h4>
                        <h6 class="text-muted m-b-0">Abertos</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-file-text f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
      <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue f-w-600">{{ $finished }}</h4>
                        <h6 class="text-muted m-b-0">Finalizados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-calendar f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-c-blue f-w-600">{{ $canceled }}</h4>
                        <h6 class="text-muted m-b-0">Cancelados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-download f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Chamados</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                  @permission('create.chamados')
                    <li><a class="btn btn-sm btn-success btn-round" href="{{route('tickets.create')}}">Novo Chamado</a></li>
                  @endpermission

              </ul>
          </div>
      </div>
      <div class="card-block row">

        @forelse(auth()->user()->tickets->sortByDesc('created_at') as $ticket)
          <div class="col-md-12 col-lg-4">
              <div class="card">
                  <div class="card-block text-center">
                      <h4 class="m-t-20">{{$ticket->type->name}}</h4>
                      <p class="m-b-20">{{ $ticket->created_at->format('d/m/Y H:i') }}<br/>
                        <label class="label label-inverse-primary">{{ $ticket->created_at->diffForHumans() }}</label>
                      </p>

                  </div>

                  @php

                    $status = $ticket->logs->last()->status->id;

                    $bgColor = 'green';

                    switch($status) {
                      case '2':
                        $bgColor = 'yellow';
                        break;
                      case '3':
                        $bgColor = 'yellow';
                        break;
                      case '4':
                        $bgColor = 'blue';
                        break;
                      case '5':
                        $bgColor = 'pink';
                        break;
                    }

                  @endphp

                  <div class="card-footer bg-c-{{ $bgColor }}">
                      <div class="row align-items-center">
                          <div class="col-8">
                              <p class="text-white m-b-0">{{ $ticket->logs->last()->status->name }}</p>
                          </div>
                          <div class="col-4">

                            <div class="dropdown-success dropdown open">
                                <button class="btn btn-success btn-sm dropdown-toggle waves-effect waves-light " type="button" id="dropdown-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Opções</button>
                                <div class="dropdown-menu" aria-labelledby="dropdown-3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{ route('tickets.show', $ticket->uuid) }}">Visualizar</a>
                                </div>
                            </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
        @empty

        <div class="col-md-12 col-lg-12">

          <div class="widget white-bg no-padding">
              <div class="p-m text-center">
                  <h1 class="m-md"><i class="fas fa-bullhorn fa-2x"></i></h1>
                  <br/>
                  <h6 class="font-bold no-margins">
                      Voce não possui nenhum chamado até o momento.
                  </h6>
              </div>
          </div>

        </div>

        @endforelse

      </div>
  </div>
</div>

@endsection
