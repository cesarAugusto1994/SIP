@extends('base')

@section('content')

@php
    $currentUser = auth()->user();
@endphp

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Perfil</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Perfil do usuário</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <!--profile cover start-->
    <div class="row">
        <div class="col-lg-12">
            <div class="cover-profile">
                <div class="profile-bg-img">
                    <img class="profile-bg-img img-fluid" src="{{ asset('adminty\images\user-profile\bg-img1.jpg') }}" alt="">
                    <div class="card-block user-info">
                        <div class="col-md-12">
                            <div class="media-left">
                                <a href="#" class="profile-image">
                                    <img class="user-img img-radius" width="258" src="{{ route('image', ['user' => $person->user->uuid, 'link' => $person->user->avatar, 'avatar' => true])}}" alt="">
                                </a>
                            </div>
                            <div class="media-body row">
                                <div class="col-lg-12">
                                    <div class="user-title">
                                        <h2>{{ $person->name }}</h2>
                                        <span class="text-white">{{$person->occupation->name}}</span>
                                        <br/>
                                        @if($person->user->active)
                                            <span class="text-white"> <i class="fa fa-circle text-success" title="Ativo"></i> Ativo</span>
                                        @else
                                            <span class="text-white"> <i class="fa fa-circle text-danger" title="Inativo"></i> Inativo</span>
                                        @endif

                                    </div>
                                </div>
                                <div>
                                    <div class="pull-right cover-btn">

                                        <a href="#" class="btn btn-primary btn-sm waves-effect waves-light m-r-10">Trocar Foto de Perfil</a>

                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right b-none contact-menu">

                                          <a href="{{ route('change_password', ['user' => $person->user->uuid]) }}" class="dropdown-item">Alterar Senha</a>
                                          @if(auth()->user()->id !== $person->user->id)
                                            <a class="dropdown-item" href="{{ route('impersonate', $person->user->id) }}">logar como</a>
                                          @endif

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--profile cover end-->
    <div class="row">
        <div class="col-lg-12">
            <!-- tab header start -->
            <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Informações Pessoais</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#configs" role="tab">Configurações</a>
                        <div class="slide"></div>
                    </li>
                    @if($currentUser->isAdmin())
                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#roles" role="tab">Permissões</a>
                          <div class="slide"></div>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#folders" role="tab">Pastas e Arquivos</a>
                          <div class="slide"></div>
                      </li>
                    @endif
                </ul>
            </div>
            <!-- tab header end -->
            <!-- tab content start -->
            <div class="tab-content">
                <!-- tab panel personal start -->
                <div class="tab-pane active" id="personal" role="tabpanel">
                    <!-- personal card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Informações Pessoais</h5>
                        </div>
                        <div class="card-block">
                            <div class="view-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table m-0">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Nome</th>
                                                                    <td>{{ $person->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Telefone</th>
                                                                    <td>{{ $person->phone ?? '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Ramal</th>
                                                                    <td>{{ $person->branch ?? '-' }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">ID Ligação Externa</th>
                                                                    <td>{{ $person->phone_code ?? '-' }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">Senha Ligação Externa</th>
                                                                    <td>{{ $person->phone_password ?? '-' }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th scope="row">ID Callcenter</th>
                                                                    <td>{{ $person->phone_callcenter_code ?? '-' }}</td>
                                                                </tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- end of table col-lg-6 -->
                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row">Email</th>
                                                                    <td>{{ $person->user->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Departamento</th>
                                                                    <td>{{$person->department->name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Cargo</th>
                                                                    <td>{{$person->occupation->name}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Adicionado em</th>
                                                                    <td>{{ $person->user->created_at ? $person->user->created_at->format('d/m/Y H:i') : '-' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Último Login</th>
                                                                    <td>{{ $person->user->lastLoginAt() ? $person->user->lastLoginAt()->format('d/m/Y H:i') : '-' }}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- end of table col-lg-6 -->
                                            </div>
                                            <!-- end of row -->
                                        </div>
                                        <!-- end of general info -->
                                    </div>
                                    <!-- end of col-lg-12 -->
                                </div>
                                <!-- end of row -->
                            </div>
                            <!-- end of view-info -->
                        </div>
                        <!-- end of card-block -->
                    </div>
                    <div class="row">
                        <div class="col-lg-8">

                            <div class="card user-activity-card">
                              <div class="card-header">
                                <h5>Atividades</h5>
                                <span>Fluxo de atividades do usuário</span>
                                <div class="card-header-right">
                                    <ul class="list-unstyled card-option">
                                        <li><i class="feather icon-minus minimize-card"></i></li>
                                    </ul>
                                </div>
                              </div>
                              <div class="card-block">

                                @if($activities->isNotEmpty())

                                  @foreach($activities->take(4) as $activity)

                                    <div class="row m-b-25">
                                        <div class="col">
                                            <h6 class="m-b-5">{{ $activity->created_at->format('d/m/Y H:i:s') }}</h6>
                                            <p class="text-muted m-b-0">{{ $activity->description }} {{ html_entity_decode(\App\Helpers\Helper::getTagHmtlForModel($activity->subject_type, $activity->subject_id)) }}</p>
                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>{{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                  @endforeach

                                  <div class="text-center">
                                      <a href="{{ route('activities.index') }}" class="b-b-primary text-primary">Ver todas atividades</a>
                                  </div>

                                @endif

                              </div>
                          </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="card user-activity-card">
                              <div class="card-header">
                                <h5>Log de Acessos</h5>
                                <span>Fluxo de acessos do usuário</span>
                                <div class="card-header-right">
                                    <ul class="list-unstyled card-option">
                                        <li><i class="feather icon-minus minimize-card"></i></li>
                                    </ul>
                                </div>
                              </div>
                              <div class="card-block">

                                @if($person->user->authentications->isNotEmpty())

                                  @foreach($person->user->authentications as $login)

                                    <div class="row m-b-25">
                                        <div class="col">
                                            <h6 class="m-b-5">{{ $login->login_at ? $login->login_at->diffForHumans() : '' }} </h6>
                                            <p class="text-muted m-b-0">Logou em: {{ $login->login_at ? $login->login_at->format('d/m/Y H:i:s') : '' }}</p>
                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>Tempo de sessão: {{ \App\Helpers\TimesAgo::diffBetween($login->login_at, $login->logout_at) }}</p>
                                        </div>
                                    </div>

                                  @endforeach

                                  <div class="text-center">
                                      <a href="#!" class="b-b-primary text-primary">Ver todos logs</a>
                                  </div>

                                @endif

                              </div>
                          </div>

                        </div>
                    </div>
                    <!-- personal card end-->
                </div>
                <!-- tab pane personal end -->
                <!-- tab pane info start -->
                <div class="tab-pane" id="configs" role="tabpanel">

                  <div class="row">
                      <div class="col-lg-8">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Editar Configurações</h5>
                            </div>
                            <div class="card-block">

                              <form class="formValidation" data-parsley-validate enctype="multipart/form-data" action="{{route('user_update', ['id' => $user->uuid])}}" method="post">
                                  {{csrf_field()}}

                                  <div class="row">

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">Nome</label>
                                            <div class="input-group">
                                              <input type="text" required name="name" value="{{$user->person->name}}" class="form-control">
                                            </div>
                                        </div>

                                        @if($currentUser->isAdmin())
                                        <div class="form-group">
                                            <label class="col-form-label">Departamento</label>
                                            <div class="input-group">
                                              <select class="form-control select-occupations" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%" data-search-occupations="{{ route('occupation_search') }}" name="department_id" required>
                                                  @foreach($departments as $department)
                                                      <option value="{{$department->uuid}}" {{ $user->person->department_id == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                                                  @endforeach
                                              </select>
                                            </div>
                                        </div>
                                        @endif


                                      </div>

                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">CPF</label>
                                            <div class="input-group">
                                              <input type="text" name="cpf" value="{{$user->person->cpf}}" class="form-control inputCpf">
                                            </div>
                                        </div>
                                        @if($currentUser->isAdmin())
                                        <div class="form-group">
                                            <label class="col-form-label">Cargo</label>
                                            <div class="input-group">
                                              <select class="form-control" data-live-search="true" title="Selecione" data-style="btn-white" data-width="100%"  id="occupation" name="occupation_id" required>

                                                  @foreach($occupations as $occupation)
                                                      <option value="{{$occupation->uuid}}" {{ $user->person->occupation_id == $occupation->id ? 'selected' : '' }}>{{$occupation->name}}</option>
                                                  @endforeach

                                              </select>
                                            </div>
                                        </div>
                                        @endif

                                      </div>
                                      @if($currentUser->isAdmin())
                                          <div class="col-md-6">
                                            <div class="form-group {!! $errors->has('unit_id') ? 'has-error' : '' !!}">
                                                <label class="col-form-label">Unidade</label>
                                                <div class="input-group">
                                                  <select class="form-control" id="unit" name="unit_id" required>
                                                    @foreach($units as $unit)
                                                        <option value="{{$unit->uuid}}">{{$unit->name}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                {!! $errors->first('unit_id', '<p class="help-block">:message</p>') !!}
                                            </div>
                                          </div>
                                      @endif
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">E-mail</label>
                                            <div class="input-group">
                                              <input type="email" readonly name="email" value="{{$user->email}}" class="form-control">
                                            </div>
                                        </div>


                                      </div>

                                      <div class="col-md-6">

                                        @php

                                          $day = null;

                                          if($user->person->birthday) {
                                            $day = $user->person->birthday->format('d/m/Y');
                                          }

                                        @endphp

                                        <div class="form-group">
                                            <label class="col-form-label">Nascimento</label>
                                            <div class="input-group">
                                              <input type="text" name="birthday" value="{{$day}}" class="form-control inputDate">
                                            </div>
                                        </div>

                                      </div>

                                      <div class="col-md-6">

                                          <div class="form-group">
                                              <label class="col-form-label">Telefone</label>
                                              <div class="input-group">
                                                <input type="text" name="phone" value="{{$user->person->phone}}" class="form-control inputPhone">
                                              </div>
                                          </div>

                                      </div>

                                      <div class="col-md-6">

                                          <div class="form-group">
                                              <label class="col-form-label">Ramal</label>
                                              <div class="input-group">
                                                <input type="text" name="branch" value="{{$user->person->branch}}" class="form-control">
                                              </div>
                                          </div>

                                      </div>

                                      <div class="col-md-6">

                                          <div class="form-group">
                                              <label class="col-form-label">Registro do Conselho Profissional</label>
                                              <div class="input-group">
                                                <input type="text" name="registry" value="{{$user->person->registry}}" class="form-control">
                                              </div>
                                          </div>

                                      </div>

                                      <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">Avatar</label>
                                            <div class="input-group">

                                              <input name="avatar" data-buttonText="Selecionar Imagem" data-dragdrop="true" data-badge="false" type="file" data-input="true" accept="image/*" class="filestyle" multiple/>

                                            </div>
                                        </div>

                                      </div>
                                      @if($currentUser->isAdmin())
                                        <div class="col-md-6">
                                          <div class="form-group {!! $errors->has('active') ? 'has-error' : '' !!}">
                                              <label class="col-form-label" for="active">Ativo</label>
                                              <div class="input-group">
                                                  <input class="js-switch" type="checkbox" id="active" name="active" {{ $user->active ? 'checked' : '' }} data-plugin="switchery" value="{{ 1 }}">
                                              </div>
                                              {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
                                          </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="form-group {!! $errors->has('do_task') ? 'has-error' : '' !!}">
                                              <label class="col-form-label" for="active">Realiza Tarefas</label>
                                              <div class="input-group">
                                                  <input class="js-switch" type="checkbox" id="do_task" name="do_task" {{ $user->do_task ? 'checked' : '' }} data-plugin="switchery" value="{{ 1 }}">
                                              </div>
                                              {!! $errors->first('do_task', '<p class="help-block">:message</p>') !!}
                                          </div>
                                        </div>
                                      @endif
                                  </div>

                                  <br/>

                                  <button type="submit" class="btn btn-success btn-sm">Salvar</button>

                              </form>

                            </div>
                        </div>

                      </div>

                      <div class="col-lg-4">

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-header-text">Editar Acessos</h5>
                            </div>
                            <div class="card-block">

                              <form data-parsley-validate action="{{route('user_update_configurations', ['id' => $user->uuid])}}" method="post">
                                  @csrf

                                  <div class="row m-b-30">

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">Usuário SOC</label>
                                            <div class="input-group">
                                              <input type="text" name="login_soc" value="{{ $user->login_soc ?? '' }}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">Senha SOC</label>
                                            <div class="input-group">
                                              <input type="password" name="password_soc" value="{{$user->password_soc ?? ''}}" class="form-control" autocomplete="off">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">ID SOC</label>
                                            <div class="input-group">
                                              <input type="text" name="id_soc" value="{{$user->id_soc??''}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">ID Ligação Externa</label>
                                            <div class="input-group">
                                              <input type="text" name="phone_code" value="{{$user->person->phone_code??''}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">Senha Ligação Externa</label>
                                            <div class="input-group">
                                              <input type="text" name="phone_password" value="{{$user->person->phone_password??''}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">ID Callcenter</label>
                                            <div class="input-group">
                                              <input autocomplete="off" type="text" name="phone_callcenter_code" value="{{$user->person->phone_callcenter_code??''}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label class="col-form-label">Senha E-mail</label>
                                            <div class="input-group">
                                              <input autocomplete="off" type="password" name="pass_email" value="{{$user->password_email??''}}" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    @if($currentUser->isAdmin() && $currentUser->id != $user->id)
                                    <div class="col-md-12">

                                        <div class="form-group {!! $errors->has('roles') ? 'has-error' : '' !!}">
                                            <label class="col-form-label">Previlégios</label>
                                            <div class="input-group">
                                              <select id="role" name="roles" required="required" class="form-control" title="Selecione">
                                                @foreach($roles as $role)
                                                  <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                            {!! $errors->first('roles', '<p class="help-block">:message</p>') !!}
                                        </div>

                                    </div>
                                    @endif

                                  </div>

                                  <button type="submit" class="btn btn-success btn-sm">Salvar</button>
                              </form>

                            </div>
                        </div>

                      </div>

                  </div>

                </div>
                <!-- tab pane info end -->
                <!-- tab pane contact start -->
                <div class="tab-pane" id="roles" role="tabpanel">

                  <div class="card">
                      <div class="card-header">
                          <h5 class="card-header-text">Editar Permissões</h5>
                      </div>
                      <div class="card-block accordion-block color-accordion-block">
                          <div class="color-accordion ui-accordion ui-widget ui-helper-reset" id="color-accordion" role="tablist">

                              @foreach($modules as $key => $module)

                                  @if($module->children->isNotEmpty())

                                      <a class="accordion-msg b-none scale_active ui-accordion-header ui-corner-top ui-state-default ui-accordion-icons ui-accordion-header-active ui-state-active" role="tab" id="ui-id-{{ $loop->index }}-{{ $loop->index }}" aria-controls="ui-id-{{ $loop->index }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" tabindex="0"><span class="ui-accordion-header-icon ui-icon zmdi zmdi-chevron-up"></span>{{$module->name}}</a>
                                      <div class="accordion-desc ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content ui-accordion-content-active" style="" id="ui-id-{{ $loop->index }}" aria-labelledby="ui-id-{{ $loop->index }}" role="tabpanel" aria-hidden="false">

                                        @forelse($module->children as $item)

                                          <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                                            <h5>
                                                {{$item->name}}
                                            </h5>
                                          </div>

                                          <table class="table table-borderd">
                                              <tbody>
                                              @foreach($item->permissions as $permission)

                                              @php
                                                  $hasPermission = $user->hasPermission($permission->slug);
                                              @endphp

                                              <tr>
                                                  <td class="project-actions">
                                                      <input {{ auth()->user()->id == $user->id ? 'disabled' : '' }} type="checkbox" class="js-switch checkboxPermissions" {{ $hasPermission ? 'checked' : '' }}
                                                        data-route-grant="{{route('user_permissions_grant', [$user->uuid, $permission->id])}}"
                                                        data-route-revoke="{{route('user_permissions_revoke', [$user->uuid, $permission->id])}}" value="1"/>
                                                  </td>
                                                  <td class="project-title">
                                                      <p>Nome:</p>
                                                      <a href="#">{{$permission->name}}</a>
                                                  </td>
                                                  <td class="project-title">
                                                      <p>Descrição:</p>
                                                      <a href="#">{{$permission->description}}</a>
                                                  </td>
                                              </tr>
                                              @endforeach
                                              </tbody>
                                          </table>
                                        @empty
                                            <div class="alert alert-warning">Nenhum registro encontrado.</div>
                                        @endforelse

                                      </div>

                                  @endif

                              @endforeach

                          </div>
                      </div>
                  </div>

                </div>
                <!-- tab pane contact end -->
                <div class="tab-pane" id="folders" role="tabpanel">

                  <div class="card">
                      <div class="card-header">
                          <h5 class="card-header-text">Editar Acessos às Pastas</h5>
                      </div>
                      <div class="card-block accordion-block">
                          <div class="accordion-box" id="single-open">
                            @foreach(\App\Helpers\Helper::folders()->sortBy('id') as $folder)

                              <a class="accordion-msg">
                                @if($folder->parent)
                                    @if($folder->parent->parent)
                                        @if($folder->parent->parent->parent)
                                            @if($folder->parent->parent->parent->parent)
                                                {{ $folder->parent->parent->parent->parent->name }} >
                                            @endif
                                            {{ $folder->parent->parent->parent->name }} >
                                        @endif
                                        {{ $folder->parent->parent->name }} >
                                    @endif
                                    {{ $folder->parent->name }} >
                                @endif

                              {{ $folder->name }}</a>
                              <div class="accordion-desc">

                                @php

                                    $permission = $folder->permissionsForUser->where('user_id', $user->id)->first();
                                    $read = $permission->read ?? false;
                                    $edit = $permission->edit ?? false;
                                    $share = $permission->share ?? false;
                                    $delete = $permission->delete ?? false;

                                @endphp

                                <div class="row align-items-center m-l-0">
                                    <div class="col-md-2">
                                        <h6 class="text-muted m-b-10">Visualizar</h6>
                                        <input {{ $read ? 'checked' : '' }} data-route="{{ route('folder_user_permission_change',[$folder->uuid, $user->uuid, 'read']) }}" type="checkbox" class="js-switch changeUserPermission" value="1"/>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted m-b-10">Editar</h6>
                                        <input {{ $edit ? 'checked' : '' }} data-route="{{ route('folder_user_permission_change',[$folder->uuid, $user->uuid, 'edit']) }}" type="checkbox" class="js-switch changeUserPermission" value="1"/>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted m-b-10">Compartilhar</h6>
                                        <input {{ $share ? 'checked' : '' }} data-route="{{ route('folder_user_permission_change',[$folder->uuid, $user->uuid, 'share']) }}" type="checkbox" class="js-switch changeUserPermission" value="1"/>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted m-b-10">Baixar</h6>
                                        <input {{ $share ? 'checked' : '' }} data-route="{{ route('folder_user_permission_change',[$folder->uuid, $user->uuid, 'download']) }}" type="checkbox" class="js-switch changeUserPermission" value="1"/>
                                    </div>
                                    <div class="col-md-2">
                                        <h6 class="text-muted m-b-10">Deletar</h6>
                                        <input {{ $delete ? 'checked' : '' }} data-route="{{ route('folder_user_permission_change',[$folder->uuid, $user->uuid, 'delete']) }}" type="checkbox" class="js-switch changeUserPermission" value="1"/>
                                    </div>
                                </div>

                              </div>
                            @endforeach
                          </div>
                      </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
</div>

@stop
