<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation</div>
        <ul class="pcoded-item pcoded-left-item">
            <li class="">
                <a href="{{ route('home') }}">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Painel Principal</span>
                </a>
            </li>

            @php
                $menus = \App\Helpers\Helper::menus();
            @endphp

            @foreach($menus as $menu)

                @if($menu->childs->isEmpty())
                  @continue;
                @endif

                @permission($menu->permission)

                <li class="pcoded-hasmenu">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
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

        </ul>

    </div>
</nav>
