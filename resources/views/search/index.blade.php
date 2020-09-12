@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Pesquisar</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Pesquisar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="row">
      <div class="col-sm-12">
          <!-- Search result 2 card start -->
          <div class="card">
              <div class="card-block">
                  <div class="row seacrh-header">
                      <div class="col-lg-4 offset-lg-4 offset-sm-3 col-sm-6 offset-sm-1 col-xs-12">
                        <form method="get" action="{{ route('search') }}">
                          <div class="input-group input-group-button input-group-primary">
                              <input name="q" type="text" class="form-control" placeholder="Pesquisar...">
                              <button class="btn btn-primary input-group-addon">Pesquisar</button>
                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Search result 2 card end -->
          <h4 class="m-b-20"><b>{{ count($results) }}</b> Registros Encontrados</h4>
          <div class="row">
              <!-- Search result found start -->
              <div class="col-lg-12 col-xl-12 search2 search-result">
                  <div class="card card-main">
                      <div class="card-block">
                          <div class="row">
                              <div class="col-sm-12">
                                @foreach($results as $result)
                                  <div class="search-content">
                                    @if($result['image'])
                                      <img class="card-img-top" src="{{ $result['image'] }}" alt="">
                                    @endif
                                      <div class="card-block" style="padding-top:20px">
                                          <a href="{{ $result['url'] }}"><h5 class="card-title">
                                              {{ $result['header'] }}
                                          </h5></a>
                                          <p class="card-text text-muted">{{ $result['content'] }}</p>
                                          <p class="card-text"><small class="text-muted">{{ $result['date'] }}</small></p>
                                      </div>
                                  </div>
                                @endforeach

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection
