@extends('auth.base')

@section('content')

<form class="md-float-material form-material" action="{{ route('post_lockscreen') }}" method="post">
    @csrf
    <div class="text-center m-b-30">
        <img src="{{ asset('images\logo-provider.png') }}" style="width:40%"  alt="SIP - Provider">
    </div>
    <div class="auth-box card">
        <div class="card-block">

            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="form-group form-primary">
                <input type="password" name="password" class="form-control" required="" placeholder="Informe sua Senha">
                <span class="form-bar"></span>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-md btn-block waves-effect text-center m-b-20"><i class="icofont icofont-lock"></i> Desbloquear </button>
                </div>
            </div>

        </div>
    </div>
</form>

@stop
