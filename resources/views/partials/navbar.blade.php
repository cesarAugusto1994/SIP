<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">

        <div class="navbar-logo" logo-theme="theme4">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu"></i>
            </a>
            <a href="{{ route('home') }}">SIP - Provider
              <!--
                <img class="img" src="{{ asset('images\logo-provider.png') }}" width="70%" alt="SIP - Provider">
              -->
            </a>
            <a class="mobile-options">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>

        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li class="header-search">
                    <div class="main-search morphsearch-search">
                        <div class="input-group">
                            <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#!" onclick="javascript:toggleFullScreen()">
                        <i class="feather icon-maximize full-screen"></i>
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
                            <span class="badge bg-c-pink noti-icon-badge" data-count="{{ $totalNotifications }}">{{ $totalNotifications }}</span>
                        </div>
                        <ul class="show-notification notification-view dropdown-menu  slimscroll" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                            <li>
                                <h6>Notificações</h6>
                            </li>

                            @foreach($user->unreadNotifications as $notification)

                              <li>
                                  <div class="media">
                                      <a href="{{ route('notifications.index') }}">
                                        <div class="media-body">
                                            <p class="notification-msg">{{ $notification['data']['message'] ?? '' }}</p>
                                            <span class="notification-time">{{ \App\Helpers\TimesAgo::render($notification->created_at) }}</span>
                                        </div>
                                      </a>
                                  </div>
                              </li>

                            @endforeach

                            <li>
                                <a href="{{ route('notifications.index') }}">Todas notificações</a>
                            </li>

                        </ul>
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
