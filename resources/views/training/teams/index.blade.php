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

<div class="card">
    <div class="card-header">
        <h5>Listagem de Turmas</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><a class="btn btn-sm btn-success btn-round" href="{{route('teams.create')}}">Novo</a></li>
            </ul>
        </div>
    </div>
    <div class="card-block">

      <div class="table-responsive">
          @if($teams->isNotEmpty())

              <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Curso</th>
                      <th>Instrutor</th>
                      <th>Vagas</th>
                      <th>Data</th>
                      <th>Opções</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($teams as $team)
                          <tr>

                              <td>
                                  <a>{{$team->course->title}}</a>
                              </td>

                              <td>
                                  <a>{{$team->teacher->person->name ?? '-'}}</a>
                              </td>

                              <td>
                                  <a>{{$team->employees->count()}} de {{$team->vacancies}}</a>
                                  <p class="lead text-danger">{{ ($team->employees->count() / intval($team->vacancies)) * 100 }}%</p>
                              </td>

                              <td>
                                  <a>{{ $team->start->format('d/m') }} à {{ $team->end->format('d/m') }}</a>
                              </td>

                              <td class="dropdown">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                                  @permission('edit.cursos')
                                    <a href="{{route('teams.show', ['id' => $team->uuid])}}" class="dropdown-item"><i class="fa fa-list"></i> Cronograma</a>
                                  @endpermission
                                  @permission('delete.cursos')
                                    <a style="cursor:pointer" data-route="{{route('courses.destroy', ['id' => $team->uuid])}}" class="dropdown-item btnRemoveItem"><i class="fa fa-close"></i> Remover</a>
                                  @endpermission
                                </div>
                              </td>

                          </tr>
                      @endforeach
                  </tbody>
              </table>

          @else
            <div class="col-sm-12">

              <div class="widget white-bg no-padding m-t-30">
                  <div class="p-m text-center">
                      <h1 class="m-md"><i class="far fa-folder-open fa-3x"></i></h1>
                      <h4 class="font-bold no-margins">
                          Nenhum registro encontrado.
                      </h4>
                  </div>
              </div>

            </div>
          @endif
      </div>

    </div>
</div>

</div>


@endsection

@push('scripts')



@endpush
