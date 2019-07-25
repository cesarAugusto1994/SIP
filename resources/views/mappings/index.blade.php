@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mapeamentos</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Mapeamentos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Listagem</h5>
      </div>
      <div class="card-block table-responsive">

        @if($mappings->isNotEmpty())
        <table class="table table-hover">
            <tbody>
            @foreach($mappings as $map)
            <tr>
                <td class="project-title">
                    <a href="{{route('mapping', ['id' => $map->id])}}">{{$map->name}}</a>
                </td>
                <td class="project-completion">
                    <span>Tempo Tarefas {{ App\Helpers\Helper::taskTimeToHour($map->tasks) }}</span>
                </td>
                <td class="project-completion">
                    <span>Tarefas: {{ $map->tasks->count() }}<a></span>
                </td>
                <td class="project-completion">
                    <span>Tempo Trabalhado: {{App\Helpers\Mapper::getDoneTimeByUser($map->user->id) }}<a></span>
                </td>
                <!--
                <td class="project-completion">
                    <span>Tempo Corrido: {{ App\Helpers\Helper::ociousTime($map->id) }}<a></span>
                </td>-->
                <td class="project-people hidden-xs">
                    <a href="{{route('user', ['id' => $map->user->id])}}" title="{{ $map->user->name }}">
                    <img width="32" class="img-fluid" src="{{ route('image', ['user' => $map->user->uuid, 'link' => $map->user->avatar, 'avatar' => true])}}" alt=""></a>
                </td>
                <!--<td class="project-actions hidden-xs">
                    <a href="{{route('mapping_edit', ['id' => $map->id])}}" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editar </a>
                </td>-->
            </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-warning">Nenhum mapeamento foi registrado até o momento.</div>
        @endif

      </div>
  </div>
</div>

@endsection
