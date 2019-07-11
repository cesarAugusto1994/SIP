@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ramais e Telefones</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Ramais e Telefones</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem de Ramais</h5>
          <div class="card-header-right">
              <ul class="list-unstyled card-option">

                    <li><input id="searchInput" type="text" placeholder="Pesquisar..." autofocus class="form-control form-control-round form-control-success"></li>

              </ul>
          </div>
      </div>
      <div class="card-block">

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ramal</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody id="fbody">

                  @foreach($users as $user)

                      @if(!$user->person->branch)
                          @continue;
                      @endif

                      <tr>
                          <td>{{ $user->person->branch }}</td>
                          <td><p class="lead">{{ $user->person->name ?? '' }}</p>

                            <br/>
                            <small>
                            <b>Unidade:</b> {{ $user->person->unit->name ?? '' }}
                            <br/>
                            <b>Setor:</b> {{ $user->person->department->name ?? '' }}
                            <br/>
                            <b>Cargo:</b> {{ $user->person->occupation->name ?? '' }}
                            </small>

                          </td>
                          <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                          <td>{{ $user->person->phone }}</td>
                      </tr>

                  @endforeach

                </tbody>
            </table>
        </div>

      </div>
  </div>
</div>

@endsection

@section('scripts')

  <script>
      $("#searchInput").keyup(function() {
          var rows = $("#fbody").find("tr").hide();
          var data = this.value.split(" ");
          $.each(data, function(i, v) {
          rows.filter(":contains('" + v + "')").show();
          });
      });
  </script>

@endsection
