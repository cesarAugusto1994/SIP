@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Entrega</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Ordem de Entrega</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Conferência</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

      <div class="col-lg-3">
          <div class="card">
              <div class="card-header">
                  <h5>Conferência</h5>
                  <div class="card-header-right">
                      <ul class="list-unstyled card-option">
                          <li><i class="feather icon-maximize full-card"></i></li>
                      </ul>
                  </div>
              </div>
              <div class="card-block">
                <form method="post" class="form-horizontal" action="{{route('delivery-order.store')}}">
                    {{csrf_field()}}

                    @foreach($documents as $document)
                      <input type="hidden" name="documents[]" value="{{ $document->uuid }}"/>
                    @endforeach

                    <div class="form-group {!! $errors->has('delivered_by') ? 'has-error' : '' !!}">
                      <label class="col-sm-12">Entregador</label>
                        <div class="col-sm-12">
                          <select class="select2 select-entregador" data-search-user="{{ route('user_search') }}" name="delivered_by" required>
                              <option value="">Selecione um entregador</option>
                              @foreach($delivers as $deliver)
                                  <option value="{{$deliver->uuid}}">{{$deliver->name}}</option>
                              @endforeach
                          </select>
                          {!! $errors->first('delivered_by', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group {!! $errors->has('delivery_date') ? 'has-error' : '' !!}">
                      <label class="col-sm-12">Entrega</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control inputDate" name="delivery_date"/>
                            {!! $errors->first('delivery_date', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group {!! $errors->has('annotations') ? 'has-error' : '' !!}">
                      <label class="col-sm-12">Anotações</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" name="annotations"></textarea>
                            {!! $errors->first('annotations', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <button class="btn btn-custom btn-block">Gerar</button>
                </form>
              </div>
          </div>
      </div>

      <div class="col-lg-9">

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Informações do Cliente e Documento</h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-maximize full-card"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-block">

                        <div class="view-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <div class="row">
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="">
                                                    <table class="table m-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Descrição</th>
                                                                <td>{{ $document->description }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Tipo</th>
                                                                <td>{{ $document->type->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Cliente</th>
                                                                <td>{{ $document->client->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Telefone</th>
                                                                <td>{{ $document->client->phone }}</td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Email</th>
                                                                <td>{{ $document->client->email }}</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- end of table col-lg-6 -->
                                            <div class="col-lg-12 col-xl-6">
                                                <div class="">
                                                    <table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Gerado Por</th>
                                                                <td>{{ $document->creator->person->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Gerado Em</th>
                                                                <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Entregador</th>
                                                                <td><span id="entregador"><span class="text-navy">Selecione o Entregador</span></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- end of table col-lg-6 -->
                                        </div>
                                        <!-- end of row -->
                                    </div>
                                    <!-- end of general info -->
                                </div>
                                <!-- end of col-lg-12 -->
                            </div>
                            <!-- end of row -->
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
          <div class="card">
              <div class="card-header">
                  <h5>Endereço</h5>
                  <div class="card-header-right">
                      <ul class="list-unstyled card-option">
                          <li><i class="feather icon-maximize full-card"></i></li>
                      </ul>
                  </div>
              </div>
              <div class="card-block">

                <div class="view-info">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="general-info">
                                <div class="row">

                                  <div class="col-lg-12 col-xl-12">
                                      <div class="table-responsive">
                                          <table class="table m-0">
                                              <tbody>
                                                  <tr>
                                                      <th scope="row">Rua </th>
                                                      <td>{{ $document->address->street }}, {{ $document->address->number }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">Bairro</th>
                                                      <td>{{ $document->address->district }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">Cidade</th>
                                                      <td>{{ $document->address->city }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">CEP</th>
                                                      <td>{{ $document->address->zip }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">Complemento</th>
                                                      <td>{{ $document->address->complement }}</td>
                                                  </tr>
                                                  <tr>
                                                      <th scope="row">Referencia</th>
                                                      <td>{{ $document->address->reference }}</td>
                                                  </tr>

                                              </tbody>
                                          </table>
                                      </div>
                                  </div>

                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

              </div>
          </div>
      </div>

        </div>

      </div>

  </div>
</div>

@endsection

@section('scripts')
    <script>

      $(document).ready(function() {

        let selectEntregador = $(".select-entregador");
        let entregador = $("#entregador");

        selectEntregador.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

          let self = $(this);
          let route = self.data('search-user');
          let value = self.val();

          $.ajax({
            type: 'GET',
            url: route + '?param=' + value,
            async: true,
            success: function(response) {

              if(response.success) {

                let result = response.data;

                entregador.html("");
                let html = result.name + " - " + result.cpf;
                entregador.append(html);
              }


            }
          })


        });

      });

    </script>
@stop
