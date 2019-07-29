@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Tarefas</h4>
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
                        <a href="{{ route('tasks.index') }}"> Tarefas </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalhes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

	<div class="row">
			<!-- Task-detail-right start -->
			 <div class="col-xl-4 col-lg-12 push-xl-8 task-detail-right">
         @if($task->status->id == 2)
					<div class="card">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-clock-time m-r-10"></i>Temporizador</h5>
							</div>

							<div class="card-block">
									<div class="counter">
											<div class="yourCountdownContainer" data-time="{{ $remainTime }}">

											</div>
									</div>
							</div>
					</div>
        @endif
					<div class="card">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-ui-note m-r-10"></i> Informações</h5>
							</div>
							<div class="card-block task-details">
									<table class="table table-border table-xs">
											<tbody>
													<tr>
															<td><i class="icofont icofont-contrast"></i> Tarefa:</td>
															<td class="text-right"><span class="f-right">#{{ $task->id }}</span></td>
													</tr>

                          @if($task->ticket)
                              <tr>
    															<td><i class="icofont icofont-meeting-add"></i> Chamado:</td>
    															<td class="text-right"><span class="f-right">#{{ $task->ticket->id }}</span></td>
    													</tr>
                          @endif

                          <tr>
															<td><i class="icofont icofont-meeting-add"></i> Tempo Previsto:</td>
															<td class="text-right"><span class="f-right">{{ \App\Helpers\Helper::formatTime($task->time, $task->time_type) }}</span></td>
													</tr>

													<tr>
															<td><i class="icofont icofont-meeting-add"></i> Atualizado:</td>
															<td class="text-right">{{ $task->updated_at->format('d/m/Y H:i') }}</td>
													</tr>
													<tr>
															<td><i class="icofont icofont-id-card"></i> Criado:</td>
															<td class="text-right">{{ $task->created_at->format('d/m/Y H:i') }}</td>
													</tr>

                          <tr>
															<td><i class="icofont icofont-contrast"></i> Gravidade:</td>
															<td class="text-right"><span class="f-right label label-{!! \App\Helpers\Helper::getColorFromValue($task->severity); !!}">{{ $task->severity }}</span></td>
													</tr>

                          <tr>
															<td><i class="icofont icofont-contrast"></i> Urgencia:</td>
															<td class="text-right"><span class="f-right label label-{!! \App\Helpers\Helper::getColorFromValue($task->urgency); !!}">{{ $task->urgency }}</span></td>
													</tr>

                          <tr>
															<td><i class="icofont icofont-contrast"></i> Tendencia:</td>
															<td class="text-right"><span class="f-right label label-{!! \App\Helpers\Helper::getColorFromValue($task->trend); !!}">{{ $task->trend }}</span></td>
													</tr>

                          <tr>
															<td><i class="icofont icofont-ui-love-add"></i> Adicionado Por:</td>
															<td class="text-right"><a href="#">{{ $task->user->person->name }}</a></td>
													</tr>

                          <tr>
															<td><i class="icofont icofont-ui-love-add"></i> Responsável:</td>
															<td class="text-right"><a href="#">{{ $task->sponsor->person->name }}</a></td>
													</tr>

													<tr>
															<td><i class="icofont icofont-ui-love-add"></i> Solicitante:</td>
															<td class="text-right"><a href="#">{{ $task->requester ? $task->requester->person->name : '-' }}</a></td>
													</tr>
													<tr>
															<td><i class="icofont icofont-washing-machine"></i> Status:</td>
															<td class="text-right">{{ $task->status->name }}</td>
													</tr>
											</tbody>
									</table>
							</div>
					</div>
					<div class="card">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-certificate-alt-2 m-r-10"></i> Atividades</h5>
							</div>
							<div class="card-block revision-block">
									<div class="form-group">
											<div class="row">
													<ul class="media-list revision-blc">
                            @foreach($task->logs as $log)
															<li class="media d-flex m-b-15">
																	<div class="p-l-15 p-r-20 d-inline-block v-middle">
                                    <img width="40" class="img-radius" src="{{ route('image', ['user' => $log->user->uuid, 'link' => $log->user->avatar, 'avatar' => true])}}" alt="chat-user">
                                  </div>
																	<div class="d-inline-block">
																			{{ $log->message }}
																			<div class="media-annotation">{{ \App\Helpers\TimesAgo::render($log->created_at) }}</div>
																	</div>
															</li>
															@endforeach
													</ul>
											</div>
									</div>
							</div>
					</div>
					<div class="card">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-attachment"></i> Arquivos Anexados</h5>


							</div>
							<div class="card-block task-attachment">

                <form class="formValidation" enctype="multipart/form-data" method="post" action="{{ route('task_upload', $task->uuid) }}">
                    @csrf
                    <div class="col-md-12 btn-add-task">
                        <div class="input-group input-group-button">
                            <input required type="file" name="file" class="form-control" placeholder="Adicionar um Arquivo">
                            <button class="input-group-addon btn btn-primary" id="basic-addon1">
                                <i class="icofont icofont-plus f-w-600"></i> Add Arquivo
                            </button>
                        </div>
                    </div>
                </form>

									<ul class="media-list">

                    @foreach($task->files as $file)
											<li class="media d-flex m-b-10">
													<div class="m-r-20 v-middle">
															<i class="icofont icofont-file-pdf f-28 text-muted"></i>
													</div>
													<div class="media-body">
															<a target="_blank" href="{{ route('task_preview', $file->uuid) }}" class="m-b-5 d-block">{{ $file->filename }}</a>
															<div class="text-muted">
																	<span>Tam: {{ \App\Helpers\Helper::formatBytes($file->size) }}</span>
																	<span>
																				Adicionado por <a href="#">{{ $file->user->person->name }}</a>
																	 </span>
															</div>
													</div>
													<div class="f-right v-middle text-muted">
                            <a href="{{ route('task_download', $file->uuid) }}">
															<i class="icofont icofont-download-alt f-18"></i>
                            </a>
													</div>
											</li>
                    @endforeach

									</ul>
							</div>
					</div>
					<div class="card">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-users-alt-4"></i> Usuários</h5>
							</div>
							<div class="card-block user-box assign-user">
									<div class="media">
											<div class="media-left media-middle photo-table">
													<a href="#">
															<img class="img-radius" src="{{ route('image', ['user' => $task->sponsor->uuid, 'link' => $task->sponsor->avatar, 'avatar' => true])}}" alt="chat-user">
													</a>
											</div>
											<div class="media-body">
													<h6>{{ $task->sponsor->person->name }}</h6>
													<p>{{ $task->sponsor->person->department->name }}</p>
											</div>
											<div>
													<a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
											</div>
									</div>

                  <div class="media">
											<div class="media-left media-middle photo-table">
													<a href="#">
															<img class="img-radius" src="{{ route('image', ['user' => $task->user->uuid, 'link' => $task->user->avatar, 'avatar' => true])}}" alt="chat-user">
													</a>
											</div>
											<div class="media-body">
													<h6>{{ $task->user->person->name }}</h6>
													<p>{{ $task->user->person->department->name }}</p>
											</div>
											<div>
													<a href="#!" class="text-muted"> <i class="icon-options-vertical"></i></a>
											</div>
									</div>

							</div>
					</div>
			</div>
			<!-- Task-detail-right start -->
			<!-- Task-detail-left start -->
			<div class="col-xl-8 col-lg-12 pull-xl-4">
					<div class="card">
							<div class="card-header">
									<h5><i class="icofont icofont-tasks-alt m-r-5"></i>{{ $task->name }}</h5>

                  <span class="label label-lg label-{{\App\Helpers\Helper::getStatusCollor($task->status->name)}} f-right"> {{ $task->status->name }} </span></a>

							</div>
							<div class="card-block">
									<div class="">
											<div class="m-b-20">
													<h6 class="sub-title m-b-15">Descrição</h6>
													{{ $task->description }}
											</div>
									</div>
							</div>
							<div class="card-footer">
									<div class="f-left">

                      <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Situação</label>
                          <div class="col-sm-8">
                              <select id="select-status" name="select" class="form-control"
                              data-route="{{ route('task_status', $task->uuid) }}">
                                @foreach(\App\Helpers\Helper::taskStatus() as $status)
                                  <option value="{{$status->id}}" {{ $task->status_id == $status->id ? 'selected' : '' }}>{{$status->name}}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>

                  </div>

                  <div class="f-right d-flex">

                    <div class="btn-group " role="group">

                        <a href="{{ route('tasks.edit', ['id' => $task->uuid]) }}" class="btn btn-primary btn-sm waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"><i class="icofont icofont-edit"></i>Editar</a>
                        <a href="#!" data-route="{{ route('task_duplicate', $task->uuid) }}" class="btn btn-danger btn-sm waves-effect waves-light btn-duplicate-task" data-toggle="tooltip" data-placement="top" title="" data-original-title="Duplicar"><i class="icofont icofont-copy"></i>Duplicar</a>

                    </div>

                  </div>

							</div>
					</div>
					<div class="card comment-block">
							<div class="card-header">
									<h5 class="card-header-text"><i class="icofont icofont-comment m-r-5"></i> Comentários</h5>
							</div>
							<div class="card-block">
									<ul class="media-list">
                    @foreach($task->messages->sortByDesc('id') as $message)

                      <li class="media">
                          <div class="media-left">
                              <a href="{{route('user', ['id' => $message->user->id])}}">
                                  <img class="media-object img-radius comment-img" src="{{ route('image', ['user' => $message->user->uuid, 'link' => $message->user->avatar, 'avatar' => true])}}" title="{{$message->user->name}}" alt="{{$message->user->name}}">
                              </a>
                          </div>
                          <div class="media-body">
                              <h6 class="media-heading txt-primary"><span class="f-12 text-muted m-l-5">{{$message->created_at->format('d/m/Y H:i:s')}}</span></h6>
                              {{$message->message}}
                              <hr>
                          </div>
                      </li>

                    @endforeach

									</ul>
									<div class="md-float-material d-flex">
											<div class="col-md-12 btn-add-task">
                        <form method="post" action="{{route('task_message_store')}}">
                          {{csrf_field()}}
                          <input name="task" type="hidden" value="{{$task->uuid}}"/>
                          <textarea rows="5" name="message" class="form-control" required placeholder="Insira um Comentário"></textarea>
                          <br/>
                          <button class="btn btn-success">Enviar</button>
                        </form>

											</div>
									</div>
							</div>
					</div>
			</div>
			<!-- Task-detail-left end -->
	</div>

