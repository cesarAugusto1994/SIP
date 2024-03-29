@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Transferencia de Ativos</h4>
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
                    <li class="breadcrumb-item"><a href="#!">Nova</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header card bg-c-green update-card">
          <h5 class="text-white">Nova Transferencia</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('transfer.store')}}">
            @csrf

            <div class="row m-b-30">

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Ativo (Produto)</label>
                      <div class="input-group">
                        @if($stock)
                            <p>{{ $stock->product->name }}</p>
                            <input type="hidden" name="stock_id" value="{{ $stock->uuid }}">
                        @else

                          <select class="select2" name="stock_id">
                            @foreach($stocks as $item)
                              <option value="{{ $item->uuid }}">{{ $item->product->name }} - {{ $item->equity_registration_code ?: $item->id }}</option>
                            @endforeach
                          </select>

                        @endif
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Solicitante:</label>
                      <div class="input-group">
                        <select class="form-control select2" data-style="btn-white" name="requester_id" required>
                            @foreach(\App\Helpers\Helper::users()->sortBy('person.name') as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                      <label class="col-form-label">Data Agendamento</label>
                      <div class="input-group">
                        <input type="text" name="scheduled_to" class="form-control inputDate" value="{{ now()->format('d/m/Y') }}" autocomplete="off">
                      </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                      <label class="col-form-label">Data retirada</label>
                      <div class="input-group">
                        <input type="text" name="withdrawn_at" class="form-control inputDate" value="{{ now()->format('d/m/Y') }}" autocomplete="off">
                      </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                      <label class="col-form-label">Data Devolução</label>
                      <div class="input-group">
                        <input type="text" name="returned_at" class="form-control inputDate" autocomplete="off">
                      </div>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                      <label class="col-form-label">Chamado</label>
                      <div class="input-group">
                        <input type="text"  name="ticket_id" class="form-control" placeholder="Código do Chamado">
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Assunto/Motivo</label>
                      <div class="input-group">
                        <input type="text" required name="subject" placeholder="Ex: Treinamento Externo" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <input type="text"  name="description" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Empréstimo para:</label>
                      <div class="input-group">
                        <select class="form-control select2" id="select-owner" name="localization" required>
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::stockLocalization() as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-9" id="div-user" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Usuário:</label>
                      <div class="input-group">
                        <select class="form-control select2" data-style="btn-white" name="user_id" required>
                            @foreach(\App\Helpers\Helper::users()->sortBy('person.name') as $user)
                                <option value="{{$user->id}}">{{$user->person->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-9" id="div-department" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Departmaneto:</label>
                      <div class="input-group">
                        <select class="form-control select2" data-style="btn-white" name="department_id" required>
                            @foreach(\App\Helpers\Helper::departments()->sortBy('name') as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-9" id="div-unit" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Unidade:</label>
                      <div class="input-group">
                        <select class="form-control select2" data-style="btn-white" name="unity_id" required>
                            @foreach(\App\Helpers\Helper::units() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-9" id="div-vendor" style="display:none;">
                  <div class="form-group">
                      <label class="col-form-label">Fornecedor:</label>
                      <div class="input-group">
                        <select class="form-control select2" data-style="btn-white" name="vendor_id">
                            @foreach(\App\Helpers\Helper::vendors() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('transfer.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection

@section('scripts')

<script>

	$(document).ready(function() {

    var owner = $("#select-owner");

    var divUser = $("#div-user");
    var divDepartment = $("#div-department");
    var divUnit = $("#div-unit");
    var divVendor = $("#div-vendor");

    owner.change(function() {

      var self = $(this);
      var value = self.val();

      divUser.hide();
      divDepartment.hide();
      divUnit.hide();
      divVendor.hide();

      if(value == 'Usuário') {

          divUser.show();

      } else if(value == 'Departamento') {

          divDepartment.show();

      } else if(value == 'Unidade') {

          divUnit.show();

      } else if(value == 'Fornecedor') {

          divVendor.show();

      }

    });


  });

</script>

@endsection
