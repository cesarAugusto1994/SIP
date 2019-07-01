@extends('auth.base')

@section('content')

<form class="md-float-material form-material" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="text-center">
        <img src="{{ asset('images\logo-provider.png') }}" style="width:20%" alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">
            <div class="form-group form-primary">
                <input type="text" name="email" class="form-control" required="" placeholder="E-mail">
                <span class="form-bar"></span>
            </div>
            <div class="form-group form-primary">
                <input type="password" name="password" class="form-control" required="" placeholder="Senha">
                <span class="form-bar"></span>
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
