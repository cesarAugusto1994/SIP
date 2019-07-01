<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
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
            @endphp

            @foreach($menus as $menu)

                @if($menu->childs->isEmpty() && $menu->parent)
                  @continue;
                @endif

                @permission($menu->permission)

                  <li class="@if(!$menu->childs->isEmpty()) pcoded-hasmenu @endif">
                      <a href="@if(!$menu->childs->isEmpty()) javascript:void(0) @else {{ route($menu->route) }} @endif">
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

                @endpermission

            @endforeach

            @permission('view.chat')

            <li class="">
                <a href="https://providersadee-x6r4398.slack.com/" target="_blank">
                    <span class="pcoded-micon"><i class="far fa-comment-dots"></i></span>
                    <span class="pcoded-mtext">Chat</span>
                </a>
            </li>

            @endpermission

        </ul>

    </div>
</nav>
