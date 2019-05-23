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
            <a href="{{route('client_employee_create', $client->uuid)}}" class="btn text-success btn-sm m-t-lg"><i class="fas fa-user-plus"></i> Novo Funcionário</a>
        @endpermission

        @permission('create.clientes')
            <a href="{{route('client_addresses_create', $client->uuid)}}" class="btn btn-primary btn-sm m-t-lg"><i class="fas fa-map-marked-alt"></i> Novo Endereço</a>
        @endpermission

        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#uploadDocuments"><i class="fas fa-file"></i> Upload de Documentos</button>

        <a href="{{route('clients.edit', ['id' => $client->uuid])}}"
           style="margin-left: 4px;"
           class="btn btn-info btn-outline btn-sm pull-right"><i class="far fa-edit"></i> Editar</a>

      </div>
  </div>

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
        <p>Email: {{ $client->email }}</p>
        <p>Telefone: {{ $client->phone }}</p>

      </div>
  </div>

  <div class="row">

    <div class="col-md-12">

      <div class="card">
          <div class="card-header">
              <h5>Funcionários</h5>
          </div>
          <div class="card-block">

            @if($client->employees->isNotEmpty())

            <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nome</th>
                          <th>Email</th>
                          <th>CPF</th>
                          <th>Ativo</th>
                          <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($client->employees as $employee)
                            <tr>

                                <td>
                                    <a>{{$employee->id}}</a>
                                </td>

                                <td>
                                    <a>{{$employee->name}}</a>
                                </td>

                                <td>
                                    <a>{{$employee->email}}</a>
                                </td>

                                <td>
                                    <a>{{$employee->cpf}}</a>
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
                                      <a href="{{route('client_employee_edit', [$client->uuid, $employee->uuid])}}" class="dropdown-item"><i class="far fa-edit"></i> Editar</a>
                                    @endpermission

                                    @permission('delete.clientes')
                                      <a href="#!" data-route="{{route('client_employee_destroy', ['id' => $employee->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fas fa-trash-alt"></i> Remover</a>
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

                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th>ID</th>
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
                                    <a>{{$address->id}}</a>
                                </td>

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

    <div class="col-md-12">

      <div class="card">
          <div class="card-header">
              <h5>Documentos</h5>
          </div>
          <div class="card-block">

            @if($client->documents->isNotEmpty())
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
                        @foreach($client->documents as $document)
                            <tr>

                                <td>
                                    <a target="_blank" href="{{ route('document_preview', $document->uuid) }}">{{$document->description}}</a>
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
                      <p class="font-bold no-margins">Nenhum registro encontrado.</p>

                      @permission('create.clientes')
                          <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#uploadDocuments"><i class="fas fa-file"></i> Upload de Documentos</button>
                      @endpermission
                  </div>
              </div>
            @endif

          </div>
      </div>

    </div>

  </div>

</div>


<div class="modal fade" id="uploadDocuments" tabindex="-1" role="dialog" aria-labelledby="editStatus" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mySmallModalLabel">Upload de Documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form id="formUpload" method="post" action="{{route('client_documents_upload', [$client->uuid])}}" enctype="multipart/form-data">

              <div class="modal-body">

                    @csrf

                    <div class="row m-b-30">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="status">Documentos</label>
                                <div class="input-group">

                                  <input required name="files[]" data-buttonText="Selecionar Arquivos" data-dragdrop="true"  data-buttonName="btn-primary" data-badge="true" type="file" data-input="true" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf, image/*" class="filestyle" multiple/>

                                </div>
                            </div>
                        </div>
                    </div>

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Fechar</button>
                  <button type="submit" class="btn btn-primary btnFormUpload">Salvar</button>
              </div>

            </form>

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
