<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Provider') }}</title>
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
    <meta name="keywords" content="Provider">
    <meta name="author" content="Provider">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images\favicon.ico') }}" type="image/x-icon">
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

    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\fullcalendar\css\fullcalendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\fullcalendar\css\fullcalendar.print.css') }}" media='print'>

    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\pages\data-table\css\buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css') }}">

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\style.css') }}?v1.0.1">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\css\jquery.mCustomScrollbar.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\font-awesome\css\font-awesome.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

    <link href="{{ asset('adminty\components\switchery\css\switchery.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('adminty\pages\jquery.filer\css\jquery.filer.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('adminty\pages\jquery.filer\css\themes\jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">


    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\pages\list-scroll\list.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\stroll\css\stroll.css') }}">

    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\pages\advance-elements\css\bootstrap-datetimepicker.css') }}">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\bootstrap-daterangepicker\css\daterangepicker.css') }}">
    <!-- Date-Dropper css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('adminty\components\datedropper\css\datedropper.min.css') }}">

    <link href="{{ asset('adminty\components\bootstrap-tagsinput\css\bootstrap-tagsinput.css') }}" rel="stylesheet" />

    <link href="{{ asset('adminty\components\select2\css\select2-b.min.css') }}" rel="stylesheet" type="text/css" />

    <!--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">-->
    @yield('css')

    <style>
        input.parsley-success,
        select.parsley-success,
        textarea.parsley-success {
          color: #468847;
          background-color: #DFF0D8;
          border: 1px solid #D6E9C6;
        }

        input.parsley-error,
        select.parsley-error,
        textarea.parsley-error {
          color: #B94A48;
          background-color: #F2DEDE;
          border: 1px solid #EED3D7;
        }

        .parsley-errors-list {
          margin: 2px 0 3px;
          padding: 0;
          list-style-type: none;
          font-size: 0.9em;
          line-height: 0.9em;
          opacity: 0;
          color: #B94A48;

          transition: all .3s ease-in;
          -o-transition: all .3s ease-in;
          -moz-transition: all .3s ease-in;
          -webkit-transition: all .3s ease-in;
          }

        .parsley-errors-list.filled {
          opacity: 1;
        }

        .help-block, .parsley-errors-list {
          list-style: none;
          background-color: #009688;
          /*background-color: #fe5d70;*/
          /* border: 2px solid #dc3545; */
          color: white;
          padding: 10px 10px 10px 15px;
          border-radius: 10px;
          border-left: 12px solid #dc3545;
        }

        .pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
        z-index: 99999;
        }

        #map {
          height: 600px;
          width: 100%;
          background-color: grey;
        }

        .pcoded-main-container {
          /*background-image: url("{{ asset('images/natal.jpg') }}");*/
          /*background-image: radial-gradient( circle farthest-corner at 10% 20%,  rgba(0,95,104,1) 0%, rgba(15,156,168,1) 90% );
          background-size: cover;
          background-position: center center;
          background-attachment: fixed;*/
        }

        .page-header {
          position: relative;
          background-color: #fff;
          border: 1px solid rgba(0,0,0,.125);
          border-radius: .25rem;
          padding: 25px 20px;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-direction: column;
          flex-direction: column;
          min-width: 0;
          word-wrap: break-word;
          background-clip: border-box;
        }

    </style>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body>
<div class="theme-loader">
    <div class="ball-scale">
      <div class="loader loader-lg animation-start">
          <span class="circle delay-1 size-2"></span>
          <span class="circle delay-2 size-4"></span>
          <span class="circle delay-3 size-6"></span>
          <span class="circle delay-4 size-7"></span>
          <span class="circle delay-5 size-7"></span>
          <span class="circle delay-6 size-6"></span>
          <span class="circle delay-7 size-4"></span>
          <span class="circle delay-8 size-2"></span>
      </div>
    </div>
</div>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

        @include('partials.navbar')

        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                @include('partials.sidebar')
                <div class="pcoded-content">
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <div class="page-wrapper">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('adminty\components\jquery\js\jquery.min.js') }}"></script>
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>
<script src="{{ asset('js/app.js?v1.0.3') }}"></script>
<script src="{{ asset('adminty\js\parsley.js') }}"></script>

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
<script src="{{ asset('adminty\js\vartical-layout.min.js') }}?v1.2"></script>
<script src="{{ asset('adminty\js\jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Custom js -->
<script type="text/javascript" src="{{ asset('adminty\js\script.js?v1.0.5') }}"></script>

