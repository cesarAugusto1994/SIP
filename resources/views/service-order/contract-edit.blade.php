@extends('base')

@section('content')

<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Ordem de Serviço</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('service-order.index') }}"> Ordem de Serviço </a>
                    </li>
                    <li class="breadcrumb-item"><a href="#!">Editar</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

  <form class="formValidation" data-parsley-validate method="post" action="{{route('service-order.update', $order->uuid)}}">
      @csrf
      {{ method_field('PUT') }}
  <div class="card">
      <div class="card-header">
          <h5>Editar Ordem de Serviço</h5>
      </div>
      <div class="card-block">

            <div class="row m-b-30">

                <div class="col-md-3">
                  <div class="form-group">
                      <label class="col-form-label">Editor</label>
                      <div class="input-group">
                        <textarea class="ckeditor" name="client"/>



                        </textarea>
                      </div>
                  </div>
                </div>

            </div>

      </div>

      <div class="card-block">

            <button class="btn btn-success btn-sm">Salvar</button>
            <a class="btn btn-danger btn-outline btn-sm" href="{{ route('services.index') }}">Cancelar</a>

      </div>

  </div>

</form>

</div>

@endsection

@section('scripts')

<script>

    var clickCheckbox = document.querySelector('#select-all');

    $(document).on('change','#select-all',function(){

      var itemsCheckbox = $('.select-item');

      if (clickCheckbox.checked) {

          $.each(itemsCheckbox, function(idx, elem) {

              if(!$(elem).is(':checked')) {
                  $(elem).trigger('click');
              }

          });

      } else {

          $.each(itemsCheckbox, function(idx, elem) {
            if($(elem).is(':checked')) {
                $(elem).trigger('click');
            }
          });

      }
    });

</script>

@endsection
