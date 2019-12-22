@extends('partials.template-report')

@section('content')

<table class="table table-bordered table-style" style="width:auto;margin-bottom:50px;">

  <thead>
    <tr>
        <td class="text-center" colspan="2"><h4><b> TRANSFERÊNCIA DE ATIVO</b> </h4></td>
        <td class="text-center" style="vertical-align:middle;"><img style="padding:3px;vertical-align:middle;" class="img" width="86" src="{{ asset('images/logo-provider.png') }}" alt="" /></td>
    </tr>
    <tr>
        <td colspan="2">
          <address>
              <p><b>Código: #{{ str_pad($transfer->id, 6, "0", STR_PAD_LEFT) }}</b></p>

              <p><b>Criada Por:</b> {{ $transfer->user->person->name }}</p>

              <p><b>Assunto/Motivo:</b> {{ $transfer->subject }}</p>
              <p><b>Descrição:</b> {{ $transfer->description }}</p>

              <p><b>Destino:</b>

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


          </address>
        </td>

        <td colspan="1">

          <p><b>Data Solicitação:</b> {{ $transfer->created_at->format('d/m/Y H:i') ?? '-' }}</p>
          <p><b>Data Agendamento:</b> {{ $transfer->scheduled_to ? $transfer->scheduled_to->format('d/m/Y') : '-' }}</p>
          <p><b>Data Retirada:</b> {{ $transfer->withdrawn_at ? $transfer->withdrawn_at->format('d/m/Y') : '-' }}</p>
          <p><b>Data Devolução:</b> {{ $transfer->returned_at ? $transfer->returned_at->format('d/m/Y') : '-' }}</p>

        </td>

    </tr>

    <tr>
      <th style="width:230px">Item</th>
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
        <td colspan="3">Assinatura do Solicitante:</td>
    </tr>

    <tr>
        <td colspan="3"></td>
    </tr>

    <tr>
        <td colspan="3"><p class="text-center">Devolução:</p></td>
    </tr>

    <tr>
        <td colspan="1"><b>Data de Devolução: __/__/_____</b></td>
        <td colspan="2"><b>Assinatura do Conferente:</b></td>
    </tr>

  </tbody>
  <tfoot>

  </tfoot>

</table>

@stop
