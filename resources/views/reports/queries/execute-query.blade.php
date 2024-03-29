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
                        <a href="{{ route('tables.index') }}"> Queries </a>
                    </li>
                    @if($query)
                    <li class="breadcrumb-item">
                        <a href="{{ route('tables.show', $query->uuid) }}"> Informações </a>
                    </li>
                    @endif
                    <li class="breadcrumb-item"><a href="#!">Resultado</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

    @if($parametrosR)
    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-header">
              <h5>Query: {{ $query->label ?? $query->name ?? null }}</h5>
              <span>Formulário de Pesquisa</span>
          </div>
          <div class="card-block">

            <form>
                @foreach($parametrosR as $pr)
                    {!! $pr !!}
                @endforeach
              <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-flash"> </span>Executar</button>
            </form>

          </div>
      </div>
    </div>
    @endif

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Tabela: {{ $query->label ?? $query->name ?? null }}</h5>
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

                                    @php
                                      //dd($item);
                                    @endphp
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
                    <tr><td colspan="{{ count($result) }}"></td></tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>

@endsection
