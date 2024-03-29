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
        <div class="card-block email-card">
            <div class="row">
                <div class="col-lg-12 col-xl-3">
                    <div class="user-head row">
                        <div class="user-face">
                            <h3>Pasta: {{ $folder->name }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-9">
                    <div class="mail-box-head row">
                        <div class="col-md-12">
                            <form class="f-right">
                                <div class="right-icon-control">
                                    <input type="text" class="form-control  search-text" placeholder="Pesquisar" id="search-friends-2">
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
                            <a href="{{route('emails.create')}}" class="btn btn-success btn-round btn-block">Novo</a>
                        </div>
                        <ul class="page-list nav nav-tabs flex-column" id="pills-tab" role="tablist">

                            <li class="nav-item mail-section">
                                <a class="nav-link {{ request()->get('folder') == 2 ? 'active' : '' }}" href="?folder=2" role="tab">
                                    <i class="icofont icofont-inbox"></i> Caixa de Entrada
                                    <span class="label label-primary f-right">{{$emailsInboxUnSeen}}</span>
                                </a>
                            </li>

                            <li class="nav-item mail-section">
                                <a class="nav-link {{ request()->get('folder') == 7 ? 'active' : '' }}" href="?folder=7" role="tab">
                                    <i class="icofont icofont-star"></i> Arquivados
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link {{ request()->get('folder') == 5 ? 'active' : '' }}" href="?folder=5" role="tab">
                                    <i class="icofont icofont-file-text"></i> Rascunho
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link {{ request()->get('folder') == 4 ? 'active' : '' }}" href="?folder=4" role="tab">
                                    <i class="icofont icofont-paper-plane"></i> Enviados
                                </a>
                            </li>
                            <li class="nav-item mail-section">
                                <a class="nav-link {{ request()->get('folder') == 1 ? 'active' : '' }}" href="?folder=1" role="tab">
                                    <i class="icofont icofont-ui-delete"></i> Lixeira
                                </a>
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
                                <div class="mail-body-content row">
                                    <div class="col-md-12">
                                      <div class="table-responsive">
                                          <table class="table">

                                            @foreach($emails->sortByDesc('id') as $email)
                                              <tr class="{{ $email->flag_seen ? 'read' : 'unread' }}">
                                                  <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name"><b>{{ substr($email->subject, 0, 30) }}</b><br/><small>{{ substr($email->text, 0, 150) }}...</small></a></td>
                                                  <td><a href="{{ route('emails.show', $email->uuid) }}" class="email-name"></a></td>
                                                  <td class="email-attch">@if($email->attachments->isNotEmpty())<a href="#"><i class="icofont icofont-clip"></i></a>@endif</td>
                                                  <td class="email-time"><label class="label label-inverse-primary">{{ $email->date->format('d/m/Y H:i') }}</label></td>
                                              </tr>
                                            @endforeach

                                          </table>
                                      </div>
                                    </div>
                                    <div class="col-md-12 text-center">

                                        {{ $emails->links() }}

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

        /*swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto os e-mails são carregados.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });*/
/*
        var emails = $('#load-emails').val();

        $.ajax({
          type: 'GET',
          url: emails,
          success: function(data) {

            swal.close();

            console.log(data);

          }
        });
*/
      });

  </script>

@stop
