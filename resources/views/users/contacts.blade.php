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

  <div class="row">

    <div class="col-md-12 m-b-20">
        <input style="background-color:transparent" autofocus id="searchInput" type="text" placeholder="Pesquisar..." class="form-control form-control-round form-control-success">
    </div>

    @foreach($users as $user)

        @if(!$user->person->branch)
            @continue;
        @endif

        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-block text-center">
                    <h4 class="lead m-t-20">{{ $user->person->branch }}</h4>
                    <p class="m-b-20">{{ $user->person->name ?? '' }} <br/> {{ $user->email }}</p>

                    <small>
                    <b>Unidade:</b> {{ $user->person->unit->name ?? '' }}
                    <br/>
                    <b>Setor:</b> {{ $user->person->department->name ?? '' }}
                    <br/>
                    <b>Cargo:</b> {{ $user->person->occupation->name ?? '' }}
                    </small>
                </div>
            </div>
        </div>

    @endforeach


  </div>

</div>

@endsection

@section('scripts')

  <script>
      $("#searchInput").keyup(function() {
          var rows = $(".card").find(".card-block").hide();
          var data = this.value.split(" ");
          $.each(data, function(i, v) {
            rows.filter(":contains('" + v + "')").show();
          });
      });
  </script>

@endsection
