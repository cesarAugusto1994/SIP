@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tabela: {{ $table->label ?? $table->name }}</h4>
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
                        <a href="{{ route('menus.index') }}"> Tabelas </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('tables.show', $table->uuid) }}"> Informações </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">CRUD</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>CRUD | Tabela: {{ $table->label ?? $table->name }}</h5>
      </div>
      <div class="card-block">

        <form class="formValidation" data-parsley-validate method="post" action="{{route('table_store_query', $table->uuid)}}">
            @csrf
            <div class="row m-b-30">

                <div class="col-md-12">

                  <div class="form-group">
                      <label class="col-form-label">Nome</label>
                      <div class="input-group">
                        <input type="text" required name="name" placeholder="informe o nome da busca" class="form-control">
                      </div>
                  </div>

                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">CRUD</label>
                      <div class="input-group">
                        <select required class="select2 colunas" name="crud">
                            <option selected value="Selecionar">Selecionar</option>
                            <option value="Inserir">Inserir</option>
                            <option value="Atualizar">Atualizar</option>
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Colunas</label>
                      <div class="input-group">
                        <select required class="select2 colunas" id="columns" multiple name="select[]">
                            @foreach($table->columns as $column)
                                <option value="{{ $column->uuid }}">{{ $column->label ?? $column->name }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Unir Com</label>
                      <div class="input-group">
                        <select class="select2" multiple name="inner[]">

                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Onde</label>
                      <div class="input-group">
                        <select class="select2" multiple name="where[]">
                            @foreach($table->columns as $column)
                                <option value="{{ $column->uuid }}">{{ $column->label ?? $column->name }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Agrupado Por</label>
                      <div class="input-group">
                        <select class="select2" multiple name="groupBy[]">
                            @foreach($table->columns as $column)
                                <option value="{{ $column->uuid }}">{{ $column->label ?? $column->name }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Ordenado Por</label>
                      <div class="input-group">
                        <select class="select2" multiple name="orderBy[]">
                            @foreach($table->columns as $column)
                                <option value="{{ $column->uuid }}">{{ $column->label ?? $column->name }}</option>
                            @endforeach
                        </select>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label class="col-form-label">Limite</label>
                      <div class="input-group">
                        <select class="select2" name="limit">
                            <option value="">Tudo</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="all">Tudo</option>
                        </select>
                      </div>
                  </div>
                </div>

            </div>

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('tables.show', $table->uuid) }}">Cancelar</a>

        </form>

      </div>
  </div>

</div>

@endsection
