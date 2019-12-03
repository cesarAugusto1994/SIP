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
                    <li class="breadcrumb-item"><a href="{{ route('delivery-packings.index') }}">Remessa de Entrega</a></li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a></li>
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

                  @permission('create.ordem.entrega')
                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('delivery-packings.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Remessa</a>
                  @endpermission

              </div>
          </div>
      </div>
    </div>

  </div>

  <form method="post" action="{{ route('delivery-packings.store') }}">
    @csrf

  <div class="row">

    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">

                    <div class="row">

                    <div class="col-md-12">

                        <div class="form-group {!! $errors->has('delivered_by') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Entregador</label>
                            <div class="input-group">
                              <select class="form-control select-entregador select2" data-search-user="{{ route('user_search') }}" name="delivered_by" required>
                                <optgroup label="Entregadores">
                                  @foreach($delivers as $deliver)
                                      <option value="{{$deliver->uuid}}">{{$deliver->name}}</option>
                                  @endforeach
                                </optgroup>
                                <optgroup label="Outros Usuários">
                                  @foreach($anotherPeople as $person)
                                      <option value="{{$person->uuid}}">{{$person->name}}</option>
                                  @endforeach
                                </optgroup>
                              </select>
                              {!! $errors->first('delivered_by', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                    </div>

                    <div class="col-md-12">

                        <div class="form-group {!! $errors->has('delivery_date') ? 'has-error' : '' !!}">
                          <label class="col-form-label">Entrega</label>
                            <div class="input-group">
                                <input type="text" autocomplete="off" class="form-control inputDate" name="delivery_date" required/>
                                {!! $errors->first('delivery_date', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>

                    </div>

                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Nova Remessa
                        </button>
                    </div>

            </div>
        </div>
    </div>

    <div class="col-lg-9">

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
                            <th>
                                #
                            </th>
                            <th>Ordem No.</th>
                            <th>Distancia</th>
                            <th>Situação</th>
                            <th>Cliente</th>
                            <th>Previsão / Entrega</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach($result as $deliveries)
                          @foreach($deliveries as $delivery)

                          <tr>
                              <td><input class="js-switch select-item" type="checkbox" name="deliveries[]" value="{{ $delivery['uuid'] }}"/></td>
                              <td><a href="{{ route('delivery-order.show', $delivery['uuid']) }}" class="card-title">#{{ $delivery['id'] }}</a></td>
                              <td>{{$delivery['distance']}}</td>
                              <td>
                                <span class="label label-{{$delivery['color']}} f-right"> {{$delivery['status']}} </span>
                              </td>
                              <td><a href="{{route('clients.show', ['id' => $delivery['client_uuid']])}}">{{ $delivery['client'] }}</a><br/>
                                <label class="label label-inverse-primary">{{$delivery['address']}}</label>
                              </td>
                              <td>{{$delivery['date']}}</td>

                          </tr>
                          @endforeach
                        @endforeach
                      </tbody>
                  </table>
              </div>

            </div>
        </div>

    </div>
  </div>

  </form>

</div>

@endsection
