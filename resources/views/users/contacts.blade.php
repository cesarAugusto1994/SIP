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
          <h5>Listagem de Ramais e Telefones</h5>
      </div>
      <div class="card-block">

        <div class="col-md-12 m-b-20">
            <input style="background-color:transparent" autofocus id="searchInput" type="text" placeholder="Pesquisar..." class="form-control form-control-round form-control-success">
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ramal</th>
                        <th>E-mail</th>
                        <th>Unidade</th>
                    </tr>
                </thead>
                <tbody id="tbody">

                  @foreach($users->sortBy('person.name') as $user)

                      <tr>
                          <td>{{$user->person->name}}<br/><small>{{ $user->person->department->name ?? '' }}</small></td>
                          <td>{{$user->person->branch}}</td>
                          <td>{{$user->email}}</td>
                          <td>{{$user->person->unit->name}}</td>
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
          var rows = $("#tbody").find('tr').hide();
          var data = this.value.split(" ");
          $.each(data, function(i, v) {
            rows.filter(":contains('" + v + "')").show();
          });
      });
  </script>

@endsection
