@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Queries</h4>
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('tables.show', $table->uuid) }}"> Informações </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Resultado</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Tabela: {{ $table->label ?? $table->name }}</h5>
          <span>Registros retornados: {{ count($result) }}</span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">

                  @if($columns)
                      <thead>
                      <tr class="table-primary">
                          @foreach($columns as $column)
                              <th data-sortable="true">{{ $column }}</th>
                          @endforeach
                      </tr>
                      </thead>
                  @endif

                  <tbody>
                    @foreach($result as $items)

                        <tr>
                            @foreach($items as $item)



                              @if(is_array($item))

                                  @if($item['tabela'])


                                    <td><a href="{{ route('table_query_search', ['id' => $item['parentTable'], 'column' => $item['coluna'], 'value' => $item['valor']]) }}">
                                          @if($item['label']){{ $item['label'] }}@else{{ $item['valor'] }}@endif</a></td>

                                  @else
                                    <td>{!! $item['valor'] !!}</td>
                                  @endif

                              @else
                                <td>{{ $item }}</td>
                              @endif
                            @endforeach
                        </tr>
                    @endforeach
                    <tr><td colspan="{{ $result->count() }}">{{ $result->links() }}</td></tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>

@endsection
