@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Pedidos de Compra</h4>
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
                        <a href="{{ route('purchasing.index') }}"> Pedidos de Compra </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('purchasing.show', $purchasing->purchasing->uuid) }}"> Detalhes </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo Item</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Item do Pedido de Compra </h5>
          <span class="text-success">#{{ $purchasing->purchasing->id }}<span>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('purchasing-item.update', $purchasing->uuid)}}">
            @csrf
            {{ method_field('PUT') }}

            <div class="row m-b-30">

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label">Unidade de Medida</label>
                        <div class="input-group">
                          <select class="form-control" title="Selecione" name="unit" required>
                             <option value="">Selecione...</option>
                              @foreach(\App\Helpers\Helper::metricUnits() as $item)
                                  <option value="{{$item}}" {{ $purchasing->unit == $item ? 'selected' : '' }}>{{$item}}</option>
                              @endforeach
                         </select>
                       </div>
                   </div>
               </div>
               <div class="col-md-7">
                 <div class="form-group">
                       <label class="col-form-label">Descrição do Item</label>
                       <div class="input-group">
                         <input type="text" required name="description" value="{{ $purchasing->description }}" class="form-control" placeholder="Descrição do Item"/>
                       </div>
                   </div>
               </div>
               <div class="col-md-2">
                 <div class="form-group">
                       <label class="col-form-label">Quantidade</label>
                       <div class="input-group">
                         <input type="number" min="1" required name="quantity" value="{{ $purchasing->quantity }}" class="form-control" placeholder="Quantidade de itens"/>
                       </div>
                   </div>
               </div>

           </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('purchasing.show', $purchasing->purchasing->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>

  </script>

@endsection