</div>

<input type="hidden" id="task_user" value="{{ $task->sponsor->id }}">
<input type="hidden" id="session_user" value="{{ \Auth::user()->id }}">

@endsection @section('scripts')

<script>

	$(document).ready(function() {

        $("#select-status").change(function() {

          var self = $(this);
          var statusValue = self.val();
          const ipAPI = self.data('route');

          if(statusValue == 5) {

            swal({
  							title: 'Informe o motivo para pausar a tarefa.',
  							customClass: 'bounceInLeft',
  							input: 'textarea',
  							confirmButtonText: 'Enviar',
  							showLoaderOnConfirm: true,
  							showCancelButton: true,
  							preConfirm: (text) => {
  								return new Promise((resolve) => {
  									setTimeout(() => {
  										if (text === '') {
  											swal.showValidationError(
  												'Por Favor Informe o motivo do atraso.'
  											)
  										}
  										resolve()
  									}, 1000)
  								})
  							},
  							allowOutsideClick: () => false
  						}).then((result) => {
  							if (result.value) {

  								swal({
  									type: 'success',
  									title: 'O motivo foi enviado!',
  									html: 'Motivo: ' + result.value,
  									preConfirm: () => {
  										 return $.ajax({
                         headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                         url: ipAPI,
                         type: 'POST',
                         dataType: 'json',
                         data: {
                           message : result.value,
                           status: statusValue
                         }
                       }).done(function(data) {

                         window.location.reload();

                       });

  									 }
  								})
  							}
  						})

          } else {

                window.swal({
                  title: 'Em progresso...',
                  text: 'Atualizando status da tarefa.',
                  type: 'success',
                  showConfirmButton: false,
                  allowOutsideClick: false
                });

                $.ajax({
                  headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                  url: ipAPI,
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    status: statusValue
                  }
                }).done(function(data) {

                  window.location.reload();

                });

          }

        });

        $(".btn-duplicate-task").click(function(e) {
            var self = $(this);

            swal({
              title: 'Duplicar tarefa?',
              text: "Deseja duplicar esta tarefa?",
              showCancelButton: true,
              confirmButtonColor: '#0ac282',
              cancelButtonColor: '#D46A6A',
              confirmButtonText: 'Sim',
              cancelButtonText: 'Não'
              }).then((result) => {
              if (result.value) {

                e.preventDefault();

                window.swal({
                  title: 'Em progresso...',
                  text: 'Aguarde enquanto a requisição é processada.',
                  type: 'success',
                  showConfirmButton: false,
                  allowOutsideClick: false
                });

                $.ajax({
                  headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                  url: self.data('route'),
                  type: 'POST',
                  dataType: 'json',
                  data: {}
                }).done(function(data) {

                  if(data.success) {

                    notify(data.message, 'inverse');

                    window.location.href = data.route;

                  } else {

                    swal.close();

                    notify(data.message, 'danger');

                  }



                });
              }
            });
        });

  });

</script>

@stop
