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
                        <a href="{{ route('emails.index') }}"> E-mails </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Novo E-mail</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="card">
        <div class="card-header">
            <h5>Compor nova mensagem</h5>
        </div>
        <div class="card-block email-card">
            <div class="row">
              <div class="col-lg-12 col-xl-12">
                  <div class="mail-body">
                      <div class="mail-body">

                          <div class="mail-body-content">
                              <form>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Para">
                                  </div>
                                  <div class="form-group">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <input type="email" class="form-control" placeholder="Cc">
                                          </div>
                                          <div class="col-md-6">
                                              <input type="email" class="form-control" placeholder="Bcc">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <input type="text" class="form-control" placeholder="Assunto">
                                  </div>
                                  <textarea class="ckeditor" name="name" placeholder="Digite a sua mensagem">
                                      
                                  </textarea>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <!-- Email-card end -->
    </div>
</div>

  <input type="hidden" id="load-emails" value="{{ route('emails_search') }}"/>

@endsection

@section('scripts')

  <script>

      $(document).ready(function() {

          var emails = $('#load-emails');

      });

  </script>

@stop
