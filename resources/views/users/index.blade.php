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

  <div class="col-lg-12 col-xl-3">

      <div class="card">
          <div class="card-header">
              <h5><i class="icofont icofont-filter m-r-5"></i>Pesquisa</h5>
              <div class="card-header-right">
                  <ul class="list-unstyled card-option">

                      @permission('create.usuarios')
                        <li><a class="btn btn-sm btn-success" href="{{route('users.create')}}">Novo Usuário</a></li>
                      @endpermission

                  </ul>
              </div>
          </div>
          <div class="card-block">
              <form action="?">
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
                  <div class="text-right">
                      <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Buscar</button>
                  </div>
              </form>
          </div>
      </div>

  </div>

  <div class="col-xl-9">

    <div class="row simple-cards users-card">

    @forelse($people as $person)

      <div class="col-md-12 col-xl-4">
          <div class="card user-card">
              <div class="card-header-img">
                @if(config('app.env') == 'production')
                  <img class="img-fluid img-radius" style="width:100px;height:100%" src="{{ route('image', ['user' => $person->user->uuid, 'link' => $person->user->avatar, 'avatar' => true])}}" alt="">
                @endif
                  <h4>{{ $person->name }}</h4>
                  <h5><a href="" class="__cf_email__" >{{$person->user->email}}</a></h5>
                  <p>{{$person->department->name}} / {{$person->occupation->name}}</p>
              </div>

              @if($person->active)
                  Ativo<i class="fa fa-circle text-success" title="Ativo"></i>
              @else
                  Inativo<i class="fa fa-circle text-danger" title="Inativo"></i>
              @endif
              <br/>
              <small>Último Login: {{ $person->user->lastLoginAt() ? $person->user->lastLoginAt()->format('d/m/Y H:i') : '-' }}</small>
              <br/>
              <a href="{{route('user', ['id' => $person->user->uuid])}}" class="btn btn-success btn-sm btn-round"><i class="icofont icofont-user m-r-5"></i>Perfil</a>

          </div>
      </div>

    @empty

      <div class="col-md-12 m-b-sm">
        <div class="widget white-bg no-padding">
            <div class="p-m text-center">
                <h1 class="m-xs"><i class="fas fa-users fa-2x"></i></h1>
                <h6 class="font-bold no-margins">
                    Nenhum usuário encontrado.
                </h6>
            </div>
        </div>
      </div>

    @endforelse

    </div>

  </div>

  </div>

  <br/><br/>

  <div class="text-center">
      {{ $people->links() }}
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
