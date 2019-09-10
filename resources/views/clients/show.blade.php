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
                    <li class="breadcrumb-item"><a href="#!">Informações do Cliente</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="card">
      <div class="card-header">
          <h5>Menu de opções</h5>
      </div>
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

        @permission('edit.clientes')
          <a href="{{route('clients.edit', ['id' => $client->uuid])}}" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Editar</a>
        @endpermission
      </div>
  </div>

  <div class="row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Informações do Cliente</h5>
            </div>
            <div class="card-block">
              <h2>{{ $client->name}} </h2>
              <p>
                @if($client->active)
                    <i class="fa fa-circle text-success"></i> Ativo
                @else
                    <i class="fa fa-circle text-danger"></i> Inativo
                @endif

              </p>
              <p>CPF/CNPJ: {{ $client->document }}</p>
              <p>Contrato: {{ $client->contract->name }}</p>
              <p>Cobrar Entrega?: {{ $client->charge_delivery ? 'Sim' : 'Não' }}</p>

            </div>
        </div>

    </div>

    <div class="col-md-3">
      <div class="card">
          <div class="card-header">
              <h5>Telefone</h5>
              <div class="card-header-right">
                  <ul class="list-unstyled card-option">
                      <li><a class="btn btn-sm btn-success" href="{{route('phones.create', ['client' => $client->uuid])}}">Novo</a></li>
                  </ul>
              </div>
          </div>
          <div class="card-block">
            <ul class="scroll-list fan">
                @foreach($client->phones as $phone)
                  <li class="list-phones">
                      <h6>{{ $phone->number }}</h6>
                      <a class="text-primary" href="{{route('phones.edit', $phone->uuid)}}">Editar</a>
                      <a class="text-danger btnRemoveItem" style="cursor:pointer" data-route="{{route('phones.destroy', $phone->uuid)}}">Remover</a>
                  </li>
                @endforeach
            </ul>
          </div>
      </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5>E-mail</h5>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><a class="btn btn-sm btn-success" href="{{route('email.create', ['client' => $client->uuid])}}">Novo</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
              <ul class="scroll-list fan">
                  @foreach($client->emails as $email)
                  <li class="list-phones">
                      <h6>{{ $email->email }}</h6>
                      <a class="text-primary" href="{{route('email.edit', $email->uuid)}}">Editar</a>
                      <a class="text-danger btnRemoveItem" style="cursor:pointer" data-route="{{route('email.destroy', $email->uuid)}}">Remover</a>
                  </li>
                  @endforeach
              </ul>

            </div>
        </div>
    </div>

    <div class="col-md-12">

      <div class="card">
          <div class="card-header">
              <h5>Funcionários</h5>
          </div>
          <div class="card-block">

            @if($client->employees->isNotEmpty())

            <div class="table-responsive">

                <table class="table table-lg table-styling">
                    <thead>
                        <tr class="table-primary">
                          <th>Nome</th>
                          <th>Função</th>
                          <th>CPF</th>
                          <th>RG</th>
                          <th>Ativo</th>
                          <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->employees as $employee)
                            <tr>

                                <td>
                                    <a href="{{route('employees.show', $employee->uuid)}}"><b>{{$employee->name}}</b></a>
                                </td>

                                <td>
                                    <a>{{$employee->occupation->name}}</a>
                                </td>

                                <td>
                                    <a>{{$employee->cpf}}</a>
                                </td>

                                <td>
                                    <a>{{$employee->rg}}</a>
                                </td>

                                <td>
                                  @if($employee->active)
                                    <span class="badge badge-success">Ativo</span>
                                  @else
                                    <span class="badge badge-danger">Inativo</span>
                                  @endif
                                </td>

                                <td class="dropdown">
                                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @permission('edit.clientes')
                                      <a href="{{route('employees.edit', ['id' => $employee->uuid])}}" class="dropdown-item"><i class="far fa-edit"></i> Editar</a>
                                    @endpermission

                                  </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            @else
              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                      <p class="font-bold no-margins">Nenhum registro encontrado.</p>

                      @permission('create.clientes')
                          <a href="{{route('client_employee_create', $client->uuid)}}" class="btn btn-sm text-success p-m"><i class="fas fa-user-plus"></i> Novo Funcionário</a>
                      @endpermission
                  </div>
              </div>
            @endif

          </div>
      </div>

    </div>

    <div class="col-md-12">

      <div class="card">
          <div class="card-header">
              <h5>Endereços</h5>
          </div>
          <div class="card-block">

            @if($client->addresses->isNotEmpty())

            <div class="table-responsive">

                <table class="table table-lg table-styling">
                    <thead>
                        <tr class="table-inverse">
                          <th>Descrição</th>
                          <th>Endereço</th>
                          <th>Principal</th>
                          <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->addresses as $address)
                            <tr>

                                <td>
                                    <a>{{$address->description}}</a>
                                </td>

                                <td>
                                    <a>{{$address->street}}, {{$address->number}} - {{$address->district}}, {{$address->city}} - {{$address->zip}}</a>
                                </td>

                                <td>
                                    <a>{{$address->is_default ? 'SIM' : 'NÃO' }}</a>
                                </td>

                                <td class="dropdown">
                                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @permission('edit.clientes')
                                      <a href="{{route('client_addresses_edit', [$client->uuid, $address->uuid])}}" class="dropdown-item"><i class="far fa-edit"></i> Editar</a>
                                    @endpermission

                                    @permission('delete.clientes')
                                      <a href="#!" data-route="{{route('client_address_destroy', ['id' => $address->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
                                    @endpermission

                                  </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            @else
              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                      <p class="font-bold no-margins">Nenhum registro encontrado.</p>

                      @permission('create.clientes')
                          <a href="{{route('client_addresses_create', $client->uuid)}}" class="btn btn-sm btn-primary m-t-lg"><i class="fas fa-map-marked-alt"></i> Novo Endereço</a>
                      @endpermission
                  </div>
              </div>
            @endif

          </div>
      </div>

    </div>

    <div class="col-md-4">

      <div class="card">
          <div class="card-header">
              <h5>Upload</h5>
          </div>
          <div class="card-block">
                <input type="file" name="files[]" id="filer" data-route="{{ route('client_documents_upload', $client->uuid) }}" multiple="multiple">
          </div>
      </div>

    </div>

    <div class="col-md-8">

      <div class="card">
          <div class="card-header">
              <h5>Documentos</h5>
          </div>
          <div class="card-block">

            @if($client->files->isNotEmpty())
              <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>Arquivo</th>
                          <th>Adionado por</th>
                          <th>Upload em</th>
                          <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->files as $document)
                            <tr>

                                <td>
                                    <a target="_blank" href="{{ route('document_preview', ['id' => $document->uuid, 'filename' => $document->filename]) }}">{{$document->filename}}</a>
                                </td>

                                <td>
                                    <a>{{$document->creator->person->name}}</a>
                                </td>

                                <td>
                                      <span>{{$document->created_at->diffForHumans() }}</span><br/>
                                      <small>({{$document->created_at->format('d/m/Y H:i:s') }})</small>
                                </td>

                                <td class="dropdown">
                                  <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                  <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                    @permission('edit.clientes')
                                      <a target="_blank" href="{{ route('document_preview', $document->uuid) }}" class="dropdown-item"><i class="fas fa-eye"></i> Visualizar</a>
                                    @endpermission

                                    @permission('edit.clientes')
                                      <a href="{{route('document_download', [$document->uuid])}}" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Download</a>
                                    @endpermission

                                    @permission('delete.clientes')
                                      <a href="#!" data-route="{{route('document_delete', ['id' => $document->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
                                    @endpermission

                                  </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            @else
              <div class="widget white-bg no-padding">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                      <p class="font-bold no-margins">Nenhum documento encontrado.</p>

                  </div>
              </div>
            @endif

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
