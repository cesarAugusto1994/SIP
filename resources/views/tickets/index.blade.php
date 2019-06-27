@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Chamados</h4>
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
                        <h6 class="text-muted m-b-0">Chamados</h6>
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
                        <h6 class="text-muted m-b-0">Chamados Abertos</h6>
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
                        <h6 class="text-muted m-b-0">Chamados Finalizados</h6>
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
                        <h4 class="text-c-pink f-w-600">{{ $canceled }}</h4>
                        <h6 class="text-muted m-b-0">Chamados Cancelados</h6>
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
      <div class="card-block">

        <div class="table-responsive">
            <table class="table table-hover table-borderless">
                <thead>
                    <tr>
                        <th>Assunto</th>
                        <th>Situação</th>
                        <th>Solicitante</th>
                        <th>Criado em</th>
                        <th class="text-right">Opções</th>
                    </tr>
                </thead>
                <tbody>

                  @foreach($tickets as $ticket)

                      @php

                        $status = $ticket->logs->last()->status->id;

                        $bgColor = 'success';

                        switch($status) {
                          case '2':
                            $bgColor = 'warning';
                            break;
                          case '3':
                            $bgColor = 'primary';
                            break;
                          case '4':
                            $bgColor = 'primary';
                            break;
                          case '5':
                            $bgColor = 'danger';
                            break;
                        }

                      @endphp

                      <tr>
                          <td>{{$ticket->type->name}}</td>
                          <td><label class="label label-lg label-{{ $bgColor }}">{{ $ticket->logs->last()->status->name }}</label></td>
                          <td>{{$ticket->user->person->name}}</td>
                          <td>
                            {{ $ticket->created_at->format('d/m/Y H:i') }}
                            <br/>
                            <label class="label label-inverse-primary">{{ $ticket->created_at->diffForHumans() }}</label>
                          </td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-inverse btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                <a class="dropdown-item" href="{{ route('tickets.show', $ticket->uuid) }}"><i class="icofont icofont-check"></i>Visualizar</a>

                            </div>

                          </td>

                      </tr>

                  @endforeach

                </tbody>
            </table>
        </div>

      </div>
  </div>
</div>

@endsection
