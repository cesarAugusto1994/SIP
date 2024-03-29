<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo" logo-theme="theme4">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
            </a>
            <a href="{{ route('home') }}" class="text-center">
                <h5 class="text-center">{{ config('app.name') }}</h5>
            </a>
            <a class="mobile-options">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                      <form method="get" action="{{ route('search') }}">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                            <input name="q" type="text" class="form-control">
                            <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                        </div>
                      </form>
                    </div>
                </li>
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()">
                        <i class="feather icon-maximize full-screen"></i>
                    </a>
                </li>

                <li>
                    <a target="_blank" href="https://providersadee-x6r4398​.slack​.com">
                        Slack <i class="fab fa-slack"></i>
                    </a>
                </li>

                <li>
                    <a target="_blank" href="https://webmail-seguro.com.br/locaweb.com/">
                        Webmail <i class="far fa-envelope"></i>
                    </a>
                </li>

                <li>
                    <a data-toggle="modal" data-target="#tickets-Modal" target="_blank" href="#!">
                        Chamado <i class="fas fa-ticket-alt"></i>
                    </a>
                </li>

            </ul>

            @php
                $user = auth()->user();
                $totalNotifications = $user->unreadNotifications->count();
            @endphp

            <ul class="nav-right">
                <li class="header-notification">
                    <div class="dropdown-primary dropdown notification-list">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-bell"></i>
                            <span class="badge bg-c-pink noti-icon-badge notif-count" data-count="{{ $totalNotifications }}">{{ $totalNotifications }}</span>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu  slimscroll" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notificações</h6>
                            </li>

                            <span>
                            @foreach($user->unreadNotifications as $notification)

                              <li>
                                  <div class="media">
                                      <a href="{{ $notification['data']['url'] ?? route('notifications.index') }}">
                                        <div class="media-body">
                                            <p class="notification-msg">{{ $notification['data']['message'] ?? '' }}</p>
                                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                      </a>
                                  </div>
                              </li>

                            @endforeach
                            </span>

                            <li>
                                <a href="{{ route('notifications.index') }}">Todas notificações</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-message-square"></i>
                            <span class="badge bg-c-green">{{ \App\Helpers\Helper::unreadChatMessages()->count() }}</span>
                        </div>
                    </div>
                </li>
                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ route('image', ['link' => \Auth::user()->avatar, 'avatar' => true])}}" class="img-radius" alt="">
                            <span>{{ Auth()->user()->person->name }}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                          <!--
                            <li>
                                <a href="#!">
                                    <i class="feather icon-settings"></i> Configurações
                                </a>
                            </li>
                          -->
                            <li>
                                <a href="{{route('user')}}">
                                    <i class="feather icon-user"></i> Perfil
                                </a>
                            </li>
                          <!--
                            <li>
                                <a href="#">
                                    <i class="feather icon-mail"></i> Mensagens
                                </a>
                            </li>
                          -->
                            <li>
                                <a href="{{ route('lockscreen') }}">
                                    <i class="feather icon-lock"></i> Bloquear Tela
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('change_password', ['user' => auth()->user()->uuid]) }}">
                                    <i class="fa fa-key"></i> Alterar Senha
                                </a>
                            </li>

                            @php

                              $manager = app('impersonate');

                            @endphp

                            @if($manager->isImpersonating())

                              <li>
                                  <a href="{{ route('impersonate.leave') }}">
                                      <i class="feather icon-user"></i> Sair deste Usuário
                                  </a>
                              </li>

                            @endif

                            <li>
                                <a href="javascript:void(0);" class="btnLogout">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </li>
                        </ul>

                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>

<div class="modal fade" id="tickets-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Novo Chamado</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="formValidationTickets" data-parsley-validate method="post" action="{{ route('tickets.store') }}">
              @csrf
              <div class="modal-body">

                <div class="row m-b-30">

                  <div class="col-md-12">

                    <div class="form-group">
                        <label class="col-form-label">Qual é o problema?</label>
                        <div class="input-group">
                          <select class="form-control m-b select2" name="type_id" required>
                              <option value="">Informe o tipo de chamado</option>
                              @foreach(\App\Helpers\Helper::ticketCategories() as $category)
                                <optgroup label="{{ $category->name }}">
                                @foreach($category->types as $type)
                                  @if(!$type->active) @continue; @endif
                                  <option value="{{$type->id}}" {{ request()->has('type') && request()->get('type') == $type->uuid ? 'selected' : '' }}>{{$type->name}}</option>
                                @endforeach
                                </optgroup>
                              @endforeach
                          </select>
                        </div>
                    </div>

                  </div>

                  <div class="col-md-12">

                    <div class="form-group">
                        <label class="col-form-label">Descrição</label>
                        <div class="input-group">
                          <textarea rows="5" required name="description" class="form-control ckeditor"></textarea>
                        </div>
                    </div>

                  </div>

                </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-success waves-effect waves-light ">Salvar</button>
              </div>
            </form>
        </div>
    </div>
</div>

<!-- Sidebar chat start -->
<div id="sidebar" class="users p-chat-user showChat">
    <div class="had-container">
        <div class="card card_main p-fixed users-main">
            <div class="user-box">
                <div class="chat-inner-header">
                    <div class="back_chatBoxs">
                        <div class="right-icon-control">
                            <input type="text" class="form-control search-text" placeholder="Pesquisar" id="search-friends">
                            <div class="form-icon">
                                <i class="icofont icofont-search"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-friend-list">

                  @php

                      $users = \App\Helpers\Helper::usersBySentMessages();

                  @endphp


                  @forelse(\App\Helpers\Helper::onlineUsersList() as $user)

                    @if(Auth::user()->id == $user->id)
                        @continue;
                    @endif

                    <div class="media userlist-box" data-id="{{ $user->id }}" data-status="online" data-username="{{ $user->person->name }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="{{ $user->person->name }}">
                        <a class="media-left" href="{{ route('chat_user', $user->uuid) }}">
                            <img class="media-object img-radius img-radius" src="{{ route('image', ['user' => $user->person->user->uuid, 'link' => $user->person->user->avatar, 'avatar' => true])}}" alt="">
                        </a>
                        <div class="media-body">
                          <a href="{{ route('chat_user', $user->uuid) }}">
                            <div class="f-13 chat-header">{{ $user->person->name }}</div>
                            <span>{{ $user->person->department->name }}</span>
                            @if($user->person->branch)
                              <br/>
                              <span>Ramal: {{ $user->person->branch }}</span>
                            @endif
                          </a>
                        </div>
                    </div>

                  @empty

                    <div class="media userlist-box">

                      <div class="widget white-bg no-padding">
                          <div class="p-m text-center">
                              <h1 class="m-md"><i class="far fa-comment-dots fa-2x"></i></h1>
                              <br/>
                              <h6 class="font-bold no-margins">
                                  Nenhuma mensagem até o momento.
                              </h6>
                          </div>
                      </div>

                    </div>

                  @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
