<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('images\favicon.ico') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="{{ asset('adminty\components\bootstrap\css\bootstrap.min.css') }}">
    <link href="{{ asset('adminty\css\style.css') }}"/>

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

      .table>tbody>tr>td {
        padding: 6px;
        padding-bottom: 3px;
        font-size: 12px;
      }

    </style>

</head>

<body>
  <div class="card-body">
    <table class="table table-bordered">
        <tbody>
        <tr>
          <td colspan="4" valign="top" width="594">
          <p><strong>Nome/Raz&atilde;o Social:</strong> {{ $order->client->name }}</p>
          <p><strong>N&ordm; do CONTRATO:</strong> 011282/2019</p>
          </td>
          </tr>
        <tr>
          <td colspan="3" valign="top" width="425">
            @if($order->client->addresses->isNotEmpty())
          <p><strong>Rua, Avenida, Logradouro:</strong> {{ $order->client->addresses->first()->description }}</p>
            @endif
          </td>
          <td valign="top" width="168">
          <p><strong>CEP:</strong></p>
          </td>
        </tr>
        <tr>
          <td valign="top" width="170">
          <p><strong>CNPJ:</strong> {{ $order->client->document }}</p>
          </td>
          <td valign="top" width="189">
          <p><strong>Tel / Nome do respons&aacute;vel:</strong></p>
          <p>CIZENANDO RANGEL</p>
          <p>(27) 3198-0966</p>
          </td>
          <td colspan="2" valign="top" width="235">
          <p><strong>E-mail: </strong></p>
          <p>cizenandonetto@saude.es.gov.br</p>
          </td>
        </tr>
        </tbody>
    </table>

    <p>
        Pelo presente instrumento particular, que representa este contrato, de um lado, PROVIDER ADMINISTRACAO E SERVICOS LTDA, com sede à Av. Paulino Muller, 885 - Jucutuquara - Vitória - ES, inscrita no CNPJ sob o número CNPJ: 07.110.470/0001-57, daqui por diante denominada simplesmente CONTRATADA, e de outro lado, o proponente do presente contrato, acima qualificado, daqui por diante denominado simplesmente CONTRATANTE, IRMANDADE DA SANTA CASA DE MISERICÓRDIA DE VITÓRIA, pessoa jurídica de direito privado, com sede na Rua Doutor João Santos Neves, nº. 143 – Vila Rubim – Vitória – ES, inscrita no CNPJ Nº. 28.141.190/0001-86, Inscrição Estadual: isenta, tendo como representante legal Dra. Maria da Penha Rodrigues D’Avila, portadora do RG nº. 217.892/SSP-ES e CPF: 557.761.677-87 neste ato representada pelo dirigente que adiante assina, resolvem ajustar o presente contrato, com base nas cláusulas e condições que seguem.
    </p>

  </div>

  <script>
      //window.print();
      window.onfocus=function() {
          //window.close();
      }
  </script>

</body>

</html>
