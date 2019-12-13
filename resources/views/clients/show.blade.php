@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Clientes</h4>
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
                        <a href="{{ route('clients.index') }}"> Clientes </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Informações</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">

      <div class="card-block">

        @permission('create.clientes')
            <a href="{{route('employees.create', ['client' => $client->uuid])}}" class="btn btn-success btn-sm"><i class="fas fa-user-plus"></i> Novo Funcionário</a>
        @endpermission

        @permission('create.clientes')
            <a href="{{route('client_employees_create', $client->uuid)}}" class="btn btn-warning btn-sm"><i class="fas fa-user-plus"></i> Adicionar Funcionários em Massa</a>
        @endpermission

        @permission('create.clientes')
            <a href="{{route('client_addresses_create', $client->uuid)}}" class="btn btn-primary btn-sm"><i class="fas fa-map-marked-alt"></i> Novo Endereço</a>
        @endpermission

        @permission('create.documentos')
            <a href="{{route('documents.create', ['client' => $client->uuid])}}" class="btn btn-primary btn-sm"><i class="fas fa-file"></i> Novo Documento Entrega</a>
        @endpermission

        @permission('edit.clientes')
            <a href="{{route('clients.edit', ['id' => $client->uuid])}}" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Editar</a>
        @endpermission

      </div>
  </div>

  <div class="row">

      <div class="col-md-6 col-xl-3">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Funcionários</h5>
                      <p class="p-t-10 m-b-0 text-c-pink">Funcionários cadastrados na Empresa</p>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-users st-icon bg-c-pink txt-lite-color"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">{{ $client->employees->count() }}</h3>
                      <span class="f-right bg-c-pink"><a class="text-white" href="{{ route('employees.index', ['find' => 1, 'client' => $client->uuid]) }}">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 col-xl-3">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Endereços</h5>
                      <p class="p-t-10 m-b-0 text-c-yellow">Endereços das unidades da Empresa</p>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-map-pin st-icon bg-c-yellow"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">{{ $client->addresses->count() }}</h3>
                      <span class="f-right bg-c-yellow"><a class="text-white" href="{{ route('client_addresses', ['client' => $client->uuid]) }}">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 col-xl-3">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Protocolos</h5>
                      <p class="p-t-10 m-b-0 text-c-green">Ordens de Entrega geradas.</p>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-file-text st-icon bg-c-green"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">{{ $client->deliveries->count() }}</h3>
                      <span class="f-right bg-c-green"><a class="text-white" href="{{ route('delivery-order.index', ['find' => 1, 'client' => $client->uuid]) }}">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-6 col-xl-3">
          <div class="card widget-statstic-card">
              <div class="card-header">
                  <div class="card-header-left">
                      <h5>Documentos</h5>
                      <p class="p-t-10 m-b-0 text-c-blue">Documentos do Cliente.</p>
                  </div>
              </div>
              <div class="card-block">
                  <i class="feather icon-file-text st-icon bg-c-blue"></i>
                  <div class="text-left">
                      <h3 class="d-inline-block">{{ $client->documents->count() }}</h3>
                      <span class="f-right bg-c-blue"><a class="text-white" href="{{ route('client-documents.index', ['client' => $client->uuid]) }}">Acessar</a></span>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-8 col-md-12">
          <div class="card user-card-full">
              <div class="row m-l-0 m-r-0">
                  <div class="col-sm-4 bg-c-green user-profile">
                      <div class="card-block text-center text-white">
                          <h4 class="f-w-600">{{ $client->name}}</h4>
                          @if($client->active)
                              <i class="fa fa-circle text-success"></i> Ativo
                          @else
                              <i class="fa fa-circle text-danger"></i> Inativo
                          @endif

                      </div>
                  </div>
                  <div class="col-sm-8">
                      <div class="card-block">
                          <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informações</h6>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">CNPJ</p>
                                  <h6 class="text-muted f-w-400">{{ $client->document }}</h6>
                              </div>
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Contrato</p>
                                  <h6 class="text-muted f-w-400">Contrato: {{ $client->contract->name }}</h6>
                              </div>
                          </div>
                          <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Entregas</h6>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Cobrar Entrega?</p>
                                  <h6 class="text-muted f-w-400">Cobrar Entrega?: {{ $client->charge_delivery ? 'Sim' : 'Não' }}</h6>
                              </div>
                              <div class="col-sm-6">
                                  <p class="m-b-10 f-w-600">Entrega de Documentos?</p>
                                  <h6 class="text-muted f-w-400">{{ $client->deliver_documents ? 'Sim' : 'Não' }}</h6>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-2 col-md-6">
          <div class="card feed-card">
              <div class="card-header">
                  <h5>Telefone</h5>
                  <span>Contatos do Cliente</span>
                  <div class="card-header-right">
                      <ul class="list-unstyled card-option">
                          <li><a class="btn btn-sm btn-outline-success" href="{{route('phones.create', ['client' => $client->uuid])}}">Novo</a></li>
                      </ul>
                  </div>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-styling">
                          <tbody>

                            @foreach($client->phones as $phone)
                              <tr>
                                  <td>
                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tooltip"></span>

                                    <div class="dropdown-menu dropdown-menu-right b-none services-list" x-placement="bottom-end" style="position: absolute; transform: translate3d(735px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="{{route('phones.edit', $phone->uuid)}}"><i class="icofont icofont-edit"></i> Editar</a>
                                        <a class="dropdown-item btnRemoveItem" href="#!" data-route="{{route('phones.destroy', $phone->uuid)}}"><i class="icofont icofont-ui-delete"></i> Remover</a>
                                    </div>
                                  </td>
                                  <td>{{ $phone->number }}</td>
                              </tr>
                            @endforeach

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-xl-2 col-md-6">
          <div class="card feed-card">
              <div class="card-header">
                  <h5>E-mail</h5>
                  <span>Contatos do Cliente</span>
                  <div class="card-header-right">
                      <ul class="list-unstyled card-option">
                          <li><a class="btn btn-sm btn-outline-success" href="{{route('email.create', ['client' => $client->uuid])}}">Novo</a></li>
                      </ul>
                  </div>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-styling">
                          <tbody>

                            @foreach($client->emails as $email)
                              <tr>
                                  <td>
                                    <span class="dropdown-toggle addon-btn text-muted f-right service-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="tooltip"></span>

                                    <div class="dropdown-menu dropdown-menu-right b-none services-list" x-placement="bottom-end" style="position: absolute; transform: translate3d(735px, 49px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        <a class="dropdown-item" href="{{route('email.edit', $email->uuid)}}"><i class="icofont icofont-edit"></i> Editar</a>
                                        <a class="dropdown-item btnRemoveItem" href="#!" data-route="{{route('email.destroy', $email->uuid)}}"><i class="icofont icofont-ui-delete"></i> Remover</a>
                                    </div>
                                  </td>
                                  <td>{{ $email->email }}</td>
                              </tr>
                            @endforeach

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-12">

          <div class="card">
              <div class="card-header">
                  <h5>Treinamentos</h5>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-styling">
                          <thead>
                              <tr class="table-primary">
                                <th>Nome</th>
                                <th>Curso</th>
                                <th>Data</th>
                                <th>Certificado</th>
                              </tr>
                          </thead>
                          <tbody>
                            @foreach($client->employees as $employee)
                              @foreach($employee->trainings as $training)

                                  @if($training->status == 'FINALIZADA')
                                      @continue;
                                  @endif

                                  <tr>
                                      <td>
                                          <p>{{ $employee->name }}</p>
                                      </td>
                                      <td>
                                          {{$training->team->course->title}}<br/><a href="{{ route('teams.show', $training->team->uuid) }}" class="card-title"><small>Turma: #{{ str_pad($training->team->id, 6, "0", STR_PAD_LEFT) }}</small></a>
                                      </td>
                                      <td>
                                          <p>{{$training->team->start->format('d/m/Y H:i')}} até {{$training->team->end->format('d/m/Y H:i')}}</p>
                                      </td>
                                      <td>
                                        <a target="_blank" href="{{route('team_certified', [$training->uuid])}}"
                                          class="btn btn-sm btn-outline-success">Gerar Certificado</a>
                                      </td>
                                  </tr>
                              @endforeach
                            @endforeach
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>

      </div>

  </div>

</div>

@endsection

@section('scripts')

<script>

  var formUpload = $("#formUpload");
  var modalForm = $("#uploadDocuments");

  formUpload.on('submit', function(e) {

      //e.preventDefault();

      modalForm.modal('hide');

      window.swal({
        title: 'Em progresso',
        text: 'o upload esta em andamento.',
        type: 'info',
        showConfirmButton: false,
        allowOutsideClick: false
      })

      //formUpload.submit();

  });

</script>

@endsection
