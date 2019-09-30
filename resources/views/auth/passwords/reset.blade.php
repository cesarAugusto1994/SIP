@extends('auth.base')

@section('content')

<form class="md-float-material form-material formValidation" action="{{ route('password.update') }}" method="POST">

    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="text-center m-b-30">
        <img src="{{ asset('images\logo-provider.png') }}" alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">

            <h5 class="text-center"><i class="feather icon-lock text-primary f-60 p-t-15 p-b-20 d-block"></i>Atualizar Senha</h5>

            <br/>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            @if (!request()->has('email'))
            <div class="form-group m-b-20">
                <div class="col-xs-12">
                    <input autofocus value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" id="email" required=""
                     placeholder="Para sua segurança Informe seu E-mail">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            @else
              <input style="display:none;" value="{{ request()->get('email') }}" name="email" type="email" id="email">
            @endif

            <div class="form-group m-b-20">
                <div class="col-xs-12">
                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password" id="password" required=""
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
                    <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" type="password" id="password_confirmation" required=""
                     placeholder="Confirme a Senha">
                    @if ($errors->has('password_confirmation'))
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
            <p class="text-inverse text-right">voltar ao <a href="{{ route('login') }}">Login</a></p>

        </div>
    </div>
</form>

@stop

@section('scripts')

<script>

  $(document).ready(function() {

      var $formValid = $('.formValidation').parsley();

      if($('.formValidation').length > 0) {

        $formValid.on('form:submit', function(e) {
          // This global callback will be called for any field that fails validation.
          //e.preventDefault();
          window.swal({
            title: 'Autenticando...',
            text: 'Aguarde enquanto as suas credenciais são verificadas.',
            type: 'success',
            showConfirmButton: false,
            allowOutsideClick: false
          });
        });;

      }

  });

</script>

@stop
