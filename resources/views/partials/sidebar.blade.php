<nav class="pcoded-navbar">
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navegação</div>
        <ul class="pcoded-item pcoded-left-item">

            @php
                $menus = \App\Helpers\Helper::menus();
                $user = auth()->user();
            @endphp

            @foreach($menus as $menu)

                @if($menu->childs->isEmpty() && $menu->parent)
                  @continue;
                @endif

                @if(!$menu->active)
                  @continue;
                @endif

                @if($user->hasPermission($menu->permission))

                  @php

                    $hasActiveItems = $menu->childs->where('active', true)->first();

                    if(!$hasActiveItems && $menu->childs->isNotEmpty()) {
                       continue;
                    }

                  @endphp

                  <li class="@if($menu->childs->isNotEmpty()) pcoded-hasmenu @endif">
                      <a href="@if($menu->childs->isNotEmpty()) javascript:void(0) @elseif($menu->route) {{ route($menu->route) }} @endif">
                          <span class="pcoded-micon"><i class="{{ $menu->icon }}"></i></span>
                          <span class="pcoded-mtext">{{ $menu->title }}</span>
                      </a>

                      @if($menu->childs->isNotEmpty())

                        <ul class="pcoded-submenu">

                            @foreach($menu->childs as $child)

                              @if(!$child->active)
                                @continue;
                              @endif

                              @permission($child->permission)

                                <li class="">
                                    <a href="@if($child->route) {{ route($child->route) }} @else '#' @endif">
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
                <a target="_blank" href="https://providersadee-x6r4398​.slack​.com">
                    <span class="pcoded-micon"><i class="fab fa-slack"></i></span>
                    <span class="pcoded-mtext">Chat Slack</span>
                </a>
            </li>

            @endpermission

            @permission('view.email')

            <li>
                <a class="text-success" target="_blank" href="https://webmail-seguro.com.br/locaweb.com/">
                    <span class="pcoded-micon"><i class="far fa-envelope"></i></span>
                    <span class="pcoded-mtext">Webmail</span>
                </a>
            </li>

            @endpermission

            <li class="">
                <a href="#!" class="btnRedirectSoc">
                    <span class="pcoded-micon"><i class="fa fa-key"></i></span>
                    <span class="pcoded-mtext">Soc</span>
                </a>

                <form method="post" action="https://www.soc.com.br/WebSoc/LoginAction.do" id="formularioLoginSoc" target="_blank" class="hidden" style="display:none">
                  <input required="" name="usu" id="usu" value="{{ \Auth::user()->login_soc }}" type="text" class="FormatForm hidden" placeholder="Usuário">
                  <input required="" name="senha" id="senha" value="{{ \Auth::user()->password_soc }}" type="password" class="FormatForm hidden" placeholder="Senha">
                  <div class="row">
                    <div class="column column-8">
                      <input required="" name="empsoc" id="empsoc" value="{{ \Auth::user()->id_soc }}" type="text" class="FormatForm hidden" placeholder="ID">
                    </div>
                  </div>
                </form>

            </li>

        </ul>

    </div>
</nav>
