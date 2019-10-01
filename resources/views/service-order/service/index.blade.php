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
                    <li class="breadcrumb-item"><a href="#!">Serviços</a>
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
                  @permission('create.ativos')
                    <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('services.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Ativo</a>
                  @endpermission
              </div>
          </div>
      </div>
    </div>

  </div>

  <div class="row">

    <div class="col-lg-3">

        <div class="card">
            <div class="card-header">
                <h5><i class="icofont icofont-filter m-r-5"></i>Filtro</h5>
            </div>
            <div class="card-block">
                <form method="get" action="?">
                    <input type="hidden" name="find" value="1"/>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="search" placeholder="Código do Serviço, Nome">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-control select2" name="service_type_id">
                              <option value="">Tipo</option>
                              @foreach(\App\Helpers\Helper::serviceTypes() as $item)
                                  <option value="{{$item->id}}">{{$item->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="">
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="icofont icofont-job-search m-r-5"></i> Pesquisar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h5>Serviços Cadastrados</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                              <th>#</th>
                              <th>Nome</th>
                              <th>Descrição</th>
                              <th>Tipo</th>
                              <th>Ativo</th>
                              <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($services as $service)
                            <tr>
                                <th scope="row">{{ $service->id }}</th>
                                <td>  <a href="{{route('services.show', ['id' => $service->uuid])}}">{{ $service->name }}</a></td>
                                <td>{{ $service->description }}</td>
                                <td>{{ $service->type->name }}</td>
                                <td>
                                  @if($service->active)
                                      <span class="label label-success">Ativo</span>
                                  @else
                                      <span class="label label-danger">Inativo</span>
                                  @endif</td>

                                <td class="dropdown">

                                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @permission('edit.ativos')
                                      <a href="{{route('services.edit', ['id' => $service->uuid])}}" class="dropdown-item">Editar </a>
                                    @endpermission

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
    @if(!empty($services))
    {{ $services->links() }}
    @endif
  </div>

</div>

@endsection
