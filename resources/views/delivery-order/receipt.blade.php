@extends('print')

@section('content')

<div class="card">
    <div class="row invoice-contact">
        <div class="col-md-8">
            <div class="invoice-box row">
                <div class="col-sm-8">
                    <table class="table table-responsive invoice-table table-borderless">
                        <tbody>
                            <tr>
                                <td><img width="200" src="{{ asset('images/logo-provider.png') }}" class="m-b-10" alt=""></td>

                            </tr>
                            <tr>
                                <td>Provider Saúde e Seguraça do Trabalho</td>
                            </tr>
                            <tr>
                                <td>Av. Paulino Muller, 885 - Ilha de Santa Maria, Vitória - ES, 29051-035</td>
                            </tr>
                            <tr>
                                <td><a href="mailto:provider@provider-es.com.br">provider@provider-es.com.br</a>
                                </td>
                            </tr>
                            <tr>
                                <td>(27) 3322-0030</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4 col-sm-6 f-right" style="right:0">
                  @php
                      $route = route('start_delivery', $delivery->uuid);
                  @endphp

                    {!! QrCode::size(100)->generate($route); !!}
                </div>

            </div>
        </div>
        <div class="col-md-4">
        </div>
    </div>
    <div class="card-block">
        <div class="row invoive-info">

            <div class="col-md-4 col-xs-12 invoice-client-info">
                <h6>Informações do Cliente :</h6>
                <h6 class="m-0">{{ $delivery->client->name }}</h6>
                <p class="m-0 m-t-10">{{ $delivery->address->street }}, {{ $delivery->address->number }}, {{ $delivery->address->district }}, {{ $delivery->address->city }} - {{ $delivery->address->zip }}</p>

            </div>
            <div class="col-md-4 col-sm-6">
                <h6>Ordem de Entrega :</h6>
                <table class="table table-responsive invoice-table invoice-order table-borderless">
                    <tbody>
                        <tr>
                            <th>Data :</th>
                            <td>{{ $delivery->delivery_date ? $delivery->delivery_date->format('d/m/Y') : '' }}</td>
                        </tr>
                        <tr>
                            <th>COD :</th>
                            <td>
                                #{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table  invoice-detail-table">
                        <thead>
                            <tr class="thead-default">
                                <th>Descrição</th>
                                <th>Referencia</th>
                                <th>Entregue</th>
                            </tr>
                        </thead>
                        <tbody>

                          @foreach($delivery->documents as $document)
                          @php
                              $document = $document->document;
                          @endphp

                            <tr>
                                <td>
                                    <h6>{{ $document->type->name }}</h6>
                                    <p>{{ $document->employee->name ?? '' }} </p>
                                </td>
                                <td>{{ $document->reference ?? '' }}</td>
                                <td>Sim <input type="checkbox"/>
                                    Não <input type="checkbox"/></td>
                            </tr>

                          @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Ordem de Entrega :</th>
                            <td>#{{ str_pad($delivery->id, 6, "0", STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th>Entregador :</th>
                            <td>{{ $delivery->user->person->name }}</td>
                        </tr>
                        <tr>
                            <th>Data/Hora :</th>
                            <td>__/__/____ __:__</td>
                        </tr>
                        <tr>
                            <th>Assinatura :</th>
                            <td> ___________________________________________ </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h6>Termos e Declaração :</h6>
                <p>DECLARO PARA DEVIDOS FINS QUE RECEBI OS ASO`S E/OU DOCUMENTOS DESCRITOS ACIMA, DEVIDAMENTE ASSINADOS, DATADOS E CARIMBADOS </p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script>

    $(document).ready(function() {


    });

    </script>

@stop
