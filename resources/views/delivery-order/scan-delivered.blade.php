@extends('auth.base')

@section('content')

<div class="page-body">
  <div class="card">
      <div class="card-header">
          <h5>Status Entrega</h5>
      </div>
      <div class="card-block">
          {{ $message }}
      </div>
  </div>

  <div class="card">
      <div class="card-header">
          <h5>Comprovante de Recebimento</h5>
      </div>
      <div class="card-block">

          @foreach ($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
          @endforeach

          <form class="formValidation" data-parsley-validate method="post" action="{{ route('delivery_receipt', $delivery->uuid) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label class="col-form-label">Envie uma foto do comprovante</label>
                    <div class="input-group">
                      <input name="document" class="form-control" required type="file" data-input="true" accept="image/*"/>
                    </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-success btn-sm btn-block">Salvar</button>

          </form>
      </div>
  </div>

</div>

@endsection

@section('scripts')

    <script>

    $(document).ready(function() {

      var $formValid = $('.formValidation').parsley();

      if($('.formValidation').length > 0) {

        $formValid.on('form:submit', function(e) {
          window.swal({
            title: 'Em progresso...',
            text: 'Aguarde enquanto os dados são salvos.',
            type: 'success',
            showConfirmButton: false,
            allowOutsideClick: false
          });
        });;

      }

    });

    </script>

@stop
