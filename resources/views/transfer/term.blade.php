<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Termo de Responsabilidade</title>
    <link rel="stylesheet" href="{{ asset('adminty\components\bootstrap\css\bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\style.css') }}?v1.0.1">

    <style>

      @page {
          margin-top: 20px;
          margin-left: 0;
          margin-right: 0;
          margin-bottom: 100;
      }

      @page {
      	header: page-header;
      	footer: page-footer;
        body: wrapper-content;
      }

      .page-header {
        margin-top: -80px !important;
      }

      p:last-child { page-break-after: auto; }
      .wrapper-content { padding: 2em 2em;}

      .font-10 {
        font-size: 10px;
      }

    </style>

</head>

<body class="pace-done">

  <div class="page-body">

      <div class="card-block">

            <div style="">
              <img class="img" style="max-height:80px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
              <h4 class="text-center">OERDEM DE TRANSFERÊNCIA</h4>
            </div>
            <div class="p-20">
              <p><b>Código: #{{ str_pad($transfer->id, 6, "0", STR_PAD_LEFT) }}</b></p>

              <p>Assunto/Motivo: {{ $transfer->subject }}</p>
              <p>Descrição: {{ $transfer->description }}</p>

              <p>Destino:

                @if($transfer->localization == 'Usuário')
                  {{ $transfer->user->person->name }} - {{ $transfer->user->person->department->name }}
                @elseif($transfer->localization == 'Departamento')
                  {{ $transfer->department->name }}
                @elseif($transfer->localization == 'Unidade')
                  {{ $transfer->unit->name }}
                @elseif($transfer->localization == 'Fornecedor')
                  {{ $transfer->vendor->name }}
                @else
                  -
                @endif

              </p>

              <p>Data de Agendamento: {{ $transfer->scheduled_to ? $transfer->scheduled_to->format('d/m/Y') : '-' }}</p>
              <p>Data de Retirada: {{ $transfer->withdrawn_at ? $transfer->withdrawn_at->format('d/m/Y') : '-' }}</p>
              <p>Data de Devolução: {{ $transfer->returned_at ? $transfer->returned_at->format('d/m/Y') : '-' }}</p>

              <table class="table table-lg table-styling">
                <thead>
                  <tr>
                    <th colspan="3">Itens da Tranferência</th>
                  </tr>

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
              <p>Me responsabilizo por manter os equipamentos em perfeito estado de conservação e funcionamento e me comprometo a pagar o valor correspondente caso danifique ou perca algum deles por uso inadequadro, negligência ou extravio, hipóteses em que comunicarei imediatamente a Provider Saúde e Segurança do Trabalho.
              </p>
              <br>
              <br>
              @if($due > 0)
                  <p>O empréstimo é realizado pelo prazo de {{ $due }} dia(s), quando os equipamentos devem ser restituídos à Provider Saúde e Segurança do Trabalho, embora esta possa solicitá-los antecipadamente a seu critério.</p>
              @endif
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

  <script>
    //window.print();
  </script>

</body>

</html>
