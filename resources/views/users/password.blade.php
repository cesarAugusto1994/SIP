@extends('base')

@section('content')


<div class="row">

  <div class="col-md-4">

  </div>

  <div class="col-md-4">

      <form data-parsley-validate class="md-float-material form-material" action="{{ route('update_password') }}" method="POST">

          @csrf

          <div class="text-center m-b-30">

          </div>
          <div class="auth-box card">
              <div class="card-block">

                  <h5 class="text-center"><i class="feather icon-lock text-primary f-60 p-t-15 p-b-20 d-block"></i>Atualizar Senha</h5>

                  <br/>

                  @if(auth()->user()->isAdmin() && request()->has('user'))
                      <input value="{{ request()->get('user') }}" name="user" type="hidden">
                  @else
                      <input value="{{ auth()->user()->uuid }}" name="user" type="hidden">
                  @endif

                  <div class="form-group m-b-20">
                      <div class="col-xs-12">
                          <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" data-parsley-minlength="6" data-parsley-maxlength="12" type="password" id="password" required=""
                           placeholder="Informe uma Senha">
                          @if ($errors->has('password'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group m-b-20">
                      <div class="col-xs-12">
                          <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" type="password" id="password_confirmation" required=""
                           placeholder="Confirme a Senha">
                          @if ($errors->has('password'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <button type="submit" class="btn btn-success btn-md btn-block waves-effect text-center m-b-20"> Enviar </button>
                      </div>
                  </div>

              </div>
          </div>
      </form>

  </div>

  <div class="col-md-4">

  </div>

</div>
@stop
