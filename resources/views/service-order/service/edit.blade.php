@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Serviços</h4>
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
                        <a href="{{ route('services.index') }}"> Serviços </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Editar Serviço</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('services.update', $service->uuid)}}">
            @csrf
            {{ method_field('PUT') }}
            <div class="row m-b-30">

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" value="{{ $service->name }}" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Descrição</label>
                      <div class="input-group">
                        <input type="text" name="description" value="{{ $service->description }}" class="form-control">
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Tipo</label>
                      <div class="input-group">
                        <select class="form-control select2" name="service_type_id">
                            <option value="">Selecione</option>
                            @foreach(\App\Helpers\Helper::serviceTypes() as $item)
                                <option value="{{$item->id}}" {{ $service->service_type_id == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                      <label class="col-form-label" for="active">Ativo</label>
                      <div class="input-group">
                          <input class="js-switch" type="checkbox" id="active" name="active" data-plugin="switchery" checked value="{{ 1 }}">
                      </div>
                      {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                  </div>
                </div>

                <div class="col-md-12">

                  <div class="form-group">
                      <label class="col-form-label">Tipo de Chamados</label>
                      <div class="input-group">
                        <select class="form-control m-b select2" name="ticket_types[]" multiple>
                            <option value="">Informe o tipo de chamado</option>
                            @foreach(\App\Helpers\Helper::ticketCategories() as $category)
                              <optgroup label="{{ $category->name }}">
                              @foreach($category->types as $type)
                                @if(!$type->active) @continue; @endif
                                <option value="{{$type->uuid}}" {{ in_array($type->id, $ticketTypes) ? 'selected' : '' }}>{{$type->name}}</option>
                              @endforeach
                              </optgroup>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                <div class="col-md-12">

                  <div class="form-group">
                      <label class="col-form-label">Treinamentos</label>
                      <div class="input-group">
                        <select class="form-control m-b select2" name="courses[]" multiple>
                            <option value="">Informe o curso</option>
                            @foreach(\App\Helpers\Helper::courses() as $couse)
                                <option value="{{$couse->uuid}}" {{ in_array($couse->id, $courses) ? 'selected' : '' }}>{{$couse->title}}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>

                </div>

                @foreach($values as $value)

                  <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><b>Custo</b> {{ $value->contract->name }} </label>
                        <div class="input-group">
                          <input type="text" autocomplete="off" value="{{ number_format($value->cost, 2) }}" name="cost-{{ $value->contract->uuid }}" class="form-control inputMoney">
                        </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-form-label"><b>Valor</b> {{ $value->contract->name }} </label>
                        <div class="input-group">
                          <input type="text" autocomplete="off" value="{{ number_format($value->value, 2) }}" name="value-{{ $value->contract->uuid }}" class="form-control inputMoney">
                        </div>
                    </div>
                  </div>

                @endforeach

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('services.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
