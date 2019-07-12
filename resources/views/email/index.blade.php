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
                    <li class="breadcrumb-item"><a href="#!">E-mails</a>
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
                <div class="col-lg-12 col-xl-3">
                    <div class="user-head row">
                        <div class="user-face">
                            <img class="img-fluid" src="..\files\assets\images\logo.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-9">
                    <div class="mail-box-head row">
                        <div class="col-md-12">
                            <form class="f-right">
                                <div class="right-icon-control">
                                    <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends-2">
                                    <div class="form-icon">
                                        <i class="icofont icofont-search"></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Left-side section start -->
                <div class="col-lg-12 col-xl-3">
                    <div class="user-body">
                        <div class="p-20 text-center">
                            <a href="#" class="btn btn-success btn-round btn-block">Novo</a>
                        </div>
                        <ul class="page-list nav nav-tabs flex-column" id="pills-tab" role="tablist">
                            <li class="nav-item mail-section">
                                <a class="nav-link active" data-toggle="pill" href="#e-inbox" role="tab">
                                    <i class="icofont icofont-inbox"></i> Inbox
                                    <span class="label label-primary f-right">6</span>
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link" data-toggle="pill" href="#e-starred" role="tab">
                                    <i class="icofont icofont-star"></i> Starred
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link" data-toggle="pill" href="#e-drafts" role="tab">
                                    <i class="icofont icofont-file-text"></i> Drafts
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link" data-toggle="pill" href="#e-sent" role="tab">
                                    <i class="icofont icofont-paper-plane"></i> Sent Mail
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link" data-toggle="pill" href="#e-trash" role="tab">
                                    <i class="icofont icofont-ui-delete"></i> Trash
                                    <span class="label label-info f-right">30</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="p-20 label-list">
                            <li>
                                <h5>Labels</h5>
                            </li>
                            <li>
                                <a class="mail-work" href="">Work</a>
                            </li>
                            <li>
                                <a class="mail-design" href="">Design</a>
                            </li>
                            <li>
                                <a class="mail-family" href="">Family</a>
                            </li>
                            <li>
                                <a class="mail-friends" href="">Friends</a>
                            </li>
                            <li>
                                <a class="mail-office" href="">Office</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Left-side section end -->
                <!-- Right-side section start -->
                <div class="col-lg-12 col-xl-9">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="e-inbox" role="tabpanel">

                            <div class="mail-body">
                                <div class="mail-body-header">
                                    <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-exclamation-circle"></i>
                                      </button>
                                    <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-inbox"></i>
                                      </button>
                                    <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-ui-delete"></i>
                                      </button>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="icofont icofont-ui-folder"></i>
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              More
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-body-content">
                                    <div class="table-responsive">
                                        <table class="table">

                                          @foreach($emailsInbox->sortByDesc('id') as $email)
                                            <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ $email->subject }}</a></td>
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ substr($email->text, 0, 40) }}...</a></td>
                                                <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                <td class="email-time">{{ $email->date->format('d/m/Y H:i') }}</td>
                                            </tr>
                                          @endforeach

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="e-starred" role="tabpanel">
                            <div class="mail-body">
                                <div class="mail-body-header">
                                    <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-star"></i>
                                      </button>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="icofont icofont-ui-folder"></i>
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              More
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-body-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                          @foreach($emailsSent->sortByDesc('id') as $email)
                                            <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ $email->subject }}</a></td>
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ substr($email->text, 0, 40) }}...</a></td>
                                                <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                <td class="email-time">{{ $email->date->format('d/m/Y H:i') }}</td>
                                            </tr>
                                          @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="e-drafts" role="tabpanel">

                            <div class="mail-body">
                                <div class="mail-body-header">
                                    <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-inbox"></i>
                                      </button>
                                    <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-ui-delete"></i>
                                      </button>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="icofont icofont-ui-folder"></i>
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              More
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-body-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                          @foreach($emailsSent->sortByDesc('id') as $email)
                                            <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ $email->subject }}</a></td>
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ substr($email->text, 0, 40) }}...</a></td>
                                                <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                <td class="email-time">{{ $email->date->format('d/m/Y H:i') }}</td>
                                            </tr>
                                          @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="e-sent" role="tabpanel">

                            <div class="mail-body">
                                <div class="mail-body-header">
                                    <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-exclamation-circle"></i>
                                      </button>
                                    <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-ui-delete"></i>
                                      </button>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="icofont icofont-ui-folder"></i>
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              More
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-body-content">
                                    <div class="table-responsive">
                                        <table class="table">

                                          @foreach($emailsSent->sortByDesc('id') as $email)
                                            <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ $email->subject }}</a></td>
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ substr($email->text, 0, 40) }}...</a></td>
                                                <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                <td class="email-time">{{ $email->date->format('d/m/Y H:i') }}</td>
                                            </tr>
                                          @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="e-trash" role="tabpanel">

                            <div class="mail-body">
                                <div class="mail-body-header">
                                    <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                          <i class="icofont icofont-exclamation-circle"></i>
                                      </button>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              <i class="icofont icofont-ui-folder"></i>
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                    <div class="btn-group dropdown-split-primary">
                                        <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              More
                                          </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-body-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                          @foreach($emailsSent->sortByDesc('id') as $email)
                                            <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ $email->subject }}</a></td>
                                                <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name">{{ substr($email->text, 0, 40) }}...</a></td>
                                                <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                <td class="email-time">{{ $email->date->format('d/m/Y H:i') }}</td>
                                            </tr>
                                          @endforeach
                                        </table>
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

  <input type="hidden" id="load-emails" value="{{ route('emails_search') }}"/>

@endsection

@section('scripts')

  <script>

      $(document).ready(function() {

          var emails = $('#load-emails');

      });

  </script>

@stop
