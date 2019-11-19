@extends('base')

@section('content')

<!-- Page-header start -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Bem Vindo ao SIP</h4>
                    <span>Sistema Integrado Provider</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">

        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">

      <div class="col-xl-6 col-md-12">

          @asyncWidget('\App\Widgets\Profile', [])

      </div>

      <div class="col-xl-6 col-md-12">

          @asyncWidget('\App\Widgets\Dashboard', [])

      </div>

        <div class="col-xl-8 col-md-12 col-sm-12">
            @asyncWidget('\App\Widgets\MessageBoard', [])
        </div>

        <div class="col-xl-4 col-md-12">

          @asyncWidget('\App\Widgets\NextSchedules', [])

        </div>

    </div>
</div>

@stop
