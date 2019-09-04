@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Transferencia de Ativos #{{ $transfer->id }}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('transfer.index') }}"> Transferencia de Ativos </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('transfer.show', $transfer->uuid) }}"> #{{ $transfer->id }} </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Adicionar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Adicionar Itens à transferência </h5>
          <span class="text-success">Itens de Ativo<span>
      </div>
      <div class="card-block">
        <form class="formValidation" data-parsley-validate method="post" action="{{ route('transfer_items_store', $transfer->uuid) }}">
            @csrf
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Selecionar</th>
                            <th>#</th>
                            <th>Item</th>
                            <th>Matricula</th>
                            <th>Situação Atual</th>
                            <th>Localização Atual</th>
                        </tr>
                    </thead>
                    <tbody>

                      @foreach($stocks as $stock)
                        <tr>
                            <th scope="row"><input class="js-switch" value="{{ $stock->id }}" type="checkbox" name="items[]"/></th>
                            <th scope="row">#{{ $stock->id }}</th>
                            <td>{{ $stock->product->name }}</td>
                            <td>{{ $stock->equity_registration_code }}</td>
                            <td>{{ $stock->status }}</td>
                            <td>{{ $stock->localization }}
                              @if($stock->localization == 'Usuário')
                                {{ $stock->user->person->name }}
                              @elseif($stock->localization == 'Departamento')
                                {{ $stock->department->name }}
                              @elseif($stock->localization == 'Unidade')
                                {{ $stock->unit->name }}
                              @elseif($stock->localization == 'Fornecedor')
                                {{ $stock->vendor->name }}
                              @else

                              @endif
                            </td>


                        </tr>
                      @endforeach

                    </tbody>
                </table>
            </div>
            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('transfer.show', $transfer->uuid) }}">Cancelar</a>
          </form>
      </div>
  </div>

</div>

@endsection
