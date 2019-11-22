$('.select2').select2({
  width: '100%',
  placeholder: "Selecione"
});

$('.select-client').select2({
  ajax: {
    type: "GET",
    dataType: 'json',
    delay: 250,
    url: $('#input-search-clientes').val(),
    data: function (params) {
      var query = {
        search: params.term,
        type: 'public'
      }

      return query;
    },
    processResults: function (data) {
        return {
            results: $.map(data, function (item) {
                return {
                    text: item.name,
                    id: item.id
                }
            })
        };
    }
  },
  cache: true,
  placeholder: 'Procurar cliente',
  minimumInputLength: 1,

});

function formatRepo(emp) {

    if(!emp.name) return '<span>Pesquisando...</span>';

    var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'></div>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + emp.name + "</div>";

    if (emp.company) {
        markup += "<div class='select2-result-repository__description'>" + emp.company + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" +
        "<div class='select2-result-repository__forks'>Documento " + emp.document + " </div>" +
        "</div>" +
        "</div></div>";

    return markup;
}

function formatRepoSelection(repo) {
    return repo.name || repo.company;
}

$('.select-employees').select2({
  placeholder: 'Procurar Funcionario',
  ajax: {
    type: "GET",
    dataType: 'json',
    delay: 250,
    url: $('#input-search-employees').val(),
    data: function (params) {
      var query = {
        search: params.term,
        type: 'public'
      }

      return query;
    },
    processResults: function (data, params) {

        return {

            results: $.map(data, function (item) {
                return {
                    text: item.name + ' - ' + item.company + ' - ' + item.document,
                    id: item.id
                }
            })
        };
    }
  },
  cache: true,
  placeholder: 'Procurar Funcionario',
  minimumInputLength: 3,
});

$('.select-client-occuparions').select2({
  ajax: {
    type: "GET",
    dataType: 'json',
    delay: 250,
    url: $('.select-client-occuparions').data('url'),
    data: function (params) {
      var query = {
        search: params.term,
        type: 'public'
      }

      return query;
    },
    processResults: function (data) {
        return {
            results: $.map(data, function (item) {
                return {
                    text: item.name,
                    id: item.id
                }
            })
        };
    }
  },
  cache: true,
  placeholder: 'Procurar um cliente',
  minimumInputLength: 1,

});

var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

elem.forEach(function(html) {
  var switchery = new Switchery(html, { color: '#93BE52', jackColor: '#fff', size: 'small' });
});

$('.inputDate').mask('00/00/0000');
$('.inputDateTime').mask('00/00/0000 00:00', {placeholder: "__/__/____ __:__"});
$('.inputCep').mask('00000-000');
$('.inputPhone').mask('(00)00000-0000');
$('.inputCpf').mask('000.000.000-00', {reverse: true});
$('.inputCnpj').mask('00.000.000/0000-00', {reverse: true});
$('.inputMoney').mask('000.000.000.000.000,00', {reverse: true});

$('.inputDate').datepicker({
    language: "pt-BR",
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    clearBtn: true,

    calendarWeeks: true,
    autoclose: true,
    todayHighlight: true,
    toggleActive: true
});

$(".inputCep").blur(function() {

      let route = $(this).data('cep');
      let value = $(this).val();

      if(value) {

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto a requisição é processada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

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

              if(dataResponseCoodenadas) {
                $("#long").val(dataResponseCoodenadas.lng);
                $("#lat").val(dataResponseCoodenadas.lat);
              }

              swal.close();
          },
          done: function() {
            swal.close();
          }
        })

      }

});

