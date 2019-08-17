@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Pedidos de Compra</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Pedidos de Compra</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">
      <nav class="navbar navbar-light bg-faded m-b-30 p-10">
          <ul class="nav navbar-nav">
              <li class="nav-item active">
                  <a class="nav-link" href="#!">Filtros: <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#!" id="bydate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-clock-time"></i> Data</a>
                  <div class="dropdown-menu" aria-labelledby="bydate">
                      <a class="dropdown-item" href="?date=recente">Recente</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="?date=hoje">Hoje</a>
                      <a class="dropdown-item" href="?date=ontem">Ontem</a>
                      <a class="dropdown-item" href="?date=semana">Nesta Semana</a>
                      <a class="dropdown-item" href="?date=mes">Neste Mês</a>
                      <a class="dropdown-item" href="?date=ano">Neste Ano</a>
                  </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-chart-histogram-alt"></i>Situação</a>
                  <div class="dropdown-menu" aria-labelledby="bystatus">
                      <a class="dropdown-item" href="?status=">Todos</a>
                      <div class="dropdown-divider"></div>
                      @foreach(\App\Helpers\Helper::purchasingStatus() as $item)
                          <a class="dropdown-item" href="?status={{$item}}">{{$item}}</a>
                      @endforeach
                  </div>
              </li>
              @if(auth()->user()->isAdmin())
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#!" id="bystatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-users-alt-5"></i>Usuário</a>
                      <div class="dropdown-menu" aria-labelledby="bystatus">
                          <a class="dropdown-item" href="?user=">Todos</a>
                          <div class="dropdown-divider"></div>
                          @foreach(\App\Helpers\Helper::users() as $user)
                              <a class="dropdown-item" href="?user={{$user->id}}">{{$user->person->name}}</a>
                          @endforeach
                      </div>
                  </li>
              @endif

          </ul>
          <div class="nav-item nav-grid">
              @permission('create.chamados')
                <a href="{{route('purchasing.create')}}" class="btn bottom-right btn-primary btn-sm pull-right">Nova Solicitação</a>
              @endpermission
          </div>

      </nav>
    </div>

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Listagem de Pedidos De Compra</h5>
          <span>Pedidos De Compra</span>
      </div>
      <div class="card-block">
          <div class="table-responsive">
              <table class="table table-striped table-bordered">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Solicitante</th>
                          <th style="width: 35%;">Motivo</th>
                          <th>Situação</th>
                          <th>Cadastro</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>

                  @forelse ($purchasings as $purchasing)

                    @php

                      $status = $purchasing->status;

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
                          <th scope="row">{{ $purchasing->id }}</th>
                          <td>{{ $purchasing->user->person->name }}</td>
                          <td style="white-space: normal;">{{ $purchasing->motive }}</th>
                          <td><span class="label label-{{$bgColor}}"> {{$purchasing->status}} </span></td>
                          <td>{{ $purchasing->created_at->format('d/m/Y H:i') }}
                              <label class="label label-inverse-{{ $bgColor }}">{{ $purchasing->created_at->diffForHumans() }}</label>
                          </td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                              @permission('view.ativos')
                                <a href="{{route('purchasing.show', ['id' => $purchasing->uuid])}}" class="dropdown-item">Visualizar </a>
                              @endpermission

                              @permission('edit.ativos')
                                <a href="{{route('purchasing.edit', ['id' => $purchasing->uuid])}}" class="dropdown-item">Editar </a>
                              @endpermission

                              @permission('edit.ativos')
                                <a data-route="{{ route('purchasing.destroy', ['id' => $purchasing->uuid]) }}" style="cursor:pointer" class="dropdown-item text-danger btnRemoveItem">Remover </a>
                              @endpermission

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
