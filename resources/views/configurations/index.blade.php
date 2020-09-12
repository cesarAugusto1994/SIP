@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Configurações</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Configurações</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">
                  <li><a href="{{ route('configurations.create') }}" class="btn btn-success">Novo</a></li>
              </ul>
          </div>
      </div>
      <div class="card-block">
        <div class="table-responsive">
            <table class="table table-hover mails m-0 table table-actions-bar">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th style="width:100px">#</th>
                </tr>
                </thead>

                <tbody>
                  @foreach($configs as $config)
                    <tr>
                        <td>
                            {{ $config->name }}
                        </td>

                        <td>
                            {{ $config->description }}
                        </td>

                        <td>
                            @if(strlen($config->value) < 150)

                              @if($config->type_id == 3)
                                <img width="64" src="{{ route('image',['link'=>$config->value]) }}" class="img-thumbnail" alt="">
                              @else
                                  {{ $config->value }}
                              @endif


                            @else
                                {{ 'Texto longo' }}
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('configurations.edit', $config->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>

                        </td>

                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
      </div>
  </div>
</div>

@stop