$(".btnRemoveItem").click(function(e) {
    var self = $(this);

    swal({
      title: 'Remover este registro?',
      text: "Não será possível recuperá-lo!",
      showCancelButton: true,
      confirmButtonColor: '#0ac282',
      cancelButtonColor: '#D46A6A',
      confirmButtonText: 'Sim, Remover',
      cancelButtonText: 'Não'
      }).then((result) => {
      if (result.value) {

        e.preventDefault();

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto a requisição é processada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

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

          swal.close();

          if(data.success) {

            self.parents('.list-phones').remove();
            self.parents('tr').remove();
            self.parents('.cardMessageTypes').remove();
            self.parents('.cardRemove').remove();
            self.parents('.mediaFile').remove();

            notify(data.message, 'inverse');

          } else {

            notify(data.message, 'danger');

          }

        });
      }
    });
});

$(".btnRemoveItemToBack").click(function(e) {
    var self = $(this);

    swal({
      title: 'Remover registro?',
      text: "Deseja remover este registro?",
      showCancelButton: true,
      confirmButtonColor: '#0ac282',
      cancelButtonColor: '#D46A6A',
      confirmButtonText: 'Sim, Deletar',
      cancelButtonText: 'Não'
      }).then((result) => {
      if (result.value) {

        e.preventDefault();

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto a requisição é processada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

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

          swal.close();

          if(data.success) {

            notify(data.message, 'inverse');

            window.location.href = data.route;

          } else {

            notify(data.message, 'danger');

          }



        });
      }
    });
});

