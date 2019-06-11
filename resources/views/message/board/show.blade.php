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
                    <li class="breadcrumb-item"><a href="#!">{{ $messageBoard->subject }}</a>
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
                              <div class="media m-b-20">
                                  <div class="media-left photo-table">
                                      <a href="#">
                                          <img class="media-object img-radius" src="{{ route('image', ['user' => $messageBoard->user->uuid, 'link' => $messageBoard->user->avatar, 'avatar' => true])}}" alt="E-mail User">
                                      </a>
                                  </div>
                                  <div class="media-body photo-contant table-responsive">
                                      <a href="#">
                                          <h6 class="user-name txt-primary">{{ $messageBoard->user->person->name }} </h6>
                                      </a>
                                      <small>{{ $messageBoard->created_at->format('d/m/Y H:i:s') }}</small>
                                      <div>
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
                                                    @if(in_array($file->extension, ['jpeg','jpg', 'png', 'PNG']))
                                                        <img class="card-img-top img-fluid img-thumbnail" src="{{ route('image', ['link'=>$file->link]) }}" alt="Anexo">
                                                    @else
                                                        <i class="fa fa-file fa-5x"></i>
                                                    @endif
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

</div>

@endsection
