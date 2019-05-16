@extends('base')

@section('content')

    <div class="card">
        <div class="card-header">
            <h5>Novo Curso</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="feather icon-maximize full-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block">

          {!! form($form) !!}

        </div>
    </div>

 @stop
