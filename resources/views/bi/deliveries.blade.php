@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Relatórios de Entregas</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Relatórios</a></li>
                    <li class="breadcrumb-item"><a href="#!">Entregas</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <div class="row">

      <div class="col-xl-12 col-md-12">

        <iframe width="100%" height="1000" src="https://datastudio.google.com/embed/reporting/1NuY8PPIWUBbgIUHqvtsXd78KHu_3STO7/page/j3c8" frameborder="0" style="border:0" allowfullscreen></iframe>

      </div>

  </div>

</div>

@endsection