$(".btnRemoveFolder").click(function(e) {
    var self = $(this);

    swal({
      title: 'Deseja remover esta Pasta?',
      text: "Não será possível recuperá-lo!",
      showCancelButton: true,
      confirmButtonColor: '#0ac282',
      cancelButtonColor: '#D46A6A',
      confirmButtonText: 'Sim, Deletar',
      cancelButtonText: 'Não'
      }).then((result) => {
      if (result.value) {

        e.preventDefault();

        window.swal({
          title: 'Em progresso...',
          text: 'Aguarde enquanto a requisição é processada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
        });

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

          swal.close();

          if(data.success) {

            notify(data.message, 'inverse');

            window.location.href = data.route;

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
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#0ac282',
      cancelButtonColor: '#D46A6A',
      confirmButtonText: 'Sim, Finalizar',
      cancelButtonText: 'Não'
      }).then((result) => {
      if (result.value) {

        document.getElementById('logout-form').submit();

        swal({
          title: 'Até logo!',
          text: 'Sua sessão será finalizada.',
          type: 'success',
          showConfirmButton: false,
          allowOutsideClick: false
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

let checkboxUserFolderPermission = $('.changeUserPermission');

checkboxUserFolderPermission.change(function() {

  var _self = $(this);
  var isChecked = _self[0].checked;

  var route = _self.data('route');

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
var selectAddress = $("#select-address");

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

          var description = item.description ? item.description : '';
          var street = item.street ? item.street : '';
          var number = item.number ? item.number : '';
          var district = item.district ? item.district : '';
          var city = item.city ? item.city : '';
          var zip = item.zip ? item.zip : '';

          let address = description +', '+street+', '+number+' - '+district+', '+city+' - '+zip;

          html += "<option value="+ item.uuid +">"+ address +"</option>";

      });

      selectAddress.append(html);
      selectAddress.trigger('change');

    }
  })

});

let selectClientEmployees = $(".select-client-employees");
let selectEmployee = $("#select-employee");

$(document).on('change','.select-client-employees',function(){

  let self = $(this);
  let route = self.data('search-employees');
  let selectEmployee = $(self.data('target'));

  let value = self.val();

  $.ajax({
    type: 'GET',
    url: route + '?param=' + value,
    async: true,
    success: function(response) {

      data = response.data;

      data = $.map(data, function(item) {
        if(item) {
          return { id: item.uuid, text: item.name };
        }

      });

      selectEmployee.html("");
      selectEmployee.trigger('change');

      selectEmployee.select2({
          data: data,
      });

    }
  })

});

let selectClientEmails = $(".select-client-emails");
let selectEmail = $("#select-email");

$(document).on('change','.select-client-emails',function(){

  let self = $(this);
  let route = self.data('search-emails');
  //let selectEmail = $(self.data('target'));

  let value = self.val();

  $.ajax({
    type: 'GET',
    url: route + '?param=' + value,
    async: true,
    success: function(response) {

      data = response.data;

      data = $.map(data, function(item) {
        if(item) {
          return { id: item.email, text: item.email };
        }

      });

      selectEmail.html("");
      selectEmail.trigger('change');
      selectEmail.select2({
          data: data,
      });

    }
  })

});

let selectOccupations = $(".select-occupations");
let occupation = $("#occupation");

selectOccupations.change(function () {

  swal({
    title: 'Aguarde um instante.',
    text: 'Carregando os dados...',
    type: 'info',
    showConfirmButton: false,
    allowOutsideClick: false
  });

  let self = $(this);
  let route = self.data('search-occupations');
  let value = self.val();

  $.ajax({
    type: 'GET',
    url: route + '?param=' + value,
    async: true,
    success: function(response) {

      let html = "<option value=''>Selecione um cargo</option>";
      occupation.html("");
      //occupation.selectpicker('refresh');

      $.each(response.data, function(idx, item) {

          html += "<option value="+ item.uuid +">"+ item.name +"</option>";

      });

      occupation.append(html);
      //occupation.selectpicker('refresh');

      swal.close();

    }
  })

});

let selectClientDocuments= $(".select-client-documents");
let tableDocuments = $("#table-documents");

selectClientDocuments.change(function() {

  let self = $(this);
  let route = self.data('search-documents');
  let value = self.val();

  swal({
    title: 'Carregando',
    text: 'Procurando documentos do Cliente.',
    type: 'success',
    showConfirmButton: false,
    allowOutsideClick: false
  })

  $.ajax({
    type: 'GET',
    url: route + '?param=' + value,
    async: true,
    success: function(response) {

      tableDocuments.html("");

      swal.close();

      let html = "";

      $.each(response.data, function(idx, item) {

          html += "<tr>";
          html += "<td><input class='js-switch2 select-item' type='checkbox' name='documents[]' value='"+ item.uuid +"'/></td>";
          html += "<td>"+ item.id +"</td>";
          html += "<td>"+ item.type +"</td>";
          html += "<td>"+ item.employee +"</td>";
          html += "<td>"+ item.reference +"</td>";
          html += "<td>"+ item.status +"</td>";
          html += "</tr>";

      });

      tableDocuments.append(html);

      var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch2'));

      elem.forEach(function(html) {
        var switchery = new Switchery(html, { color: '#93BE52', jackColor: '#fff' });
      });
      if($("#select-all").is(':checked')) {
        $("#select-all").trigger('click');
      }
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

$('#daterange').daterangepicker({
    "showDropdowns": true,
    "autoApply": true,
    ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês Anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Applicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "De",
        "toLabel": "Até",
        "customRangeLabel": "Editar",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Seg",
            "Ter",
            "Qua",
            "Qui",
            "Sex",
            "Sab"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
    //"startDate": "08/29/2019",
    //"endDate": "09/04/2019"
  }, function(start, end, label) {
    $("#start").val(start.format('DD/MM/YYYY'));
    $("#end").val(end.format('DD/MM/YYYY'));
    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
  });

  var $formValid = $('.formValidation').parsley();

  if($formValid) {

    $formValid.on('form:submit', function(e) {
      // This global callback will be called for any field that fails validation.
      //e.preventDefault();
      window.swal({
        title: 'Em progresso...',
        text: 'Aguarde enquanto os dados são salvos.',
        type: 'success',
        showConfirmButton: false,
        allowOutsideClick: false
      });
    });;

  }

  function ignoreTour(url) {

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: url,
          dataType: 'json',
      })

  }

  function initMap() {

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        var url = $("#user-localization").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: pos,
            dataType: 'json',
        });

        //console.log(pos);

      }, function() {

      });
    } else {
      // Browser doesn't support Geolocation

    }

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

  let $calendar = $('#calendar');

  $calendar.fullCalendar({
      height: 380,
      contentHeight: 590,
      views: {
        listDay: {
          buttonText: 'list day',
          titleFormat: "dddd, DD MMMM YYYY",
          columnFormat: "",
          timeFormat: "HH:mm"
        },

        listWeek: {
          buttonText: 'list week',
          columnFormat: "ddd D",
          timeFormat: "HH:mm"
        },

        listMonth: {
          buttonText: 'list month',
          titleFormat: "MMMM YYYY",
          timeFormat: "HH:mm"
        },

        month: {
          buttonText: 'month',
          titleFormat: 'MMMM YYYY',
          columnFormat: "ddd",
          timeFormat: "HH:mm"
        },

        agendaWeek: {
          buttonText: 'agendaWeek',
          columnFormat: "ddd D",
          timeFormat: "HH:mm"
        },

        agendaDay: {
          buttonText: 'agendaDay',
          titleFormat: 'dddd, DD MMMM YYYY',
          columnFormat: "",
          timeFormat: "HH:mm"
        },
      },
      lang: 'pt-br',
      defaultView: 'month',
      eventBorderColor: "#de1f1f",
      eventColor: "#AC1E23",
      slotLabelFormat: 'HH:mm',
      eventLimitText: 'Compromissos',
      borderColor: '#FC6180',
      backgroundColor: '#FC6180',
      droppable: true,
      businessHours: true,
      editable: true,
      allDaySlot: true,
      eventLimit: false,
      minTime: '06:00:00',
      maxTime: '22:00:00',
      header: {
          left: 'prev,next,today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listMonth,listWeek,listDay'
      },
      navLinks: true,
      selectable: true,
      selectHelper: true,
      select: function(start, end, jsEvent, view) {
          var view = $('.calendar').fullCalendar('getView');
          $("#sechedule-modal").modal('show');
          $("#start").val(start.format('DD/MM/YYYY HH:mm'));
          $("#end").val(end.format('DD/MM/YYYY HH:mm'));
      },
      eventClick: function(event, element, view) {

          window.swal({
            title: 'Em progresso...',
            text: 'Aguarde enquanto carregamos o compromisso.',
            type: 'success',
            showConfirmButton: false,
            allowOutsideClick: false
          });

          window.location.href = event.route;
      },

      dayClick: function(date, jsEvent, view) {

          jsEvent.preventDefault();

          setTimeout(function() {

              $("#formConsultaModal").prop('action', $("#consultas-store").val());

          }, 100);

      },
      events: $("#schedule-json").val(),
      //color: 'black', // an option!
      //textColor: 'yellow', // an option!
      //When u drop an event in the calendar do the following:
      eventDrop: function(event, delta, revertFunc) {
          //console.log(event);
          popularModal(event);
      },
      //When u resize an event in the calendar do the following:
      eventResize: function(event, delta, revertFunc) {
          //console.log(event);
          popularModal(event);
      },
      eventRender: function(event, element) {
          $(element).tooltip({
              title: event.title
          });
      },
      ignoreTimezone: false,
      allDayText: 'Dia Inteiro',
      monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
      axisFormat: 'HH:mm',
      buttonText: {
          prev: "<",
          next: ">",
          prevYear: "Ano anterior",
          nextYear: "Proximo ano",
          today: "Hoje",
          month: "Mês",
          week: "Semana",
          day: "Dia",
          listMonth: "Lista Mensal",
          listWeek: "Lista Semanal",
          listDay: "Lista Diária"
      }

  });

  function popularModal(event) {

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: event.update,
          data: {
            id: event.id,
            uuid: event.uuid,
            title: event.title,
            description: event.description,
            start: event.start.format('DD/MM/YYYY HH:mm'),
            end: event.end.format('DD/MM/YYYY HH:mm'),
            _method: 'PUT',
          },
          dataType: 'json',
          success: function(data) {
              //console.log(data);
              //openSwalScreenProgress();
          },
          error: function(data) {
              //alert(data.message);
              //openSwalMessage('Erro ao Processar Requisição', data.message);
          }
      })


  }
