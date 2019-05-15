<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\bootstrap\css\bootstrap.min.css') }}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\icon\themify-icons\themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\icon\icofont\css\icofont.css') }}">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\icon\feather\css\feather.css') }}">
    <!-- Notification.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\pages\notification\notification.css') }}">
    <!-- Animate.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\animate.css\css\animate.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\jquery.mCustomScrollbar.css') }}">

</head>

<body>
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="ball-scale">
        <div class='contain'>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
            <div class="ring">
                <div class="frame"></div>
            </div>
        </div>
    </div>
</div>
<!-- Pre-loader end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        @include('partials.navbar')

        <!-- Sidebar chat start -->

        <!-- Sidebar inner chat start-->

        <!-- Sidebar inner chat end-->
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                @include('partials.sidebar')
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <!-- Main-body start -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                @yield('content')
                            </div>
                        </div>
                        <div id="styleSelector">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Warning Section Starts -->
<!-- Older IE warning message -->
<!--[if lt IE 10]>
<div class="ie-warning">
    <h1>Warning!!</h1>
    <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers
        to access this website.</p>
    <div class="iew-container">
        <ul class="iew-download">
            <li>
                <a href="http://www.google.com/chrome/">
                    <img src="../files/assets/images/browser/chrome.png" alt="Chrome">
                    <div>Chrome</div>
                </a>
            </li>
            <li>
                <a href="https://www.mozilla.org/en-US/firefox/new/">
                    <img src="../files/assets/images/browser/firefox.png" alt="Firefox">
                    <div>Firefox</div>
                </a>
            </li>
            <li>
                <a href="http://www.opera.com">
                    <img src="../files/assets/images/browser/opera.png" alt="Opera">
                    <div>Opera</div>
                </a>
            </li>
            <li>
                <a href="https://www.apple.com/safari/">
                    <img src="../files/assets/images/browser/safari.png" alt="Safari">
                    <div>Safari</div>
                </a>
            </li>
            <li>
                <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                    <img src="../files/assets/images/browser/ie.png" alt="">
                    <div>IE (9 & above)</div>
                </a>
            </li>
        </ul>
    </div>
    <p>Sorry for the inconvenience!</p>
</div>
<![endif]-->
<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('adminty\components\jquery\js\jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\jquery-ui\js\jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\popper.js\js\popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\bootstrap\js\bootstrap.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('adminty\components\jquery-slimscroll\js\jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('adminty\components\modernizr\js\modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\modernizr\js\css-scrollbars.js') }}"></script>

<!-- i18next.min.js -->
<script type="text/javascript" src="{{ asset('adminty\components\i18next\js\i18next.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\i18next-xhr-backend\js\i18nextXHRBackend.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\jquery-i18next\js\jquery-i18next.min.js') }}"></script>
<script src="{{ asset('adminty\js\pcoded.min.js') }}"></script>
<script src="{{ asset('adminty\js\vartical-layout.min.js') }}"></script>
<script src="{{ asset('adminty\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Custom js -->
<script type="text/javascript" src="{{ asset('adminty\js\script.js') }}"></script>

<script type="text/javascript" src="{{ asset('adminty\js\bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\pages\notification\notification.js') }}"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.20.6/sweetalert2.all.min.js"></script>


<script>

$(document).ready(function() {

    $(".btnRemoveItem").click(function(e) {
        var self = $(this);

        swal({
          title: 'Remover este item?',
          text: "Não será possível recuperá-lo!",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            e.preventDefault();

            $.ajax({
              headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
              url: self.data('route'),
              type: 'POST',
              dataType: 'json',
              data: {
                _method: 'DELETE'
              }
            }).done(function(data) {

              if(data.success) {

                self.parents('tr').hide();
                self.parents('.cardMessageTypes').hide();

                Swal.fire({
                  type: 'success',
                  title: 'Feito!',
                  text: data.message,
                })

              } else {

                Swal.fire({
                  type: 'error',
                  title: 'Oops...',
                  text: data.message,
                })

              }

            });
          }
        });
    });

    $('.btnLogout').click(function() {

        swal({
          title: 'Finalizar Sessão?',
          text: "Esta sessão será finalizada!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            document.getElementById('logout-form').submit();

            swal({
              title: 'Até logo!',
              text: 'Sua sessão será finalizada.',
              type: 'success',
              showConfirmButton: false,
            })
          }
        });

      });

      $(".btnRedirectSoc").click(function() {

          var loginSoc = $("#usu").val();
          var passwordSoc = $("#senha").val();
          var idSoc = $("#empsoc").val();

          if(usu && loginSoc && loginSoc) {
              $("#formularioLoginSoc").submit();
          } else {

            Swal.fire({
              type: 'error',
              title: 'Falha ao logar no SOC',
              text: 'Informe as suas credenciais SOC no seu perfil',
            })

          }
      });

});

</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
</body>

</html>
