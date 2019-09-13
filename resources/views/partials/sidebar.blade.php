<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navegação</div>
        <ul class="pcoded-item pcoded-left-item">

            @permission('view.painel.principal')

            <li class="">
                <a href="{{ route('home') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Painel Principal</span>
                </a>
            </li>

            @endpermission

            @php
                $menus = \App\Helpers\Helper::menus();
                $user = auth()->user();
            @endphp

            @foreach($menus as $menu)

                @if($menu->childs->isEmpty() && $menu->parent)
                  @continue;
                @endif

                @if($user->hasPermission($menu->permission))

                  <li class="@if($menu->childs->isNotEmpty()) pcoded-hasmenu @endif">
                      <a href="@if($menu->childs->isNotEmpty()) javascript:void(0) @elseif($menu->route) {{ route($menu->route) }} @endif">
                          <span class="pcoded-micon"><i class="{{ $menu->icon }}"></i></span>
                          <span class="pcoded-mtext">{{ $menu->title }}</span>
                      </a>

                      @if($menu->childs->isNotEmpty())

                        <ul class="pcoded-submenu">

                            @foreach($menu->childs as $child)

                            @permission($child->permission)

                            <li class="">
                                <a href="{{ route($child->route) }}">
                                    <span class="pcoded-mtext">{{ $child->title }}</span>
                                </a>
                            </li>

                            @endpermission

                            @endforeach

                        </ul>

                      @endif
                  </li>

                @endif

            @endforeach

            @permission('view.chat')

            <li class="">
                <a href="{{ route('chat') }}">
                    <span class="pcoded-micon"><i class="far fa-comment-dots"></i></span>
                    <span class="pcoded-mtext">Chat</span>
                </a>
            </li>

            @endpermission

        </ul>

    </div>
</nav>
