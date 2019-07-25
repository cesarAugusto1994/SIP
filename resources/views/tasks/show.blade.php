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
															<td class="text-right"><a href="#">{{ $task->requester->person->name }}</a></td>
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

                  <div class="dropdown-secondary dropdown  f-right">
                      <button class="btn btn-sm btn-primary dropdown-toggle waves-light" type="button" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opções</button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown2" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                          @if($task->status_id != 3 && $task->status_id != 4)
                              <a class="dropdown-item waves-light waves-effect active" href="{{ route('tasks.edit', ['id' => $task->uuid]) }}"><i class="fa fa-edit"></i> Editar</a>
                          @endif

                          @if($task->status_id == 2)
  														@if(count($pausedTask??[]) > 0)
                                  <a class="btn-unpause dropdown-item waves-light waves-effect"><i class="fa fa-play"></i> Continuar</a>
  														@elseif(empty($taskDelay))
                                  <a class="btn-pause dropdown-item waves-light waves-effect"><i class="fa fa-pause"></i> Pausar</a>
  														@endif
                                  <a class="dropdown-item waves-light waves-effect" href="?status=3"> <i class="fa fa-stop"></i> Finalizar</a>

                          @elseif($task->status_id == 1)
                              <li>
  																@if(($task->mapper && $task->mapper->active == 1) || !$task->mapper)
                                      <a class="dropdown-item waves-light waves-effect" href="?status=2"><i class="fa fa-play"></i> Iniciar</a>
  																@else
                                      <a disabled class="btn-task-start-blocked dropdown-item waves-light waves-effect"><i class="fa fa-play"></i> Iniciar</a>
  																@endif
                              </li>
  														@if(($task->mapper) && $task->mapper->active != 1)
                                  <a class="dropdown-item waves-light waves-effect" href="{{ route('mapping', ['id' => $task->mapper->id]) }}">Mapeamento</a>
                              @endif
                          @endif
                          @if($task->status_id != 3 && $task->status_id != 4)
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item waves-light waves-effect" href="?cancel=1">Cancelar</a>
                          @endif
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item waves-light waves-effect" href="?duplicate=1"><i class="fas fa-file"></i> Duplicar</a>

                      </div>
                  </div>

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
											<span class=" txt-primary"> <i class="icofont icofont-chart-line-alt"></i>Status:</span>&nbsp;
											<span class="label label-bg label-inverse-{{\App\Helpers\Helper::getStatusCollor($task->status->name)}} f-right"> {{ $task->status->name }} </span></a>
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
                          <textarea name="message" class="form-control" required placeholder="Insira um Comentário"></textarea>
                          <br/>
                          <button class="btn btn-primary">Enviar</button>
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

				var options = {
						"start": true,
						"fg_width": 0.05,
            "time": {
            "Days": {
                "text": "Days",
                "color": "#FFCC66",
                "show": false
            },
            "Hours": {
                "text": "Hora(s)",
                "color": "#1ab394",
                "show": true
            },
            "Minutes": {
                "text": "Minutos",
                "color": "#1ab394",
                "show": true
            },
            "Seconds": {
                "text": "Segundos",
                "color": "#1ab394",
                "show": true
            }
					}};

        $(".example").TimeCircles(options).addListener(countdownComplete);

				var pausedTask = $('#pausedTask').val();

				if(pausedTask > 0) {
					$(".example").TimeCircles(options).stop();
				}

        function countdownComplete(unit, value, total){
            if(total<=0){
                $(".example").TimeCircles().destroy();
                $(this).fadeOut('slow').replaceWith("<div class='alert alert-danger'>Tempo Expirado!</div>");

								if($('#motivoEnviado').val() > 0) {
										return false;
								}

								if($('#task_user').val() != $('#session_user').val()) {
									return false;
								}

								swal({
									  title: 'Informe o motivo do Atraso',
										customClass: 'bounceInLeft',
									  input: 'textarea',
									  confirmButtonText: 'Enviar',
									  showLoaderOnConfirm: true,
									  preConfirm: (text) => {
									    return new Promise((resolve) => {
									      setTimeout(() => {
									        if (text === '') {
									          swal.showValidationError(
									            'Por Favor Informe o motivo do atraso.'
									          )
									        }
									        resolve()
									      }, 2000)
									    })
									  },
									  allowOutsideClick: () => false
									}).then((result) => {
									  if (result.value) {

											const ipAPI = $('#urlAPI').val();

									    swal({
									      type: 'success',
									      title: 'O motivo foi enviado!',
									      html: 'Motivo: ' + result.value,
												preConfirm: () => {
													 return $.post(ipAPI, { message : result.value, _token : "{{ csrf_token() }}" }).then((data) => {
														 setTimeout(function() {
																 toastr.options = {
																		 closeButton: true,
																		 progressBar: true,
																		 showMethod: 'slideDown',
																		 timeOut: 4000
																 };
																 toastr.success('Mapeador de Processos', data.message);

																 setTimeout(function() {
																	 	window.location.reload();
																 }, 4000)

														 }, 1300);
													 })
												 }
									    })
									  }
									})
            }

            if(value>(total/1000)){
                $('.example').css({
                    'background-color' : '#fff'
                })
            }
        }

        });

				$(".btn-pause").click(function() {
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
									}, 2000)
								})
							},
							allowOutsideClick: () => false
						}).then((result) => {
							if (result.value) {

								const ipAPI = $('#urlTaskPause').val();

								swal({
									type: 'success',
									title: 'O motivo foi enviado!',
									html: 'Motivo: ' + result.value,
									preConfirm: () => {
										 return $.post(ipAPI, { id: {{ $task->id }}, message : result.value, _token : "{{ csrf_token() }}" }).then((data) => {
											 setTimeout(function() {
													 toastr.options = {
															 closeButton: true,
															 progressBar: true,
															 showMethod: 'slideDown',
															 timeOut: 4000
													 };
													 toastr.success('Mapeador de Processos', data.message);

													 setTimeout(function() {
															window.location.reload();
													 }, 2000)

											 }, 1300);
										 })
									 }
								})
							}
						})
				});

				$(".btn-unpause").click(function() {
					swal({
						  title: 'Deseja Continuar a tarefa?',
						  type: 'warning',
						  showCancelButton: true,
						  confirmButtonColor: '#3085d6',
						  cancelButtonColor: '#d33',
						  confirmButtonText: 'Sim',
						  cancelButtonText: 'Cancelar',
						  confirmButtonClass: 'btn btn-success',
						  cancelButtonClass: 'btn btn-danger',
						  buttonsStyling: true,
						  reverseButtons: true
						}).then((result) => {
						  if (result.value) {

								const urlAPITaskStart = $('#urlTaskStart').val();

								$.post(urlAPITaskStart, { id: {{ $task->id }}, message : result.value, _token : "{{ csrf_token() }}" }).then((data) => {
									setTimeout(function() {
											toastr.options = {
													closeButton: true,
													progressBar: true,
													showMethod: 'slideDown',
													timeOut: 4000
											};
											toastr.success('Mapeador de Processos', data.message);

											setTimeout(function() {
												 window.location.reload();
											}, 2000)

									}, 1300);
								})


						    swal(
						      'OK!',
						      'Agora é só continuar na tarefa.',
						      'success'
						    )
						  // result.dismiss can be 'cancel', 'overlay',
						  // 'close', and 'timer'
						  }
						})
				});

				$("#btn-task-start-blocked").click(function() {
					toastr.options = {
							closeButton: true,
							progressBar: true,
							showMethod: 'slideDown',
							timeOut: 6000
					};
					toastr.warning('Esta tarefa Pertence a um mapeamento, deve primeiro iniciá-lo.', 'Alerta');
				});

</script>

@stop
