@extends('auth.base')

@section('content')

<form class="md-float-material form-material formValidation" action="{{ route('login') }}" method="POST">
    @csrf

    <div class="auth-box card" style="background-color:#F7F7F7">
        <div class="card-block">

            <div class="text-center m-b-30">
                <img src="{{ asset('images\logo.jpeg') }}" style="width:40%"  alt="SIP - Provider">
            </div>

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger background-danger text-center">{{ $error }}</div>
            @endforeach

            <div class="form-group form-primary">
                <input type="text" name="email" class="form-control" required="" placeholder="E-mail">
            </div>
            <div class="form-group form-primary">
                <input type="password" name="password" class="form-control" required="" placeholder="Senha">
            </div>
            <div class="row m-t-25 text-left">
                <div class="col-12">
                    <div class="checkbox-fade fade-in-primary d-">
                        <label>
                            <input type="checkbox" value="">
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span class="text-inverse">Lembrar-me</span>
                        </label>
                    </div>
                    <div class="forgot-phone text-right f-right">
                        <a href="{{ url('password/reset') }}" class="text-right f-w-600"> Esqueceu a Senha?</a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-md btn-block waves-effect waves-light text-center m-b-20">Entrar</button>
                </div>
            </div>

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
