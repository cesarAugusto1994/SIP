@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Cursos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Cursos</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
    <div class="card-header">
        <h5>Listagem de Cursos</h5>
        <div class="card-header-right">
            <ul class="list-unstyled card-option">
                <li><a class="btn btn-sm btn-success btn-round" href="{{route('courses.create')}}">Novo</a></li>
            </ul>
        </div>
    </div>
    <div class="card-block">

      @if($courses->isNotEmpty())

      <div class="table-responsive">
          <table class="table table-hover">

              <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Carga Horária</th>
                  <th>Adicionado em</th>
                  <th>Opções</th>
                </tr>
              </thead>

              <tbody>
                  @foreach($courses as $course)
                      <tr>

                          <td>
                              <a>{{substr(($course->title), 0, 50)}}<br>
                                @if($course->ordinance)
                                  <small>Portaria de {{ $course->ordinance }} - {{ $course->ordinance }}</small>
                                @elseif($course->nbr)
                                  <small>NBR {{ $course->nbr }} e NT {{ $course->nt }}</small>
                                @endif</a>
                          </td>

                          <td>
                              <a>{{$course->workload}} horas</a>
                          </td>

                          <td>
                              <a>{{$course->created_at->format('d/m/Y H:i')}}</a>
                          </td>

                          <td class="dropdown">

                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                            <div class="dropdown-menu dropdown-menu-right b-none contact-menu">
                              @permission('edit.cursos')
                                <a class="dropdown-item" href="{{route('courses.edit', ['id' => $course->uuid])}}"><i class="icofont icofont-edit"></i>Editar</a>
                              @endpermission
                            </div>

                          </td>

                      </tr>
                  @endforeach
              </tbody>
          </table>

          <div class="text-center">
          {{ $courses->links() }}
          </div>

      </div>

      @else

          <div class="col-sm-12">

            <div class="widget white-bg no-padding m-t-30">
                <div class="p-m text-center">
                    <h1 class="m-md"><i class="far fa-folder-open fa-2x"></i></h1>
                    <h6 class="font-bold no-margins">
                        Nenhum registro encontrado.
                    </h6>
                </div>
            </div>

          </div>

      @endif

    </div>
</div>

</div>

@stop
