@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Documentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Documentos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="row">

      <div class="col-xl-12 col-lg-12 filter-bar">

        <div class="card">
            <div class="card-block">
                <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">

                    @permission('create.documentos')
                      <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('documents.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Documento</a>
                    @endpermission

                    @permission('create.documentos')
                      <a class="btn btn-sm btn-primary waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('documents_create_for_client')}}"><i class="icofont icofont-paper-plane"></i> Novos Documentos Por Cliente</a>
                    @endpermission

                    @permission('create.documentos')
                      <a class="btn btn-sm btn-warning waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery_order_create_many')}}"><i class="icofont icofont-paper-plane"></i> Gerar Remessas de Entrega</a>
                    @endpermission

                </div>
            </div>
        </div>
      </div>

    </div>

    @if($lava)

    <div class="row">

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
                  {!! $lava->render('BarChart', 'Empresa', 'chart-div-priority') !!}
              </div>
          </div>
      </div>

    </div>

    @endif

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
                              <input type="text" class="form-control" name="code" placeholder="Código do Documento">
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
                              <select class="form-controls select2" name="status">
                                <option value="">Situação</option>
                                @foreach(\App\Helpers\Helper::documentStatuses() as $item)
                                  <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-12">
                              <select class="form-controls select2" name="type">
                                <option value="">Tipo</option>
                                @foreach(\App\Helpers\Helper::documentTypes() as $item)
                                  <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-12">
                              <select class="form-control select-client" name="client">
                              </select>
                          </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-sm-12">
                              <select class="form-control select-employees" name="employee" id="employees">
                                  <option value="">Selecionar Funcionário<option>
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
      </div>

      <div class="col-lg-9">
          <!-- Recent Orders card start -->
          <div class="card">
              <div class="card-header">
                  <h5>Documentos Recentes</h5>
                  <span>Registros retornados: {{ $quantity }}</span>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-hover table-styling">
                          <thead>
                              <tr class="table-inverse">
                                  <th>No.</th>
                                  <th>Tipo</th>
                                  <th>Cliente</th>
                                  <th>Opções</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($documents->sortByDesc('id') as $document)

                            @php

                              $status = $document->status->id;

                              $bgColor = 'success';

                              switch($status) {
                                case '1':
                                  $bgColor = 'primary';
                                  break;
                                case '2':
                                  $bgColor = 'warning';
                                  break;
                                case '3':
                                  $bgColor = 'success';
                                  break;
                                case '4':
                                  $bgColor = 'danger';
                                  break;
                              }

                              @endphp

                              <tr>
                                  <td><a href="{{ route('documents.show', $document->uuid) }}" class="card-title">#{{ str_pad($document->id, 6, "0", STR_PAD_LEFT) }}</a> <span data-toggle="tooltip" data-original-title="Adicionado em {{ $document->created_at->format('d/m/Y') }} - {{ $document->created_at->diffForHumans() }}"><i class="icofont icofont-question-circle"></i></span></td>
                                  <td>
                                    <p><a href="{{route('documents.show', ['id' => $document->uuid])}}">{{ $document->type->name }} </a></p>
                                    <span class="label label-{{$bgColor}}"> {{$document->status->name}} </span>
                                  </td>
                                  <td><a href="{{route('clients.show', ['id' => $document->client->uuid])}}">{{ $document->client->name }}</a><br/>
                                    @if($document->employee)
                                    <small>Funcionário: {{ $document->employee->name ?? '' }}</small>
                                    @endif
                                    @if($document->reference)
                                    <br/><small>Referência: {{ $document->reference ?? '' }}</small>
                                    @endif
                                  </td>

                                  <td>

                                    @if($document->status_id == 1)

                                      @permission('create.ordem.entrega')
                                        <a href="{{route('delivery-order.create', ['client' => $document->client->uuid, 'document[]' => $document->uuid])}}" class="btn btn-primary btn-sm btn-block"><i class="fa fa-truck"></i>Gerar Entrega</a>
                                      @endpermission

                                      @permission('delete.documentos')
                                        <a href="#!" data-route="{{route('documents.destroy', ['id' => $document->uuid])}}" class="btn btn-danger btn-sm btn-block btnRemoveItem"><i class="fa fa-trash"></i> Remover</a>
                                      @endpermission

                                    @endif

                                  </td>

                              </tr>
                            @endforeach

                              <tr class="text-center">
                                  <td colspan="5">{{ $documents->links() }}</td>
                              </tr>

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>

      </div>



    </div>

</div>

@endsection
