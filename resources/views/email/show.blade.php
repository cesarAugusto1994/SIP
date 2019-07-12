@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>E-mails</h4>
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
                        <a href="{{ route('emails.index') }}">E-mails</a>
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
        <div class="card-block email-card">

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="mail-body">
                        <div class="mail-body-content email-read">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ $email->subject }}</h5>
                                    <h6 class="f-right">{{ $email->date->format('d/m/Y H:i') }}</h6>
                                </div>
                                <div class="card-block">
                                    <div class="media m-b-20">

                                        @php

                                            $from = $email->from->first();

                                        @endphp

                                        <div class="media-left photo-table">
                                            <a href="#">
                                                <img class="media-object img-radius" src="{{ \Avatar::create($from->contact->personal ?? $from->contact->mailbox)->toBase64() }}" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body photo-contant">

                                            <a href="#">
                                                <h6 class="user-name txt-primary">{{ $from->contact->personal ?? $from->contact->mailbox }}</h6>
                                            </a>
                                            <a class="user-mail txt-muted" href="#">
                                                <h6>De: {{ $from->contact->mail }}</h6>
                                            </a>

                                            <div style="" id="semail-template"></div>

                                            <iframe src="{{ route('emails_template', $email->uuid) }}" width="100%" height="500" frameborder="0" marginheight="0" marginwidth="0">
                                                Cerragando...
                                            </iframe>

                                            <div id="semail-template">

                                            </div>

                                            <div class="m-t-15">
                                                <i class="icofont icofont-clip f-20 m-r-10"></i>Anexos <b>({{$email->attachments->count()}})</b>
                                                <div class="row mail-img">
                                                  @foreach($email->attachments as $attachment)
                                                    <div class="col-sm-4 col-md-2 col-xs-12">
                                                        <a href="#">{{ $attachment->name }}</a>
                                                    </div>
                                                  @endforeach
                                                </div>
                                                <textarea class="form-control m-t-30 col-xs-12 email-textarea ckeditor" id="exampleTextarea-1" placeholder="Responder" rows="4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right-side section end -->
            </div>
        </div>
        <!-- Email-card end -->

    </div>
</div>

<input type="hidden" id="load-emails-template" value="{{ route('emails_template', $email->uuid) }}"/>

@endsection

@section('scripts')

  <script>

      $(document).ready(function() {

          var template = $('#load-emails-template').val();
          var emailDiv = $('#email-template');

          $.get(template, function(data) {
              emailDiv.append(data);
          })

      });

  </script>

@stop
