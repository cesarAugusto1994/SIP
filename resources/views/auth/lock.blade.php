@extends('auth.base')

@section('content')

<form class="md-float-material form-material" action="{{ route('post_lockscreen') }}" method="post">
    @csrf
    <div class="text-center">
        <img src="{{ asset('images\logo-provider.png') }}" style="width:20%" alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center"><i class="feather icon-lock text-primary f-60 p-t-15 p-b-20 d-block"></i> Desbloquear </h3>
                </div>
            </div>

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="form-group form-primary">
                <input type="password" name="password" class="form-control" required="" placeholder="Informe sua Senha">
                <span class="form-bar"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20"><i class="icofont icofont-lock"></i> Desbloquear </button>
                </div>
            </div>

        </div>
    </div>
</form>

@stop
