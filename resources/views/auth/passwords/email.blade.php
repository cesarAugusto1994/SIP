@extends('auth.base')

@section('content')

<form class="md-float-material form-material formValidation" action="{{ route('password.email') }}" method="POST">

    @csrf

    <div class="text-center m-b-30">
        <img src="{{ asset('images\logo-provider.png') }}" alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">

            <h5 class="text-center"><i class="feather icon-lock text-primary f-60 p-t-15 p-b-20 d-block"></i>Recuperar Senha</h5>

            <br/>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="form-group form-primary">
                <input type="text" autofocus name="email" class="form-control" required="" placeholder="Informe o seu e-mail">
                <span class="form-bar"></span>
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
            title: 'Enviando...',
            text: 'Aguarde enquanto enviamos a sua solicitação.',
            type: 'success',
            showConfirmButton: false,
            allowOutsideClick: false
          });
        });;

      }

  });

</script>

@stop
