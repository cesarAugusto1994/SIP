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
                        <h4 class="text-c-yellow f-w-600">{{ $total }}</h4>
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
                        <h4 class="text-c-pink f-w-600">{{ $canceled }}</h4>
                        <h6 class="text-muted m-b-0">Cancelados</h6>
                    </div>
                    <div class="col-4 text-right">
                        <i class="feather icon-download f-28"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($lava)

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div"></div>
                {!! $lava->render('DonutChart', 'Tipo', 'chart-div') !!}
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div-user"></div>
                {!! $lava->render('DonutChart', 'Usuario', 'chart-div-user') !!}
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div-status"></div>
                {!! $lava->render('DonutChart', 'Status', 'chart-div-status') !!}
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-block">
                <div id="chart-div-priority"></div>
                {!! $lava->render('BarChart', 'Prioridade', 'chart-div-priority') !!}
            </div>
        </div>
    </div>

    @endif

  </div>

  <div class="row">



    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                  @permission('create.chamados')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('tickets.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Chamado</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">
                <form method="get" action="?">
                    <input type="hidden" name="find" value="1"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="code" placeholder="Código do chamado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" id="daterange" class="form-control" placeholder="Periodo">

                            <input type="hidden" name="start" id="start" value="{{ now()->format('d/m/Y') }}"/>
                            <input type="hidden" name="end" id="end" value="{{ now()->format('d/m/Y') }}"/>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control" name="status">
                              <option value="">Situação</option>
                              @foreach(\App\Helpers\Helper::ticketStatus() as $status)
                                <option value="{{ $status->id }}">{{$status->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="user">
                              <option value="">Usuários</option>
                              @foreach(\App\Helpers\Helper::users()->sortBy('person.name') as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="type">
                              <option value="">Tipo</option>
                              @foreach(\App\Helpers\Helper::ticketCategories() as $category)
                                <optgroup label="{{ $category->name }}">
                                @foreach($category->types as $type)
                                  @if(!$type->active) @continue; @endif
                                  <option value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                                </optgroup>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-block p-t-10">
                <div class="task-right">
                    <div class="task-right-header-status">
                        <span data-toggle="collapse">Prioridades</span>
                        <i class="icofont icofont-rounded-down f-right"></i>
                    </div>

                    <div class="taskboard-right-progress">
                        <h6>Altissima</h6>
                        <div class="progress progress-striped progress-mini">
                          <div style="width:{{ $highest }}%;background-color: #fe5d70;"
                            class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('highest') }}">
                            {{ $highest }}</div>
                        </div>

                        <hr/>

                        <h6>Alta</h6>
                        <div class="progress progress-striped progress-mini">
                          <div style="width:{{ $high }}%;background-color: #fe9365;"
                            class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('high') }}">
                            {{ $high }}</div>
                        </div>

                        <hr/>

                        <h6>Normal</h6>
                        <div class="progress progress-striped progress-mini">
                          <div style="width:{{ $normal }}%;background-color: #0ac282;"
                            class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('normal') }}">
                            {{ $normal }}</div>
                        </div>

                        <hr/>

                        <h6>Baixa</h6>
                        <div class="progress progress-striped progress-mini">
                          <div style="width:{{ $low }}%;background-color: #01a9ac;"
                            class="progress-bar {{ \App\Helpers\Helper::statusTaskPriorityCollor('low') }}">
                            {{ $low }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <!-- Recent Orders card start -->
        <div class="card">
            <div class="card-header">
                <h5>Chamados Recentes</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                                <th>No.</th>
                                <th>Situação</th>
                                <th>Descrição</th>
                                <th>Solicitante</th>
                                <th>Abertura/Finalização</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($tickets as $ticket)

                            <tr>
                                <td><a href="{{ route('tickets.show', $ticket->uuid) }}" class="card-title">#{{ str_pad($ticket->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                <td>
                                  <span class="label label-{{\App\Helpers\Helper::getColorFromValue($ticket->status->id)}} f-right"> {{$ticket->status->name}} </span>
                                </td>
                                <td>
                                  <p data-toggle="tooltip" data-original-title="{{ html_entity_decode(strip_tags(substr($ticket->description, 0, 800))) }}">
                                      {{$ticket->type->category->name}} - {{$ticket->type->name}}
                                  </p>
                                </td>
                                <td>
                                  {{ $ticket->user->person->name }}
                                </td>
                                <td>
                                  {{$ticket->created_at->format('d/m/Y H:i')}}
                                  <br/>
                                  <label class="label label-inverse-primary">{{ $ticket->created_at->diffForHumans() }}</label>
                                </td>
                            </tr>
                          @endforeach

                          <tr>
                            <td colspan="6">
                              {{ $tickets->links() }}
                            </td>
                          </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{ $tickets->links() }}

  </div>

</div>
</div>

@endsection
