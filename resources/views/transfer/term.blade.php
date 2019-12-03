@extends('partials.template-report')

@section('content')

<table class="table table-bordered table-style">

  <thead>
    <tr>
        <td class="text-center" colspan="2"><h4><b> TRANSFERÊNCIA DE ATIVO</b> </h4></td>
        <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" /></td>
    </tr>
    <tr>
        <td colspan="3" style="padding-left:13px;">
          <address>
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

          </address>
        </td>

    </tr>



    <tr class="table-success">
      <th style="width:100px">Item</th>
      <th>Matricula</th>
      <th style="width:100px">Serial</th>
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

    <tr>
        <td colspan="3"></td>
    </tr>

    <tr>
        <td colspan="3">
          <p>Me responsabilizo por manter os equipamentos em perfeito estado de conservação e funcionamento e me comprometo a pagar o valor correspondente caso danifique ou perca algum deles por uso inadequadro, negligência ou extravio, hipóteses em que comunicarei imediatamente a Provider Saúde e Segurança do Trabalho.</p>
        </td>
    </tr>

    @if($due > 0)
      <tr>
          <td colspan="3"><b><p>O empréstimo é realizado pelo prazo de {{ $due }} dia(s), quando os equipamentos devem ser restituídos à Provider Saúde e Segurança do Trabalho, embora esta possa solicitá-los antecipadamente a seu critério.</p></b></td>
      </tr>
    @endif

    <tr>
        <td colspan="3"></td>
    </tr>



    <tr>
        <td colspan="3"><p class="text-center">Vitória - ES, {{ now()->format('d/m/Y') }}.</p></td>
    </tr>

    <tr>
        <td colspan="3">Assinatura do Responsável:</td>
    </tr>

    <tr>
        <td colspan="3"></td>
    </tr>

    <tr>
        <td colspan="3"><p class="text-center">Devolução:</p></td>
    </tr>

    <tr>
        <td colspan="3">Data de Devolução: __/__/_____</td>
    </tr>

    <tr>
        <td colspan="3">Assinatura do Responsável:</td>
    </tr>



  </tbody>
  <tfoot>

  </tfoot>

</table>

@stop
