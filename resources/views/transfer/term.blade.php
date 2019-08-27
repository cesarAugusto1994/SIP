<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\style.css') }}?v1.0.1">

    <style>



    </style>

</head>

<body class="pace-done">

  <div class="pcoded-main-container">
      <div class="pcoded-wrapper">
          <div class="pcoded-content">
              <div class="pcoded-inner-content">
                  <div class="main-body">
                      <div class="page-wrapper">

                        <div class="page-body">
                          <div class="card">

                            <div class="card-block">

                              <div style="">
                                <img class="img" style="max-height:100px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
                                <h3 class="text-center">Termo de Responsabilidade</h3>
                              </div>
                                  <div class="p-50">
                                    <br>
                                    <br>
                                    <p>Eu ____________________________________________, do setor de _______________________, inscrito(a) no CPF sob o nº __________________, declaro que recebi de {{ auth()->user()->person->name }}, a título de empréstimo, para uso profissional e exclusivo, os equipamentos abaixo especificados:
                                    </p>
                                    <br>
                                    <table class="table table-bordered table-striped" style="font-size:14px">
                                      <thead>
                                        <tr>
                                          <th>Item</th>
                                          <th>Matricula</th>
                                          <th>Serial</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($transfer->items as $item)
                                          <tr>
                                            <td>{{ $item->stock->product->name }}</td>
                                            <td>{{ $item->stock->equity_registration_code }}</td>
                                            <td>{{ $item->stock->serial }}</td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                    <br>
                                    <p>Me responsabilizo por manter os equipamentos em perfeito estado de conservação e funcionamento e me comprometo a pagar o valor correspondente caso danifique ou perca algum deles por uso inadequadro, negligência ou extravio, hipóteses em que comunicarei imediatamente a Provider Saúde e Segurança do Trabalho.
                                    </p>
                                    <br>
                                    <br>
                                    @if($due > 0)
                                        <p>O empréstimo é realizado pelo prazo de {{ $due }} dia(s), quando os equipamentos devem ser restituídos à Provider Saúde e Segurança do Trabalho, embora esta possa solicitá-los antecipadamente a seu critério.</p>
                                    @else
                                    <p>Vitória - ES, {{ now()->format('d/m/Y') }}.</p>
                                    <p class="text-center">_______________________________________</p>
                                    <p class="text-center">Assinatura do Responsável</p>
                                  </div>

                                  <div style="border-top:1px dashed black"></div>

                                  <div class="p-50">
                                    <p class="text-center p-b-20">Data de Devolução: __/__/_____</p>
                                    <p class="text-center">_______________________________________</p>
                                    <p class="text-center">Assinatura do Responsável</p>
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



  <script>
    //window.print();
  </script>

</body>

</html>
