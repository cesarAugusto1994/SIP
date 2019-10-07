@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Turmas</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Turmas</a></li>
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

                  @permission('create.turmas')
                    <a class="btn btn-sm btn-success waves-effect waves-light m-r-15 m-b-5 m-t-5" href="{{route('teams.create')}}"><i class="icofont icofont-paper-plane"></i> Nova Turma</a>
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
                            <input type="text" class="form-control" name="code" placeholder="Código da Turma">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <input type="text" id="daterange" class="form-control" placeholder="Periodo">

                            <input type="hidden" name="start" id="start" value="{{ now()->format('d/m/Y') }}"/>
                            <input type="hidden" name="end" id="end" value="{{ now()->format('d/m/Y') }}"/>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <select class="form-controls select2" name="status">
                              <option value="">Situação</option>
                              <option value="RESERVADO">RESERVADO</option>
                              <option value="EM ANDAMENTO">EM ANDAMENTO</option>
                              <option value="FINALIZADA">FINALIZADA</option>
                              <option value="CANCELADA">CANCELADA</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12">
                          <select class="form-control select2" name="teacher_id">
                              <option value="">Instrutor</option>
                              @foreach($teachers->sortBy('name') as $teacher)
                                  <option value="{{$teacher->user->id}}">{{$teacher->name}}</option>
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
                <h5>Turmas Recentes</h5>
                <span>Registros retornados: {{ $quantity }}</span>
            </div>
            <div class="card-block table-border-style">
                <div class="table-responsive">
                    <table class="table table-lg table-styling">
                        <thead>
                            <tr class="table-primary">
                                <th>No.</th>
                                <th>Curso</th>
                                <th>Situação</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($teams as $team)

                            <tr>
                                <td><a href="{{ route('teams.show', $team->uuid) }}" class="card-title">#{{ str_pad($team->id, 6, "0", STR_PAD_LEFT) }}</a></td>
                                <td>{{ $team->course->title }}<br/>
                                  <small>Instrutor: {{ $team->teacher->person->name }}</small>
                                  <br/>
                                  <small>Vagas: {{ $team->employees->count() }} / {{ $team->vacancies }}</small>
                                </td>
                                <td>
                                  <span class="label label-{{ \App\Helpers\Helper::statusTeams($team->status) }}"> {{$team->status}} </span>
                                </td>

                                <td>
                                  {{ $team->start->format('d/m/Y') }}
                                  <br/>
                                  <label class="label label-inverse-primary">{{ $team->start->diffForHumans() }}</label>

                                </td>

                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{ $teams->links() }}

  </div>

</div>

@endsection