<script type="text/javascript" src="{{ asset('adminty\js\bootstrap-growl.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<!-- ck editor -->
<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
<script src="{{ asset('adminty\components\bootstrap-tagsinput\js\bootstrap-tagsinput.js') }}"></script>
<script src="{{ asset('adminty\components\switchery\js\switchery.min.js') }}"></script>
<script src="{{ asset('adminty\components/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="{{ asset('adminty\pages\jquery.filer\js\jquery.filer.js') }}"></script>
<script src="{{ asset('adminty\pages\filer\custom-filer.js?v1.0') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.1/dist/i18n/pt-br.js"></script>
<script type="text/javascript" src="{{ asset('adminty\pages\accordion\accordion.js') }}"></script>
<script src="{{ asset('adminty\components\countdown\js\jquery.countdown.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\moment\js\moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\components\fullcalendar\js\fullcalendar.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.3.0/locale/pt-br.js"></script>
<script src="{{ asset('adminty\components\stroll\js\stroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('adminty\pages\list-scroll\list-custom.js') }}"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="{{ asset('adminty\components\bootstrap-daterangepicker\js\daterangepicker.js') }}"></script>
<!-- Chart js -->
<script type="text/javascript" src="{{ asset('adminty\components\chart.js\js\Chart.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<input type="hidden" value="{{ route('user_localization') }}" id="user-localization"/>
<input type="hidden" value="{{ route('users_locales') }}" id="user-locales"/>
<input type="hidden" value="{{ route('client_search') }}" id="input-search-clientes"/>
<input type="hidden" value="{{ route('employee_search') }}" id="input-search-employees"/>
<input type="hidden" value="{{ route('addresses_search') }}" id="input-search-addresses"/>
<input type="hidden" value="{{ route('client_occupations_search') }}" id="input-search-client-occupations"/>

<script src="{{ asset('js/sip2.js') }}"></script>

<script>

function initMap() {

  var input = document.getElementById('pac-input');

  var options = {
      componentRestrictions: {
          country : "BR"
      }
  };

  var autocomplete = new google.maps.places.Autocomplete(input, options);

  autocomplete.setFields(
          ['address_components', 'geometry', 'icon', 'name']);

  var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    //country: 'long_name',
    postal_code: 'short_name',
    sublocality_level_1: 'long_name',
    administrative_area_level_2: 'long_name'
  };

  autocomplete.addListener('place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    var address = '';
    if (place.address_components) {

      $("#lat").val(place.geometry.location.lat());
      $("#lng").val(place.geometry.location.lng());

      $("#pac-container").parent().append("<p class='text-success'>O Endereço está correto!</p>");

      // Get each component of the address from the place details,
      // and then fill-in the corresponding field on the form.
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }

      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }
  });

  if(document.getElementById('map')) {
    var center = {lat: -20.3101037 , lng: -40.320972999999995};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 13,
      center: center
    });
    var marker = new google.maps.Marker({
        position: center,
        map: map
    });

    var url = $("#user-locales").val();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: url,
        dataType: 'json',
        success: function(data) {

          var locations = data;

          var infowindow =  new google.maps.InfoWindow({});
          var marker, count;
          for (count = 0; count < locations.length; count++) {

              marker = new google.maps.Marker({
                //position: center,
                position: new google.maps.LatLng(locations[count][1], locations[count][2]),
                map: map,
                title: locations[count][0]
              });
          google.maps.event.addListener(marker, 'click', (function (marker, count) {
                return function () {
                  infowindow.setContent(locations[count][0]);
                  infowindow.open(map, marker);
                }
              })(marker, count));
            }

        }
    });

  }

}

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
          align: 'center'
      },
      delay: 5000,
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

function notify2(text) {

  swal({
      title: "Atenção",
      text: text,
      type: "warning",
  });

}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4TbGLyQ0U1tNERt09Gl-sk41e_7Nmzuo&libraries=places&callback=initMap" async defer></script>

@yield('scripts')

@if (notify()->ready())
    <script>
      @if(notify()->option('modal') === true)

        swal({
            title: "{!! notify()->message() !!}",
            text: "{!! notify()->option('text') !!}",
            type: "{{ notify()->type() }}",
            @if (notify()->option('timer'))
                timer: {{ notify()->option('timer') }},
                showConfirmButton: false
            @endif
        });

      @else

        notify("{!! notify()->option('text') !!}", 'inverse');

      @endif
    </script>
@endif

<script>

$(document).ready(function() {

  var notificationsWrapper   = $('.notification-list');
  var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
  var notificationsCountElem = notificationsWrapper.find('.noti-icon-badge');
  var notificationsCount     = parseInt(notificationsCountElem.data('count'));
  var notifications          = notificationsWrapper.find('.slimscroll span');

  if (notificationsCount <= 0) {
    //notificationsWrapper.hide();
  }

  // Enable pusher logging - don't include this in production
  Pusher.logToConsole = false;

  var pusher = new Pusher('c9a5abf31bb9598d99c7', {
    encrypted: true,
    cluster: 'mt1',
  });

  // Subscribe to the channel we specified in our Laravel Event
  var channel = pusher.subscribe('notifications.'+{{ auth()->user()->id }});

  // Bind a function to a Event (the full Laravel class)
  channel.bind('App\\Events\\Notifications', function(data) {

    notifyMe('Notificação', data.message, '/admin/notifications');
    //console.log(data);
    var existingNotifications = notifications.html();
    var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
    var newNotificationHtml = `
      <li>
          <div class="media">
              <a href="#">
                <div class="media-body">
                    <p class="notification-msg">`+data.message+`</p>
                    <span class="notification-time">` +data.time+ `</span>
                </div>
              </a>
          </div>
      </li>

    `;
    notifications.html(newNotificationHtml + existingNotifications);

    var audio = new Audio("{{ asset('media/sounds/light.mp3') }}");
    audio.play();

    notificationsCount += 1;
    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsWrapper.find('.notif-count').text(notificationsCount);
    notificationsWrapper.show();

  });

});

</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EXB1H1CSNY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EXB1H1CSNY');
</script>
</body>

</html>
