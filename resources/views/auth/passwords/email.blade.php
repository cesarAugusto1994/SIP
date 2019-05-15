@extends('auth.base')

@section('content')

<form class="md-float-material form-material" action="{{ route('password.email') }}" method="POST">

    @csrf

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center">
        <img src="{{ asset('images\logo-provider.png') }}" style="width:20%" alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center"><i class="feather icon-lock text-primary f-60 p-t-15 p-b-20 d-block"></i>Recuperar Senha</h3>
                </div>
            </div>
            <div class="form-group form-primary">
                <input type="text" name="email" class="form-control" required="" placeholder="Informe o seu e-mail">
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
