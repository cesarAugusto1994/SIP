@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Mural de Recados</h4>
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
                        <a href="{{ route('home') }}"> Mural de Recados </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Detalhes</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

<div class="card">
  <!-- Email-card start -->
  <div class="card-block">

      <div class="row">

          <div class="col-lg-12 col-xl-12">
              <div class="mail-body">
                  <div class="mail-body-content email-read">
                      <div class="card">
                          <div class="card-header">
                              <h5>{{ $messageBoard->subject }}</h5>
                              <h6 class="f-right">{{ \App\Helpers\TimesAgo::render($messageBoard->created_at) }}</h6>
                          </div>
                          <div class="card-block">
                              <div class="">
                                  <div class="media-left photo-table">
                                      <a href="#">
                                          <img class="media-object img-radius" src="{{ route('image', ['user' => $messageBoard->user->uuid, 'link' => $messageBoard->user->avatar, 'avatar' => true])}}" alt="E-mail User">
                                      </a>
                                  </div>
                                  <div class="media-body photo-contant">
                                      <a href="#">
                                          <h6 class="user-name txt-primary">{{ $messageBoard->user->person->name }} </h6>
                                      </a>

                                      @permission('delete.mural.de.recados')
                                          <div class="f-right">
                                            @if(auth()->user()->isAdmin() || auth()->user()->id == $messageBoard->user->id)
                                              <a data-route="{{ route('message-board.destroy', $messageBoard->uuid) }}" class="btn btn-danger text-white btn-sm waves-effect waves-light btnRemoveItemToBack" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remover"><i class="icofont icofont-close"></i>Remover</a>
                                            @endif
                                          </div>
                                      @endpermission

                                      <small>{{ $messageBoard->created_at->format('d/m/Y H:i:s') }}</small>
                                      <div class="table-responsive">
                                        <p class="email-content">
                                              {!! $messageBoard->content !!}
                                        </p>
                                      </div>
                                      <div class="m-t-15">
                                          <i class="icofont icofont-clip f-20 m-r-10"></i>Anexos <b>({{ $messageBoard->attachments->count() }})</b>
                                          <div class="row mail-img">

                                            @foreach($messageBoard->attachments as $file)

                                              <div class="col-sm-4 col-md-2 col-xs-12">
                                                  <a target="_blank" href="{{ route('image', ['link'=>$file->link]) }}">
                                                    <div class="file-name">
                                                        {{ $file->filename }}
                                                        <br>
                                                        <small>{{ $file->created_at->format('M d, Y H:i') }}</small>
                                                    </div>
                                                  </a>
                                              </div>

                                            @endforeach

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

</div>
@if(auth()->user()->isAdmin())
<div class="card">
    <div class="card-header">
        <h5 class="card-header-text"><i class="icofont icofont-certificate-alt-2 m-r-10"></i> Atividades</h5>
    </div>
    <div class="card-block revision-block">
        <div class="form-group">
            <div class="row">
                <ul class="media-list revision-blc">
                  @foreach($messageBoard->messages->sortByDesc('id') as $log)
                    <li class="media d-flex m-b-15">
                        <div class="p-l-15 p-r-20 d-inline-block v-middle">
                          <img width="40" class="img-radius" src="{{ route('image', ['user' => $log->user->uuid, 'link' => $log->user->avatar, 'avatar' => true])}}" alt="chat-user">
                        </div>

                        @php

                          $status = $log->status;

                          $bgColor = 'success';

                          switch($status) {
                            case 'PENDENTE':
                              $bgColor = 'warning';
                              break;
                            case 'ENVIADO':
                              $bgColor = 'primary';
                              break;
                            case 'VISUALIZADO':
                              $bgColor = 'success';
                              break;
                            case 'REMOVIDO':
                              $bgColor = 'danger';
                              break;
                          }

                        @endphp

                        <div class="d-inline-block">
                            {{ $log->user->person->name }}
                            <div class="media-annotation"><span class="label label-{{$bgColor}}">{{ $log->status }}</span></div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

</div>
@endif
@endsection
