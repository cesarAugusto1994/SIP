@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Usuários</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Usuários</a></li>
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

                    @permission('create.usuarios')
                      <a class="btn btn-sm btn-success btn-new-tickets waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('users.create')}}"><i class="icofont icofont-paper-plane"></i> Novo Usuário</a>
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
                              <input name="search" type="text" placeholder="ID, Nome, Documento, Email, ou Telefone" class="form-control">
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-12">
                            <select class="form-control select-occupations" data-search-occupations="{{ route('occupation_search') }}" data-live-search="true" title="Departamento" data-style="btn-white" data-width="100%" placeholder="Departamento" name="department">
                              <option value="">Selecionar Departamento</option>
                              @foreach($departments as $department)
                                  <option value="{{$department->uuid}}">{{$department->name}}</option>
                              @endforeach
                            </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-12">
                            <select class="form-control" id="occupation" data-live-search="true" title="Cargo" data-style="btn-white" data-width="100%" placeholder="Cargo" name="occupation">
                                <option value="">Selecionar Departamento</option>
                            </select>
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-sm-12">
                            <select class="form-control" data-live-search="true" title="Situação" data-style="btn-white" data-width="100%" placeholder="Situação" name="active">
                                <option value="">Situação</option>
                                <option value="0">Inativo</option>
                                <option value="1">Ativo</option>
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
                  <h5>Usuários Cadastrados</h5>
                  <span>Registros retornados: {{ $quantity }}</span>
              </div>
              <div class="card-block table-border-style">
                  <div class="table-responsive">
                      <table class="table table-lg table-styling">
                          <thead>
                              <tr class="table-primary">
                                <th>Nome</th>
                                <th>Depto/Cargo</th>
                                <th>Situação</th>
                                <th>Opções</th>
                              </tr>
                          </thead>
                          <tbody>

                            @foreach($people as $person)
                              <tr>
                                  <td>  <a href="{{route('user', ['id' => $person->user->uuid])}}">{{ $person->name }}</a>
                                    <br/>
                                    <small>{{$person->user->email}}</small>
                                  </td>
                                  <td>{{$person->department->name}} / {{$person->occupation->name}}</td>
                                  <td>
                                    @if($person->active)
                                        <label class="label label-inverse-success">Ativo</label>
                                    @else
                                        <label class="label label-inverse-success">Inativo</label>
                                    @endif
                                  </td>

                                  <td class="dropdown">

                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                      @permission('view.usuarios')
                                        <a href="{{route('user', ['id' => $person->user->uuid])}}" class="dropdown-item">Visualizar </a>
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
      @if(!empty($people))
      {{ $people->links() }}
      @endif
    </div>

</div>

@endsection

@push('scripts')
    <script>

      $(document).ready(function() {

        let selectOccupations = $(".select-occupations");
        let occupation = $("#occupation");

        selectOccupations.on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {

          let self = $(this);
          let route = self.data('search-occupations');
          let value = self.val();

          $.ajax({
            type: 'GET',
            url: route + '?param=' + value,
            async: true,
            success: function(response) {

              let html = "";
              occupation.html("");
              occupation.selectpicker('refresh');

              $.each(response.data, function(idx, item) {

                  html += "<option value="+ item.uuid +">"+ item.name +"</option>";

              });

              occupation.append(html);
              occupation.selectpicker('refresh');

            }
          })

        });

      });

    </script>
@endpush
