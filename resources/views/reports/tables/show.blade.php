@extends('base')

@section('css')
<style>

    .buttonsi > button {
        display: none;
    }

    .buttonsi > .btn-group {
        display: none;
    }

    .buttonsi:hover > button {
        float: right;
        display: table;
    }

    .buttonsi:hover > .btn-group {
        float: right;
        display: table;
    }

</style>
@stop

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tabela: {{ $table->name }}</h4>
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
                        <a href="{{ route('tables.index') }}"> Tabelas </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">
                  <a class="btn btn-mini btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('table_import_columns', $table->uuid)}}"><i class="icofont icofont-paper-plane"></i> Importar Colunas</a>

                  <a class="btn btn-mini btn-primary btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('table_execute', $table->uuid)}}"><i class="icofont icofont-paper-plane"></i> Executar</a>

                  <a class="btn btn-mini btn-primary btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{ route('table_create_query', $table->uuid) }}"><i class="icofont icofont-paper-plane"></i> Criar Query</a>
              </div>

          </div>
      </div>
    </div>

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Buscas</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <tbody>
                    @foreach($table->queries as $query)
                        <tr>
                            <th><a href="{{ route('query_execute', $query->uuid) }}">{{ $query->name }}</a>
                                <button data-route="{{ route('queries.destroy', $query->uuid) }}"
                                        class="btn btn-danger pull-right btn-mini btnRemoveItem">Remover
                                </button>
                                <a href="#!" class="btn pull-right btn-mini">Editar Query</a>
                            </th>
                        </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Tabela {{ $table->label ?? $table->name }} : Colunas</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>Nome</th>
                          <th>Nome Visível</th>
                          <th>Label</th>
                          <th>Tabela Vinculada</th>
                          <th>Formato</th>
                          <th>Mostrar</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($table->columns as $column)

                      <tr>

                          <td>{{ $column->name }}

                            @if($column->is_primary_key)
                                <span class="label label-danger">PK</span>
                            @endif

                            <br/>
                            <small>Tipo: {{ $column->type }}</small>

                          </td>
                          <td class="buttonsi"><span id="label-{{ $column->uuid }}">{{ $column->label }}</span>

                            @if($column->label)
                                <button data-coluna="{{ $column->uuid }}"
                                  data-url="{{ route('column_set_label', $column->uuid) }}"
                                  class="btn btn-primary btn-mini btnAddIdentificado">
                                    Editar
                                </button>
                            @else
                                <button data-coluna="{{ $column->uuid }}"
                                  data-url="{{ route('column_set_label', $column->uuid) }}"
                                  class="btn btn-success btn-mini btnAddIdentificado">
                                    Adicionar
                                </button>
                            @endif

                          </td>

                          <td class="buttonsi">{{ $column->is_label ? 'Sim' : 'Não' }}

                            @if(!$column->is_label)
                                <button
                                data-url="{{ route('column_add_label', $column->uuid) }}"
                                data-coluna="{{ $column->uuid }}" data-acao="Adicionar" class="btn
                            btn-success btn-mini btnAddLabel">
                                    Adicionar
                                </button>
                            @else
                                <button
                                data-url="{{ route('column_add_label', $column->uuid) }}"
                                data-coluna="{{ $column->uuid }}" data-acao="Remover" class="btn
                            btn-danger btn-mini btnAddLabel">
                                    Remover
                                </button>
                            @endif

                          </td>
                          <td class="buttonsi">
                              @if($column->table_reference_id)
                                  <a href="@if($column->tableReference) {{route('tables.show', $column->tableReference->uuid)}} @endif">
                                    {{ $column->tableReference ? $column->tableReference->label ?? $column->tableReference->name : '' }}</a>

                                    <div class="btn-group" role="group" aria-label="...">
                                        <button data-coluna="{{ $column->uuid }}"
                                          data-route="{{ route('column_set_table_reference', $column->uuid) }}"
                                          data-url="{{ route('tables_list') }}"
                                          class="btn btn-primary btn-mini btnAddTabela">Tocar
                                        </button>
                                        <button data-coluna="{{ $column->uuid }}"
                                          data-route="{{ route('column_set_table_reference', $column->uuid) }}"
                                          data-url="{{ route('tables_list') }}"
                                          class="btn btn-danger btn-mini btnARmTabela">Remover
                                        </button>
                                    </div>

                                @else
                                    <button
                                      data-route="{{ route('column_set_table_reference', $column->uuid) }}"
                                      data-coluna="{{ $column->uuid }}"
                                      data-url="{{ route('tables_list') }}"
                                      class="btn btn-success btn-mini btnAddTabela">
                                        Adicionar
                                    </button>
                                @endif

                          </td>
                          <td class="buttonsi">
                            <span id="format-{{ $column->uuid }}">
                              {{ $column->format ?  $column->format->label ?? $column->format->name : '' }}</span>
                            @if($column->format_id)
                                <button data-route="{{ route('column_set_format', $column->uuid) }}"
                                  data-url="{{ route('column_formats', $column->uuid) }}"
                                  data-coluna="{{ $column->uuid }}" class="btn
                                  btn-primary btn-mini btnAddFormato">
                                    Editar
                                </button>
                            @else
                                <button data-route="{{ route('column_set_format', $column->uuid) }}"
                                  data-url="{{ route('column_formats', $column->uuid) }}"
                                  data-coluna="{{ $column->uuid }}" class="btn
                                  btn-success btn-mini btnAddFormato">
                                    Adicionar
                                </button>
                            @endif

                          </td>
                          <td>
                              <input class="js-switch select-item btnSetShow" data-url="{{ route('column_status', $column->uuid) }}" type="checkbox" {{ $column->show ? 'checked' : '' }} name="documents[]" value="{{ $column->uuid }}"/>
                          </td>

                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function () {

        $('.btnSetShow').change(function () {

            var _this = $(this);

            $.post({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: $(this).data('url'),
                data: {}
            }).done(function (data) {

                notify(data.message, 'inverse');

            })
                .fail(function (data) {
                    swal(
                        'Error!',
                        data.message,
                        'error'
                    )
                });

        });


        $('.btnAddLabel').click(function () {

            var _this = $(this);

            swal({
                title: 'Atenção',
                text: "Deseja " + _this.data('acao') + " esta Label?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Cancelar'
            }).then(function () {

                $.post({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: _this.data('url'),
                    data: {
                        column: _this.data('coluna')
                    }
                }).done(function (data) {

                    swal(
                        'Sucesso!',
                        data.message,
                        'success'
                    ).then(
                        function () {
                            window.location.reload();
                        })

                })
                    .fail(function () {
                        swal(
                            'Error!',
                            data.message,
                            'error'
                        )
                    });

            })

        });

        $('.btnARmTabela').click(function () {

            var _this = $(this);

            $.post({
                type: "POST",
                url: '/api/remover-vinculo-coluna-tabela',
                data: {
                    coluna: _this.data('coluna')
                }
            }).done(function (data) {

                swal(
                    'Sucesso!',
                    data.message,
                    'success'
                ).then(
                    function () {
                        window.location.reload();
                    })

            })
                .fail(function () {
                    swal(
                        'Error!',
                        data.message,
                        'error'
                    )
                });

        });

        $('.btnAddTabela').click(function () {

            var _this = $(this);

            $.get(_this.data('url'), function (data) {

                var data2 = JSON.parse(data);

                swal({
                    title: 'Selecione uma Tabela',
                    input: 'select',
                    inputOptions: data2,
                    inputPlaceholder: 'Selecione a Tabela',
                    showCancelButton: true,
                    inputValidator: function (value) {
                        _this.val(value);
                        return new Promise(function (resolve, reject) {
                            if (value !== '') {
                                resolve()
                            } else {
                                reject('Selecione uma tabela válida')
                            }
                        })
                    }
                }).then(function (result) {

                  if(result.value) {
                    $.post({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: _this.data('route'),
                        data: {
                            table_reference: _this.val(),
                            column: _this.data('coluna')
                        }
                    }).done(function () {

                        notify(data2.message, 'inverse');

                        swal(
                            'Sucesso!',
                            data2.message,
                            'success'
                        ).then(
                            function () {
                                window.location.reload();
                            })

                    })
                        .fail(function () {
                            swal(
                                'Error!',
                                data.message,
                                'error'
                            )
                        });
                    }
                })
            });


        });

        $('.btnAddIdentificado').click(function () {

            var _this = $(this);

            swal({
                title: 'Identificador',
                input: 'text',
                inputPlaceholder: 'Informe Um Nome',
                showCancelButton: true,
                inputValidator: function (value) {
                    _this.val(value);
                    return new Promise(function (resolve, reject) {
                        if (value !== '') {
                            resolve()
                        } else {
                            reject('Selecione uma tabela válida')
                        }
                    })
                }
            }).then(function (result) {

              if(result.value) {

                $.post({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: _this.data('url'),
                    data: {
                        label: _this.val(),
                        column: _this.data('coluna')
                    }
                }).done(function (data) {

                  $("#label-"+_this.data('coluna')).text(_this.val());
                  notify(data.message, 'inverse');

                })
                    .fail(function (data) {
                        swal(
                            'Error!',
                            data.message,
                            'error'
                        )
                    });

                }
            })

        })

        $('.btnAddFormato').click(function () {

            var _this = $(this);

            $.get(_this.data('url'), function (data) {

                var data2 = JSON.parse(data);

                swal({
                    title: 'Formato',
                    input: 'select',
                    inputOptions: data2,
                    inputPlaceholder: 'Selecione um Formato',
                    showCancelButton: true,
                    inputValidator: function (value) {
                        _this.val(value);
                        return new Promise(function (resolve, reject) {
                            if (value !== '') {
                                resolve()
                            } else {
                                reject('Selecione um formato')
                            }
                        })
                    }
                }).then(function (result) {

                  if(result.value) {

                    $.post({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: _this.data('route'),
                        data: {
                            format: _this.val(),
                            column: _this.data('coluna')
                        }
                    }).done(function (data) {

                      $("#format-"+_this.data('coluna')).text(data.data.label);
                      notify(data.message, 'inverse');

                    })
                        .fail(function (data) {
                            swal(
                                'Error!',
                                data.message,
                                'error'
                            )
                        });
                  }

                })
            });

        })

    });

</script>

@stop
