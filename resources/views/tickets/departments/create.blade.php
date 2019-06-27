@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tipos de Chamados: {{ $type->name }}</h4>
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
                        <a href="{{ route('ticket-types.index') }}"> Tipos de Chamados </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Adicionar Departmento</h5>
      </div>
      <div class="card-block">

        <form method="post" action="{{route('ticket-type-departments.store')}}">
            @csrf

            <input type="hidden" name="type_id" value="{{ $type->uuid }}"/>

            <div class="row m-b-30">

              <div class="col-md-4">

                <div class="form-group">
                    <label class="col-form-label">Departamento</label>
                    <div class="input-group">
                      <select class="form-control m-b select2" name="department_id" required>
                          <option value="">Informe o departamento</option>
                          @foreach(\App\Helpers\Helper::departments() as $department)

                              @if(in_array($department->id, $listDeptsAdded))
                                  @continue;
                              @endif

                              <option value="{{$department->id}}">{{$department->name}}</option>

                          @endforeach
                      </select>
                    </div>
                </div>

              </div>

              <div class="col-md-4">

                <div class="form-group">
                    <label class="col-form-label">Departamentos já vinculados</label>
                    <div class="input-group">

                      @if($type->departments->isNotEmpty())

                      <table class="table table-borderless">
                          <tbody>

                            @foreach($type->departments as $type)

                                <tr>
                                    <td>{{$type->department->name}}</td>
                                </tr>

                            @endforeach

                          </tbody>
                      </table>

                      @endif

                    </div>
                </div>

              </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-sm" href="{{ route('ticket-types.index') }}">Cancelar</a>

        </form>

      </div>
  </div>
</div>

@endsection
