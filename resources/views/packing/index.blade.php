@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Remessa de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Remessa de Entrega</a>
                    </li>
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

                  @permission('create.remessa.de.entrega')
                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery-packings.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Remessa</a>
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
                            <input type="text" class="form-control" name="code" placeholder="Código da OE">
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
                            <select class="form-control select2" name="status">
                              <option value="">Situação</option>
                              @foreach(\App\Helpers\Helper::deliveryStatus() as $status)
                                <option value="{{ $status->id }}">{{$status->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select-client" name="client"></select>
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
                <h5>Remessas de Entrega Recentes</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-inverse">
                                <th>Ordem No.</th>
                                <th>Data Prevista</th>
                                <th>Entregador</th>
                                <th>Ordens de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($packings as $delivery)

                            <tr>
                                <td><a href="{{ route('delivery-packings.show', $delivery->uuid) }}" class="card-title">#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                <td>{{ $delivery->delivery_date->format('d/m/Y') }}</td>
                                <td>{{ $delivery->deliver->person->name }}</td>
                                <td>{{ $delivery->items->count() }}</td>

                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{ $packings->links() }}

  </div>

</div>

@endsection
