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

    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\font-awesome\css\font-awesome.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <link href="{{ asset('adminty\components\bootstrap-tagsinput\css\bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('adminty\components\select2\css\select2-b.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('adminty\components\switchery\css\switchery.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

<!-- ck editor -->
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>

<script src="{{ asset('adminty\components\bootstrap-tagsinput\js\bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('adminty\components\select2\js\select2.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('adminty\components\switchery\js\switchery.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/pt-BR.js"></script>

<script src="{{ asset('adminty\components/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>

<script>

  // Mascara de CPF e CNPJ
  var CpfCnpjMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
      },
      cpfCnpjpOptions = {
        onKeyPress: function(val, e, field, options) {
          field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
        }
      };

  $(function() {
    $(':input[name=document]').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
    $('.inputDocument').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
  })

</script>

<script>

    function notify(message, type){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'bottom',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

</script>

@yield('scripts')

@if (notify()->ready())
    <script>
        notify("{!! notify()->option('text') !!}", 'inverse');
/*
        swal({
            title: "{!! notify()->message() !!}",
            text: "{!! notify()->option('text') !!}",
            type: "{{ notify()->type() }}",
            @if (notify()->option('timer'))
                timer: {{ notify()->option('timer') }},
                showConfirmButton: false
            @endif
        });*/

    </script>
@endif

<script>

$(document).ready(function() {

    $(":submit").click(function(e) {
        //e.preventDefault();
        //alert('qwe');

        window.swal({
          title: 'Em progresso',
          text: 'Aguarde enquantos os dados são salvos.',
          type: 'info',
          showConfirmButton: false,
          allowOutsideClick: false
        })

        $(this).hide();
    });

    $('.select2').select2({
			width: '100%'
		});

    $('.inputDate').mask('00/00/0000');
	  $('.inputCep').mask('00000-000');
		$('.inputPhone').mask('(00)00000-0000');
	  $('.inputCpf').mask('000.000.000-00', {reverse: true});
  	$('.inputCnpj').mask('00.000.000/0000-00', {reverse: true});
		$('.inputMoney').mask('000.000.000.000.000,00', {reverse: true});

    $('.inputDate').datepicker({
  	    format: "dd/mm/yyyy",
  	    todayBtn: "linked",
  	    clearBtn: true,
  	    language: "pt-BR",
  	    calendarWeeks: true,
  	    autoclose: true,
  	    todayHighlight: true,
  	    toggleActive: true
		});

    $(".inputCep").blur(function() {

          let route = $(this).data('cep');
          let value = $(this).val();

          if(value) {

            $.ajax({
              type: 'GET',
              async: true,
              url: route+'?search='+value,
              success: function(response) {

                  if(!response.success) {

                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: response.message,
                    })

                  }

                  let dataResponse = response.data['response'];
                  let dataResponseCoodenadas = response.data['coordenadas'];

                  $("#street").val(dataResponse.logradouro);
                  $("#district").val(dataResponse.bairro);
                  $("#city").val(dataResponse.localidade);
                  $("#state").val(dataResponse.uf);

                  $("#long").val(dataResponseCoodenadas.lng);
                  $("#lat").val(dataResponseCoodenadas.lat);

                  $('.ibox-loading').children('.ibox-content').removeClass('sk-loading');
              }
            })

          }

    });

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

                notify(data.message, 'inverse');

              } else {

                notify(data.message, 'danger');

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

    let checkboxPermissions = $(".checkboxPermissions");

    checkboxPermissions.change(function() {

      var _self = $(this);
      var isChecked = _self[0].checked;

      var route = _self.data('route-grant');

      if(isChecked !== true) {
        route = _self.data('route-revoke');
      }

      $.ajax({
        headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
        url: route,
        type: 'POST',
        dataType: 'json',
        data: {}
      }).done(function(data) {

        if(data.success) {

          const toast = swal.mixin({
            toast: true,
            position: 'top-center',
            showConfirmButton: false,
            timer: 3000
          });

          toast({
            type: 'success',
            title: data.message
          });

        } else {

          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: data.message,
          })

        }

      });

    });

    let selectClientAddress = $(".select-client-addresses");
    let selectAddress = $("#select-address");

    selectClientAddress.change(function() {

      let self = $(this);
      let route = self.data('search-addresses');
      let value = self.val();

      $.ajax({
        type: 'GET',
        url: route + '?param=' + value,
        async: true,
        success: function(response) {

          let html = "";
          selectAddress.html("");
          selectAddress.trigger('change');

          $.each(response.data, function(idx, item) {

              let address = item.description +', '+item.street+', '+item.number+' - '+item.district+', '+item.city+' - '+item.zip;

              html += "<option value="+ item.uuid +">"+ address +"</option>";

          });

          selectAddress.append(html);
          selectAddress.trigger('change');

        }
      })

    });

    let selectClientEmployees = $(".select-client-employees");
    let selectEmployee = $("#select-employee");

    selectClientEmployees.change(function() {

      let self = $(this);
      let route = self.data('search-employees');
      let value = self.val();

      $.ajax({
        type: 'GET',
        url: route + '?param=' + value,
        async: true,
        success: function(response) {

          let html = "";
          selectEmployee.html("<option value=''>Informe um funcionário</option>");
          //selectEmployee.trigger('change');

          $.each(response.data, function(idx, item) {
              let employee = item.name +' - '+item.email;
              html += "<option value="+ item.uuid +">"+ employee +"</option>";
          });

          selectEmployee.append(html);
          //selectEmployee.trigger('change');

        }
      })

    });

    let selectOccupations = $(".select-occupations");
    let occupation = $("#occupation");

    selectOccupations.change(function () {

      let self = $(this);
      let route = self.data('search-occupations');
      let value = self.val();

      $.ajax({
        type: 'GET',
        url: route + '?param=' + value,
        async: true,
        success: function(response) {

          let html = "";
          occupation.html("");
          occupation.selectpicker('refresh');

          $.each(response.data, function(idx, item) {

              html += "<option value="+ item.uuid +">"+ item.name +"</option>";

          });

          occupation.append(html);
          occupation.selectpicker('refresh');

        }
      })

    });

    let selectClientDocuments= $(".select-client-documents");
    let tableDocuments = $("#table-documents");

    selectClientDocuments.change(function() {

      let self = $(this);
      let route = self.data('search-documents');
      let value = self.val();

      tableDocuments.html("");

      $.ajax({
        type: 'GET',
        url: route + '?param=' + value,
        async: true,
        success: function(response) {

          let html = "";

          $.each(response.data, function(idx, item) {

              html += "<tr>";
              html += "<td><input type='checkbox' name='documents[]' value='"+ item.id +"'/></td>";
              html += "<td>"+ item.type +"</td>";
              html += "<td>"+ item.client +"</td>";
              html += "<td>"+ item.status +"</td>";
              html += "<td>"+ item.annotations +"</td>";
              html += "</tr>";

              tableDocuments.append(html);

          });



        }
      })

    });

    $("#select-department").change(function() {

      var self = $(this);
      var selectedDepartment = $("#select-department").select2("val");

      selectedDepartment = 'id='+ selectedDepartment;

      $("#select-user").html("");

      $.ajax({
          type: 'GET',
          url: $("#select-department").data('route'),
          dataType: 'html',
          data: selectedDepartment,
          }).done( function( data ) {
              data = JSON.parse(data);

              data = $.map(data.data, function(item) {
                if(item) {
                  return { id: item.id, text: item.name };
                }

              });

              $('#select-user').select2({
                    data: data,
              });
              $('#select-user').trigger('change');
           });
    });

    var notificationsWrapper   = $('.notification-list');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('.noti-icon-badge');
    var notificationsCount     = parseInt(notificationsCountElem.data('count'));
    var notifications          = notificationsWrapper.find('.slimscroll');

    if (notificationsCount <= 0) {
      //notificationsWrapper.hide();
    }

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('fbc40aa0ff741e4532da', {
      encrypted: true,
      cluster: 'mt1',
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('notifications');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\Notifications', function(data) {
      console.log(data);
      var existingNotifications = notifications.html();
      var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
      var newNotificationHtml = `
        <a href="javascript:void(0);" class="dropdown-item notify-item">
            <div class="notify-icon bg-success"><i class="mdi mdi-account-plus"></i></div>
            <p class="notify-details">`+data.message+`<small class="text-muted">`+data.time+`</small></p>
        </a>
      `;
      notifications.html(newNotificationHtml + existingNotifications);

      notificationsCount += 1;
      notificationsCountElem.attr('data-count', notificationsCount);
      notificationsWrapper.find('.notif-count').text(notificationsCount);
      notificationsWrapper.show();
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
