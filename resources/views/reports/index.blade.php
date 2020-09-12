@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Relatórios</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Relatórios</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

      <div class="col-md-6 col-xl-4">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Tabelas</h5>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-users st-icon bg-c-pink txt-lite-color"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">0</h3>
                      <span class="f-right bg-c-pink"><a class="text-white" href="{{ route('tables.index') }}">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-12 col-xl-4">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Queries</h5>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-map-pin st-icon bg-c-yellow"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">0</h3>
                      <span class="f-right bg-c-yellow"><a class="text-white" href="#">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 col-xl-4">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Logs</h5>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-file-text st-icon bg-c-blue"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">0</h3>
                      <span class="f-right bg-c-blue"><a class="text-white" href="#">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>
      
  </div>

  <div class="row">

    <div class="col-xl-12 col-lg-12 filter-bar">

      <div class="card">
          <div class="card-block">
              <div class=" waves-effect waves-light m-r-10 v-middle issue-btn-group">
                  <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('reports.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Relatório</a>
              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="card">
      <div class="card-header">
          <h5>Relatórios</h5>
          <span>Registros retornados: </span>
      </div>
      <div class="card-block table-border-style">
          <div class="table-responsive">
              <table class="table table-lg table-styling">
                  <thead>
                      <tr class="table-primary">
                          <th>Nome</th>
                          <th>Descrição</th>
                          <th>Opções</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($reports as $report)

                      <tr>

                          <td>{{$report->name}}</td>
                          <td>{{$report->description}}</td>
                          <td>

                            <div class="dropdown-secondary dropdown">
                                <button class="btn btn-default btn-mini dropdown-toggle waves-light b-none txt-muted" type="button" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icofont icofont-navigation-menu"></i></button>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('reports.edit', $report->id)}}"><i class="icofont icofont-ui-edit"></i> Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item waves-light waves-effect" href="{{route('reports.show', $report->id)}}"><i class="icofont icofont-ui-edit"></i> Remover</a>
                                </div>
                            </div>

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
