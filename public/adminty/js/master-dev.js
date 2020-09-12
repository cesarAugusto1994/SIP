function gd(year, month, day) {
    return new Date(year, month, day).getTime();
}

function openSwalPageLoader() {
    window.swal({
        title: "Processando",
        text: "Por favor aguarde...",
        imageUrl: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif",
        showConfirmButton: false,
        allowOutsideClick: false
    });
}

function openSwalScreen() {
    window.swal({
        title: "Salvando Dados",
        text: "Por favor aguarde...",
        imageUrl: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif",
        showConfirmButton: false,
        allowOutsideClick: false
    });
}

function openSwalScreen2() {

    window.swal({
        title: 'Pronto',
        text: 'Os dados foram adicionados',
        showConfirmButton: false,
        timer: 1000
    });

}

function openSwalScreenProgress() {

    window.swal({
        title: 'Pronto',
        text: 'Os dados foram alterados!',
        showConfirmButton: false,
        timer: 10000
    });

    window.location.reload();
}

function openSwalScreenProgressEditable(title, message) {

    window.swal({
        title: title,
        text: message,
        imageUrl: "https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif",
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 10000
    });
}


function openSwalMessage(titulo, mensagem) {
    swal({
        title: titulo,
        text: mensagem,
        showConfirmButton: true
    });
}

function openSwalMessageCard(titulo) {

    const toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    toast({
      type: 'success',
      title: titulo
    })

}

function openSwalPageLoaded() {
    swal({
        title: "Pagina carregada",
        showConfirmButton: false,
        timer: 1000
    });
}

function ignoreTour(url) {

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        dataType: 'json',
        async: true,
        cache: true,
    })

}

function carregarMedidasPaciente() {

  if (document.getElementById('consulta-paciente-medidas')) {

    $.ajax({
      type: 'GET',
      url: $("#consulta-paciente-medidas").val(),
      async: true,
      cache: true,
      success: function(data) {


                  var data = JSON.parse(data);

                  var result = [];

                  $.each(data, function(i, itens) {

                      result = [];

                      $.each(itens['content'], function(i, item) {
                          var date = new Date(item.Y, item.m, item.d).getTime();
                          result.push([date, item.medida]);
                      });

                      var data1 = result;

                      var barOptions = {
                          series: {
                               /*bars: {
                                   show: true
                               },*/
                              lines: {
                                  show: true,
                                  lineWidth: 2,
                                  fill: true,
                                  fillColor: {
                                      colors: [{
                                          opacity: 0.0
                                      }, {
                                          opacity: 0.0
                                      }]
                                  }
                              }
                          },
                          yaxis: {
                              color: "black",
                              tickDecimals: 2,
                              axisLabel: "Medidas",
                              axisLabelUseCanvas: true,
                              axisLabelFontSizePixels: 12,
                              axisLabelFontFamily: 'Verdana, Arial',
                              axisLabelPadding: 5
                          },
                          xaxis: {
                              mode: "time",
                              timeformat: "%d/%m",
                              min: gd(itens['header']['inicio']['Y'], itens['header']['inicio']['m'], itens['header']['inicio']['d']),
                              max: gd(itens['header']['fim']['Y'], itens['header']['fim']['m'], itens['header']['fim']['d'])
                          },
                          legend: {
                              noColumns: 0,
                              labelFormatter: function(label, series) {
                                  return "<font color=\"white\">" + label + "</font>";
                              },
                              backgroundColor: "#000",
                              backgroundOpacity: 0.9,
                              labelBoxBorderColor: "#000000",
                              position: "nw"
                          },
                          colors: ["#1ab394"],
                          grid: {
                              color: "#999999",
                              hoverable: true,
                              clickable: true,
                              tickColor: "#D4D4D4",
                              borderWidth: 0,
                              mouseActiveRadius: 50
                          },
                          legend: {
                              show: true
                          },
                          tooltip: true,
                          tooltipOpts: {
                              content: "Data: %x, Qtde: %y"
                          }
                      };
                      var barData = {
                          data: data1
                      };

                      Morris.Line({
                          element: 'morris-one-line-chart-' + itens['header']['entidade'],
                          data: (itens['content']),
                          xkey: 'data',
                          ykeys: ['medida'],
                          resize: true,
                          lineWidth:6,
                          labels: ['Medida'],
                          lineColors: ['#1ab394', '#54cdb4'],
                          pointSize:5,
                          hideHover: 'auto'
                      });

                  });

      }
    })

  }

}

function send(self) {
    var name = self.attr('name');
    var value = self.val();
    var _token = $('input[name="_token"]').val();
    var user = $('input[name="user"]').val();
    var url = self.data('url');

    if (!url) {
        console.error('A tag url é inválida ou inexistente.');
        return false;
    }

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000
    };

    var id = self.data('id') ? self.data('id') : 0;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: {
            id: id,
            name: name,
            value: value,
            _token: _token
        },
        async: true,
        dataType: 'json',
        success: function(data) {
            if (data.code == 500) {
                toastr.error('Erro ao Processar Requisição', data.message);
                self.parents('.input-group').addClass(' has-error');
                self.parents('.input-group').append('<span class="help-block m-b-none">' + data.message + '</span>');
            }
        },
        error: function(data) {
            toastr.error('Erro ao Processar Requisição', data.message);
        }
    })
}

function sendStaticRoute(self) {
    var name = self.attr('name');
    var value = self.val();
    var _token = $('input[name="_token"]').val();
    var user = $('input[name="user"]').val();
    var url = $('#paciente-route').val();

    if (!url) {
        console.error('A tag url é inválida ou inexistente.');
        return false;
    }

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000
    };

    var id = self.data('id') ? self.data('id') : 0;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        data: {
            id: id,
            name: name,
            value: value,
            _token: _token
        },
        dataType: 'json',
        success: function(data) {
            if (data.code == 500) {
                toastr.error('Erro ao Processar Requisição', data.message);
                self.parents('.input-group').addClass(' has-error');
                self.parents('.input-group').append('<span class="help-block m-b-none">' + data.message + '</span>');
            }
        },
        error: function(data) {
            toastr.error('Erro ao Processar Requisição', data.message);
        }
    })
}
/*
function sendForm(self, event) {

    event.preventDefault();

    openSwalScreen();

    if (!self.prop('action')) {
        console.error('O endereço para o envio dos dados está incorreto ou não foi informado.');
        return false;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: self.prop('action'),
        data: self.serialize(),
        dataType: 'json',
        async: true,
        success: function(data) {
          if(data.code == 501) {
            openSwalMessage('Erro ao Processar Requisição', data.message);
          } else {
            openSwalScreenProgress();
          }
        },
        error: function(data) {
            openSwalMessage('Erro ao Processar Requisição', data.message);
        }
    });

}
*/
function sendPostInUrl(self) {

    openSwalScreen();

    var url = self.data('url');

    if (!url) {
        console.error('A tag url é inválida ou inexistente.');
        return false;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: url,
        dataType: 'json',
        async: true,
        success: function(data) {
            openSwalScreenProgress();
        },
        error: function(data) {
            openSwalMessage('Erro ao Processar Requisição', data.message);
        }
    })

}

// Minimalize menu
$('.navbar-minimalize').click(function() {
    localStorage.setItem('mini-navbar', !$('.mini-navbar').is(":visible"));
});

var miniNavbar = localStorage.getItem('mini-navbar');

if (miniNavbar == 'true') {
    $("body").toggleClass("mini-navbar");
    SmoothlyMenu();
}

localStorageSupport = true;

// Enable/disable fixed top navbar
$('#fixednavbar').click(function() {
    if ($('#fixednavbar').is(':checked')) {
        $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
        $("body").removeClass('boxed-layout');
        $("body").addClass('fixed-nav');
        $('#boxedlayout').prop('checked', false);

        if (localStorageSupport) {
            localStorage.setItem("boxedlayout", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar", 'on');
        }
    } else {
        $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
        $("body").removeClass('fixed-nav');
        $("body").removeClass('fixed-nav-basic');
        $('#fixednavbar2').prop('checked', false);

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar2", 'off');
        }
    }
});

// Enable/disable fixed top navbar
$('#fixednavbar2').click(function() {
    if ($('#fixednavbar2').is(':checked')) {
        $(".navbar-static-top").removeClass('navbar-static-top').addClass('navbar-fixed-top');
        $("body").removeClass('boxed-layout');
        $("body").addClass('fixed-nav').addClass('fixed-nav-basic');
        $('#boxedlayout').prop('checked', false);

        if (localStorageSupport) {
            localStorage.setItem("boxedlayout", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar2", 'on');
        }
    } else {
        $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
        $("body").removeClass('fixed-nav').removeClass('fixed-nav-basic');
        $('#fixednavbar').prop('checked', false);

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar2", 'off');
        }
        if (localStorageSupport) {
            localStorage.setItem("fixednavbar", 'off');
        }
    }
});

// Enable/disable fixed sidebar
$('#fixedsidebar').click(function() {
    if ($('#fixedsidebar').is(':checked')) {
        $("body").addClass('fixed-sidebar');
        $('.sidebar-collapse').slimScroll({
            height: '100%',
            railOpacity: 0.9
        });

        if (localStorageSupport) {
            localStorage.setItem("fixedsidebar", 'on');
        }
    } else {
        $('.sidebar-collapse').slimscroll({
            destroy: true
        });
        $('.sidebar-collapse').attr('style', '');
        $("body").removeClass('fixed-sidebar');

        if (localStorageSupport) {
            localStorage.setItem("fixedsidebar", 'off');
        }
    }
});

// Enable/disable collapse menu
$('#collapsemenu').click(function() {
    if ($('#collapsemenu').is(':checked')) {
        $("body").addClass('mini-navbar');
        SmoothlyMenu();

        if (localStorageSupport) {
            localStorage.setItem("collapse_menu", 'on');
        }

    } else {
        $("body").removeClass('mini-navbar');
        SmoothlyMenu();

        if (localStorageSupport) {
            localStorage.setItem("collapse_menu", 'off');
        }
    }
});

// Enable/disable boxed layout
$('#boxedlayout').click(function() {
    if ($('#boxedlayout').is(':checked')) {
        $("body").addClass('boxed-layout');
        $('#fixednavbar').prop('checked', false);
        $('#fixednavbar2').prop('checked', false);
        $(".navbar-fixed-top").removeClass('navbar-fixed-top').addClass('navbar-static-top');
        $("body").removeClass('fixed-nav');
        $("body").removeClass('fixed-nav-basic');
        $(".footer").removeClass('fixed');
        $('#fixedfooter').prop('checked', false);

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixednavbar2", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixedfooter", 'off');
        }


        if (localStorageSupport) {
            localStorage.setItem("boxedlayout", 'on');
        }
    } else {
        $("body").removeClass('boxed-layout');

        if (localStorageSupport) {
            localStorage.setItem("boxedlayout", 'off');
        }
    }
});

// Enable/disable fixed footer
$('#fixedfooter').click(function() {
    if ($('#fixedfooter').is(':checked')) {
        $('#boxedlayout').prop('checked', false);
        $("body").removeClass('boxed-layout');
        $(".footer").addClass('fixed');

        if (localStorageSupport) {
            localStorage.setItem("boxedlayout", 'off');
        }

        if (localStorageSupport) {
            localStorage.setItem("fixedfooter", 'on');
        }
    } else {
        $(".footer").removeClass('fixed');

        if (localStorageSupport) {
            localStorage.setItem("fixedfooter", 'off');
        }
    }
});

// SKIN Select
$('.spin-icon').click(function() {
    $(".theme-config-box").toggleClass("show");
});

// Default skin
$('.s-skin-0').click(function() {
    $("body").removeClass("skin-1");
    $("body").removeClass("skin-2");
    $("body").removeClass("skin-3");
});

// Blue skin
$('.s-skin-1').click(function() {
    $("body").removeClass("skin-2");
    $("body").removeClass("skin-3");
    $("body").addClass("skin-1");
});

// Inspinia ultra skin
$('.s-skin-2').click(function() {
    $("body").removeClass("skin-1");
    $("body").removeClass("skin-3");
    $("body").addClass("skin-2");
});

// Yellow skin
$('.s-skin-3').click(function() {
    $("body").removeClass("skin-1");
    $("body").removeClass("skin-2");
    $("body").addClass("skin-3");
});

if (localStorageSupport) {
    var collapse = localStorage.getItem("collapse_menu");
    var fixedsidebar = localStorage.getItem("fixedsidebar");
    var fixednavbar = localStorage.getItem("fixednavbar");
    var fixednavbar2 = localStorage.getItem("fixednavbar2");
    var boxedlayout = localStorage.getItem("boxedlayout");
    var fixedfooter = localStorage.getItem("fixedfooter");

    if (collapse == 'on') {
        $('#collapsemenu').prop('checked', 'checked')
    }
    if (fixedsidebar == 'on') {
        $('#fixedsidebar').prop('checked', 'checked')
    }
    if (fixednavbar == 'on') {
        $('#fixednavbar').prop('checked', 'checked')
    }
    if (fixednavbar2 == 'on') {
        $('#fixednavbar2').prop('checked', 'checked')
    }
    if (boxedlayout == 'on') {
        $('#boxedlayout').prop('checked', 'checked')
    }
    if (fixedfooter == 'on') {
        $('#fixedfooter').prop('checked', 'checked')
    }
}

$(".checkEmail").change(function(e) {

    var self = $(this);
    var url = self.data('link');
    var email = self.val();

    if(email) {

          self.parents(".input-group").removeClass('has-error');
          $("#email-help-block").hide();

          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "GET",
              url: url,
              data: {
                  email: email,
              },
              dataType: 'json',
              async: true,
              cache: true,
              success: function(data) {
                  if (data.code == 500) {
                      //toastr.error('Erro ao Processar Requisição', data.message);
                      //self.parents('.input-group').addClass(' has-error');
                      //$("#email-help-block").html(data.message);
                      //$("#email-help-block").show();
                  } else {
                      self.parents(".input-group").removeClass('has-error').find('.help-block').remove();
                      $("#email-help-block").hide();
                  }
              },
              error: function(data) {
                  //toastr.error('Erro ao Processar Requisição', data.message);
              }
          })

    }


});

$(document).ready(function() {

    $(".checkZip").mask('00000-000');

    $('.btnCancelarConsulta').click(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = self.data('url');

        swal({
            title: 'Deseja prosseguir?',
            text: "Quer cancelar esta consuta?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            var route = url;

            if (result.value) {

                openSwalScreen();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route,
                    data: [],
                    dataType: 'json',
                    async: true,
                    success: function(data) {
                        openSwalScreenProgress();
                    },
                    error: function(data) {
                        openSwalMessage('Erro ao Processar Requisição', data.message);
                    }
                })

            }

        })
    });

    $('.btnFinalizarConsulta').click(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = self.data('url');

        swal({
            title: 'Deseja prosseguir?',
            text: "Quer finalizar esta consuta?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            var route = url;

            if (result.value) {

                openSwalScreen();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route,
                    data: [],
                    dataType: 'json',
                    async: true,
                    success: function(data) {
                        openSwalScreenProgress();
                    },
                    error: function(data) {
                        openSwalMessage('Erro ao Processar Requisição', data.message);
                    },
                })

            }

        })
    });

    let $calendar = $('.calendar');

    $calendar.fullCalendar({
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
        eventLimitText: 'consultas',
        minTime: '06:00:00',
        maxTime: '22:00:00',
        header: {
            left: 'prev,next,today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listMonth,listWeek'
        },

        navLinks: true,
        selectable: true,
        selectHelper: true,
        select: function(start, end, jsEvent, view) {

            var view = $('.calendar').fullCalendar('getView');

            if (view.name == 'agendaDay' || view.name == 'agendaWeek') {

                limparModal();

                $("#cadastra-consulta-modal").modal('show');
                $("#consulta-inicio").val(start.format('DD/MM/YYYY HH:mm'));
                $("#consulta-fim").val(end.format('DD/MM/YYYY HH:mm'));

            }

        },
        eventClick: function(event, element, view) {
            popularModalAndShow(event);
        },
        editable: true,
        allDaySlot: false,
        eventLimit: true,
        dayClick: function(date, jsEvent, view) {

            jsEvent.preventDefault();

            setTimeout(function() {

                limparModal();

                $("#formConsultaModal").prop('action', $("#consultas-store").val());

                /*if (view.name == 'month') {
                    $('.calendar').fullCalendar('gotoDate', date);
                    $('.calendar').fullCalendar('changeView', 'agendaDay');
                }*/

            }, 100);

        },
        events: $("#consultas-json").val(),
        color: 'black', // an option!
        textColor: 'yellow', // an option!
        //When u drop an event in the calendar do the following:
        eventDrop: function(event, delta, revertFunc) {
            popularModal(event);
        },
        //When u resize an event in the calendar do the following:
        eventResize: function(event, delta, revertFunc) {
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

    $('#cadastra-consulta-modal').on('hidden.bs.modal', function() {
        var form = $("#formConsultaModal").prop('action', $("#consultas-store").val());
        limparModal();
        $("#btnConsulta").text("Marcar consulta");
    });

    $('.btnOpenModalReagendarConsulta').click(function() {

        var self = $(this);

        $("#formConsultaModal").prop('action', '/consults/' + self.data('id') + '/update');

        $("#cadastra-consulta-modal").modal('show');

        $("#consulta-inicio").val(self.data('inicio'));
        $("#consulta-fim").val(self.data('fim'));

        $('#consulta-status option')
            .removeAttr('selected')
            .filter('[value="' + self.data('status') + '"]')
            .attr('selected', true)

        $('#consulta-paciente').selectpicker('val', self.data('paciente'));

        $("#consulta-notas").val(self.data('notas'));

        $("#btnConsulta").text('Reagendar Consulta');

    });

    $("#formConsultaModal").submit(function(e) {

        var self = $(this);

        e.preventDefault();

        var inicio = self.find('#consulta-inicio').val();
        var fim = self.find('#consulta-fim').val();
        var status = self.find('#consulta-status').val();
        var paciente = self.find('#consulta-paciente').val();
        var notas = self.find('#consulta-notas').val();

        openSwalScreen();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: self.attr('action'),
            data: {
                inicio,
                fim,
                status,
                paciente,
                notas
            },
            dataType: 'json',
            async: true,
            success: function(data) {

                if (data.code === 201) {
                    openSwalScreenProgressEditable('Sucesso', 'A consulta foi marcada.');
                    $("#cadastra-consulta-modal").modal('hide');
                    window.location.reload();
                } else {
                    openSwalMessage('Ocorreu um erro no cadastro da consulta.', data.message);
                    $("#cadastra-consulta-modal").modal('show');
                }

            },
            error: function(data) {
                openSwalMessage('Erro inesperado', data.message);
            }
        })

    });

    $('.btnNovaConsulta').click(function() {
        var self = $(this);

        $("#formConsultaModal input, select, textarea").attr('disabled', false);
        $("#btnConsulta").show();

        limparModal();

        if (self.data('paciente')) {
            $('#consulta-paciente').selectpicker('val', self.data('paciente'));
        }

        $("#cadastra-consulta-modal").modal('show');
        $("#consulta-notas").val("");
    });

    $(".datetimepicker").datetimepicker();

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
    });

    var url = window.location;

    $('ul#side-menu > li > a').filter(function() {
        return this.href == url;
    }).attr('href', '#').parent().addClass('active');

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $('#prodTabs a[href="' + activeTab + '"]').tab('show');
    }

    $('.datepicker').datepicker({
        todayBtn: "linked",
        keyboardNavigation: true,
        forceParse: false,
        autoclose: true,
        changeMonth: true,
        changeYear: true,
        dateFormat: "dd/mm/yyyy",
        language: 'pt-BR'
    });

    $('.datepicker2').datepicker({
        todayBtn: "linked",
        keyboardNavigation: true,
        forceParse: false,
        autoclose: true,
        changeMonth: true,
        changeYear: true,
        endDate : new Date(),
        dateFormat: "dd/mm/yyyy",
        language: 'pt-BR'
    });

    $.extend($.expr[":"], {
      "containsIN": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
      }
    });

    $("#search-food").keyup(function() {

        $('td').css("background-color",'');

        var filter= $(this).val();
        var fonte= $(".select-search-fonte").val();

        if(fonte) {}

        $(".table-searchable tbody tr:not(:containsIN('" + filter + "'))").css("display", "none");
        $(".table-searchable tbody tr:containsIN('" + filter + "')").css("display", "");
        $('.table-searchable tbody tr td:containsIN("'+filter+'")');

    });

    $(".select-search-fonte").change(function(e) {

      var filter = $(this).val();

      $('td').css("background-color",'');

      $(".table-searchable tbody tr:not(:containsIN('" + filter + "'))").css("display", "none");
      $(".table-searchable tbody tr:containsIN('" + filter + "')").css("display", "");
      $('.table-searchable tbody tr td:containsIN("'+filter+'")');

    });

    $("#search-activity").keyup(function() {

        var self = $(this);

        var filter;
        filter = self.val();

        $("#table-atividades-fisicas tbody tr:not(:contains('" + filter + "'))").css("display", "none");
        $("#table-atividades-fisicas tbody tr:contains('" + filter + "')").css("display", "");

    });

    $("#search-model").keyup(function() {

        var self = $(this);

        var filter;
        filter = self.val();

        $("#table-models tbody tr:not(:contains('" + filter + "'))").css("display", "none");
        $("#table-models tbody tr:contains('" + filter + "')").css("display", "");

    });

    $(".btnMedida").click(function() {
        $("#medidas-modal").modal('show');
        $("#medida").val($(this).data('nome-medida'));
        $("#valor-medidas-modal").val("");
        $("#medidas-modal")
            .find('.modal-title')
            .html($(this).data('nome-medida').toUpperCase().replace(/_/g, ' '));
    });

    $('.btnOpenModalMetrics').click(function() {

        var self = $(this);

        $("#medida_label").val(self.data('medida-label'));
        $("#medida").val(self.data('medida'));

    });

    $(".medidas").not('.btnRemoverMedida').click(function() {
        $("#medidas-modal").modal('show');
        $("#medida").val($(this).data('medida'));
        $('#data_registro').val($(this).data('registro'));
        $('#valor').val($(this).data('valor'));
        $("#formMedidasModal").prop('action', $(this).data('url-update'));
    })

    $('#medidas-modal').on('hidden.bs.modal', function() {
        var form = $("#formMedidasModal").prop('action', "{{ route('consulta_adicionar_medidas_paciente') }}");
        $('#valor').val("");
    });

    $("#formObservacaoPaciente").submit(function(e) {

        var dataRegistro = $('#form-obs-data-registro').val();
        var observacao = $('#form-obs-observacao').val();
        var consulta = $("#form-obs-consulta").val();
        var paciente = $("#form-obs-paciente").val();

        var self = $(this);

        var route = self.attr('action');

        $("#observacoes-modal").modal('hide');

        e.preventDefault();

        openSwalScreen();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: route,
            data: {
                data_registro: dataRegistro,
                observacao: observacao,
                consulta: consulta,
                paciente: paciente
            },
            dataType: 'json',
            success: function(data) {
                openSwalScreenProgress();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    });

    $('.btnCancelarConsulta').click(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = self.data('url');

        swal({
            title: 'Deseja prosseguir?',
            text: "Quer cancelar esta consuta?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            var route = url;

            if (result.value) {

                openSwalScreen();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route,
                    data: [],
                    dataType: 'json',
                    success: function(data) {
                        openSwalScreenProgress();
                    },
                    error: function(data) {
                        openSwalMessage('Erro ao Processar Requisição', data.message);
                    }
                })

            }

        })
    });

    $('.btnFinalizarConsulta').click(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = self.data('url');

        swal({
            title: 'Deseja prosseguir?',
            text: "Quer finalizar esta consuta?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            var route = url;

            if (result.value) {

                openSwalScreen();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route,
                    data: [],
                    dataType: 'json',
                    success: function(data) {
                        openSwalScreenProgress();
                    },
                    error: function(data) {
                        openSwalMessage('Erro ao Processar Requisição', data.message);
                    }
                })

            }

        })
    });

    $(".inputAlterarHorarioRefeicao").change(function(e) {

        e.preventDefault();
        var self = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: self.data('url'),
            data: {
                id: self.data('id'),
                name: 'horario',
                value: self.val()
            },
            dataType: 'json',
            success: function(data) {
                //openSwalScreenProgress();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });

    $(".inputAlterarQuantidadeRefeicao").change(function(e) {

        e.preventDefault();
        var self = $(this);

        var campoTotal = $("#quantidade-total-" + self.data('item'));
        var campos = $('.inputRefeicoesLista-' + self.data('item'));

        var valorTotal = 0;

        $.each(campos, function(i, campo) {
            valorTotal += +campo.value;
        })

        $('.inputAlterarQuantidadeRefeicao');

        var result = valorTotal;

        campoTotal.data('valor-original', result);

        campoTotal.html(result + ' g');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: self.data('url'),
            data: {
                id: self.data('id'),
                name: 'quantidade',
                value: self.val()
            },
            dataType: 'json',
            success: function(data) {
                //openSwalScreenProgress();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });

    $(".inputAlterarQuantidadeRefeicao").change(function() {

        var self = $(this);
    });

    $(".inputAlterarQuantidadeRefeicaoModelo").change(function(e) {

        e.preventDefault();
        var self = $(this);

        var campoTotal = $("#quantidade-total-" + self.data('item'));
        var campos = $('.inputRefeicoesLista-' + self.data('item'));

        var valorTotal = 0;

        $.each(campos, function(i, campo) {
            valorTotal += +campo.value;
        })

        $('.inputAlterarQuantidadeRefeicao');

        var result = valorTotal;

        campoTotal.data('valor-original', result);

        campoTotal.html(result + ' g');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: self.data('url'),
            data: {
                id: self.data('id'),
                name: 'quantidade',
                value: self.val()
            },
            dataType: 'json',
            success: function(data) {
                //openSwalScreenProgress();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });
/*
    function send(self, event) {

        event.preventDefault();

        var name = self.attr('name');
        var value = self.val();
        var _token = $('input[name="_token"]').val();
        var user = $('input[name="user"]').val();
        var url = self.data('url');

        var id = self.data('id') ? self.data('id') : 0;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: {
                id: id,
                name: name,
                value: value,
                _token: _token
            },
            dataType: 'json',
            success: function(data) {},
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    }
*/
    function gravarAlimentosEvitados(self) {

        var name = self.attr('name');
        var value = self.val();
        var _token = $('input[name="_token"]').val();
        var paciente = self.data('paciente');
        var url = self.data('url');

        var id = self.data('id') ? self.data('id') : 0;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: {
                id: id,
                alimentos: value,
                paciente: paciente,
                _token: _token
            },
            dataType: 'json',
            success: function(data) {

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    }

    $("#formDiarioAlimentar").submit(function(e) {

        openSwalScreen();

    });

    $(".input-consulta-planejamento").change(function(e) {
        send($(this), e);
    });

    $(".input-informacoes-consulta").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-pessoal").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-pessoal-select").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-clinico").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-alimentar").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-gravidez").change(function(e) {
        send($(this), e);
    });

    $(".input-historico-gravidez-select").change(function(e) {
        send($(this), e);
    });

    $(".input-recomendacoes-consulta").change(function(e) {
        send($(this), e);
    });

    $(".input-recomendacoes-consulta-select").change(function(e) {
        send($(this), e);
    });

    $('input').on('itemAdded', function(event) {
        gravarAlimentosEvitados($(this));
    });

    $('input').on('itemRemoved', function(event) {
        gravarAlimentosEvitados($(this));
    });

    $(".comportamentosAlimentares").click(function() {
        var self = $(this);
        var id = self.data('id');
        var url = self.data('url');

        var form = $("#formComportamentoAlimentar").prop('action', url);

        var registro = self.data('registro');
        var observacao = self.data('observacao');
        var paciente = self.data('paciente');

        $("[name='data_registro_comportamentos']").val(registro);
        $("[name='observacao_comportamentos']").val(observacao);
        $("[name='paciente_comportamentos']").val(paciente);

        $('#comportamentos-alimentares-modal').modal('show');
    });

    $('#comportamentos-alimentares-modal').on('hidden.bs.modal', function() {

        var form = $("#formComportamentoAlimentar").prop('action', $("#consulta-comportamento-alimentar").val());

        var dataR = new Date();
        $("[name='data_registro_comportamentos']").val(dataR.toLocaleDateString());
        $("[name='observacao_comportamentos']").val("");
    });

    $("#formComportamentoAlimentar").submit(function(e) {
        openSwalScreen();
    });

    $(".btnMedida").click(function() {
        $("#medidas-modal").modal('show');
        $("#medida").val($(this).data('nome-medida'));
    });

    $(".diariosAlimentares").click(function() {
        var self = $(this);

        var id = self.data('id');
        var url = self.data('url');

        var form = $("#formDiarioAlimentar").prop('action', url);

        var refeicao = self.data('refeicao');
        var registro = self.data('registro');
        var descricao_refeicao = self.data('descricao-refeicao');
        var observacao = self.data('observacao');
        var paciente = self.data('paciente');
        var consulta = self.data('consulta');

        $("[name='refeicao']").val(refeicao);
        $("[name='data_registro']").val(registro);
        $("[name='descricao_refeicao']").val(descricao_refeicao);
        $("[name='observacao']").val(observacao);
        $("[name='paciente']").val(paciente);
        $("[name='consulta']").val(consulta);

        $('#food-diary-modal').modal('show');
    });

    $('#food-diary-modal').on('hidden.bs.modal', function() {

        var form = $("#formDiarioAlimentar").prop('action', $("#consulta-diario-alimentar-store").val());

        $("[name='descricao_refeicao']").val("");
        $("[name='observacao']").val("");
    });

    $(".observacoesPaciente").click(function(e) {
        var self = $(this);

        e.preventDefault();

        var id = self.data('id');
        var url = self.data('url-remove');
        var urlEdit = self.data('url');

        var inputRemoveItem = $('.remove-item');
        inputRemoveItem.show();
        inputRemoveItem.attr('data-url', url);
        inputRemoveItem.attr('data-id', id);

        var form = $("#formObservacaoPaciente").attr('action', urlEdit);

        var registro = self.data('registro');
        var observacao = self.data('observacao');
        var paciente = self.data('paciente');
        var consulta = self.data('consulta');

        $(".remove-item").data('id', id);

        $("[name='data_registro']").val(registro);
        $("[name='observacao']").val(observacao);
        $("[name='paciente']").val(paciente);
        $("[name='consulta']").val(consulta);

        $('#observacoes-modal').modal('show');
    });

    $('#observacoes-modal').on('hidden.bs.modal', function() {
        var form = $("#formObservacaoPaciente").prop('action', $("#consulta-observacao-paciente").val());
        $("[name='observacao']").val("");
    });

    $('.remove-item').click(function(e) {
        var self = $(this);
        send(self, e);
        $("#tr-observaoces-" + self.data('id')).hide();
    });

    $('.btnOpenModalMetrics').click(function() {

        var self = $(this);

        $("#medida_label").val(self.data('medida-label'));
        $("#medida").val(self.data('medida'));

    });

    $("#formMedidasModal").submit(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = $(this).attr('action');
        var btnEdit = self.find('#btnEditMedida');
        var form = self.parents('form');
        var ibox = self.parents('.ibox');
        var $table = ibox.find('.table-override');
        var tableRoute = btnEdit.val();

        $(".morrischart").empty();

        $("#medidas-modal").modal('hide');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: self.serialize(),
            dataType: 'json',
            async: true,
            success: function(data) {

              $.ajax({
                type: 'GET',
                url: tableRoute,
                async: true,
                cache: true,
                success: function(data) {
                    $("#card-medida-"+$("#card-medida").val()).html(data);
                }
              })


            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });

    $("#formRefeicaoModal").submit(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = $(this).attr('action');
        var btnEdit = self.find('#btnEditMedida');
        var form = self.parents('form');
        var ibox = self.parents('.ibox');
        var $table = ibox.find('.table-override');
        var tableRoute = btnEdit.val();

        $("#meals-modal").modal('hide');

        var refeicoesBoxRoute = $("#consulta-refeicoes-view").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: self.serialize(),
            dataType: 'json',
            success: function(data) {

                $("#formRefeicaoModal").find('input[type=checkbox]').attr('checked', false);

                if(data.success) {

                  $.ajax({
                    type: 'GET',
                    url: refeicoesBoxRoute,
                    async: true,
                    cache: true,
                    success: function(data) {
                        $("#box-refeicao").html(data);
                    }
                  })

                } else {

                  swal(
                    'Erro ao Processar Requisição',
                    data.message,
                    'error'
                  )

                }

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });

    $("#formReceitaModal").submit(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = $(this).attr('action');
        var btnEdit = self.find('#btnEditMedida');
        var form = self.parents('form');
        var ibox = self.parents('.ibox');
        var $table = ibox.find('.table-override');
        var tableRoute = btnEdit.val();

        $("#receitas-modal").modal('hide');

        var refeicoesBoxRoute = $("#consulta-refeicoes-view").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            data: self.serialize(),
            dataType: 'json',
            success: function(data) {

              if(data.success) {

                $.ajax({
                  type: 'GET',
                  url: refeicoesBoxRoute,
                  async: true,
                  cache: true,
                  success: function(data) {
                      $("#box-refeicao").html(data);
                  }
                })

              } else {

                swal(
                  'Erro ao Processar Requisição',
                  data.message,
                  'error'
                )

              }

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })
    });

    $(document).on('click','.medidas',function(){

      var self = $(this);

      $("#medidas-modal").modal('show');
      $("#medida").val(self.data('medida'));
      $('#data-registro-medidas-modal').val(self.data('registro'));
      $('#valor-medidas-modal').val(self.data('valor'));
      $("#formMedidasModal").prop('action', self.data('url-update'));
      $("#btnEditMedida").val(self.data('table-route'));
      $("#card-medida").val(self.data('med-id'));

    });

    $(document).on('click','.btnRemoverMedida',function(){

      var self = $(this);
      var url = self.data('url');
      var medida = self.data('medida-id');

      swal({
          title: 'Remover Medida?',
          text: "Esta ação não pode ser revertida!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remover!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: url,
                data: {},
                async: true,
                dataType: 'json',
                success: function(data) {

                  if(data.code == 304) {

                    self.parents('tr').hide();

                    //carregarMedidasPaciente();

                    swal(
                      'Removido!',
                      'A medida foi removida.',
                      'success'
                    )
                  }

                },
                error: function(data) {
                    openSwalMessage('Erro ao Processar Requisição', data.message);
                }
            })


          }
        });

    });

    $('#medidas-modal').on('hidden.bs.modal', function() {
        var form = $("#formMedidasModal").prop('action', $("#consulta-medidas-paciente").val());
        $('#valor').val("");
    });

    $('#tabs').on('click', '.tablink,#prodTabs a', function(e) {
        e.preventDefault();
        var url = $(this).attr("data-url");

        if (typeof url !== "undefined") {
            var pane = $(this),
                href = this.hash;

            // ajax load from data-url
            $(href).load(url, function(result) {
                pane.tab('show');
            });
        } else {
            $(this).tab('show');
        }
    });

    $('#table').on('click-row.bs.table', function(row, $element, field) {
        $("#add-meals-modal").modal('show');
        $("#nome-alimento").html($element['nome']);
        $("#quantidade").val($element['quantidade']);
        $("#id-alimento").val($element['id']);
        $("#id-paciente-refeicao").val($(".pacienteRefeicao").val());
    });

    const repeticoesAtividades = [8, 7, 6, 5, 4, 3, 2, 1];

    $(".btnAddAtividadeFisicaRecomendacoes").click(function() {

        var self = $(this);
        var id = self.data('id');
        var nome = self.data('nome');
        var energiaOriginal = self.data('energia_original');

        $("#add-physical-activities-modal").modal('show');
        $("#nome-atividade-fisica").html(nome);
        $("#id-atividade-fisica").val(id);

        $("#energia-original").val(energiaOriginal);

        var duracao = $("#duracao-atividade-fisica").val();
        var energia = energiaOriginal;
        var repeticoes = $("#repeticoes-atividade-fisica").val();

        var total = energia * duracao;

        $("#energia-atividade-fisica").html(total + ' kcal');

        valorMedia = total / repeticoesAtividades[repeticoes];

        valorMedia = Math.ceil(valorMedia);

        $("#media-atividade-fisica").html(valorMedia + ' kcal');

        $("#input-energia-atividade-fisica").val(total);
        $("#input-media-atividade-fisica").val(valorMedia);

    });

    $("#tempo-atividade-fisica").change(function() {
        var self = $(this);
        var duracao = $("#duracao-atividade-fisica").val() ? $("#duracao-atividade-fisica").val() : 0;
        var energia = $("#energia-original").val();
        var repeticoes = $("#repeticoes-atividade-fisica").val();
        var tempo = self.val();

        if (tempo == 'horas') {
            duracao = duracao * 60;
        }

        var total = energia * duracao;

        $("#energia-atividade-fisica").html(total + ' kcal');

        valorMedia = total / repeticoesAtividades[repeticoes];

        valorMedia = Math.ceil(valorMedia);

        $("#media-atividade-fisica").html(valorMedia + ' kcal');

        $("#input-energia-atividade-fisica").val(total);
        $("#input-media-atividade-fisica").val(valorMedia);

    });

    $("#duracao-atividade-fisica").keyup(function() {
        var self = $(this);
        var duracao = self.val() ? self.val() : 0;
        var energia = $("#energia-original").val();
        var tempo = $("#tempo-atividade-fisica").val();
        var repeticoes = $("#repeticoes-atividade-fisica").val();

        if (tempo == 'horas') {
            duracao = duracao * 60;
        }

        var total = energia * duracao;

        $("#energia-atividade-fisica").html(total + ' kcal');

        valorMedia = total / repeticoesAtividades[repeticoes];

        valorMedia = Math.ceil(valorMedia);

        $("#media-atividade-fisica").html(valorMedia + ' kcal');

        $("#input-energia-atividade-fisica").val(total);
        $("#input-media-atividade-fisica").val(valorMedia);
    });

    $("#repeticoes-atividade-fisica").change(function() {
        var self = $("#repeticoes-atividade-fisica").val();
        var duracaoElement = $("#duracao-atividade-fisica").val();
        var duracao = duracaoElement ? duracaoElement : 0;
        var energia = $("#energia-original").val();
        var tempo = $("#tempo-atividade-fisica").val();

        if (tempo == 'horas') {
            duracao = duracao * 60;
        }

        var total = energia * duracao;

        $("#energia-atividade-fisica").html(total + ' kcal');

        valorMedia = total / repeticoesAtividades[self];

        valorMedia = Math.ceil(valorMedia);

        $("#media-atividade-fisica").html(valorMedia + ' kcal');

        $("#input-energia-atividade-fisica").val(total);
        $("#input-media-atividade-fisica").val(valorMedia);
    });

    $(".formAdicionarAtividadeFisica").submit(function(event) {

        event.preventDefault();

        var url = $("#url-adicionar-atividade-fisica").val();

        var $table = $('.table-override-atividades');
        var tableRoute = $('#table-route').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            cache: false,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {

                //openSwalMessageCard(data.message);

                $("#add-physical-activities-modal").modal('hide');

                $.ajax({
                  type: 'GET',
                  url: tableRoute,
                  async: true,
                  cache: true,
                  success: function(data) {
                      $table.html(data);
                  }
                })

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });
    });

    $(document).on('click', '.btnRemoverAtividadeFisica', function(){

        event.preventDefault();

        var url = $(this).data('url');
        var id = $(this).data('id');
        var self = $(this);
        var tr = self.parents('tr');

        swal({
          title: 'Remover Atividade Fisica?',
          text: "Esta ação não pode ser revertida!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remover!'
        }).then((result) => {
          if (result.value) {

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            cache: false,
            data: id,
            dataType: 'json',
            success: function(data) {
                tr.hide();

                const toast = swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000
                });

                toast({
                  type: 'success',
                  title: 'Ok!, o registro foi removido com sucesso.'
                });
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });

          }
        });
    });

    $(document).on('click', '.btnAddRefeicao', function(){
      $("#meals-modal").modal('show');
      $(".pacienteRefeicao").val($(this).data('paciente-refeicao'));
      $("#medida").val($(this).data('nome-medida'));
      $("#id-refeicao").val($(this).data('refeicao'));
    });

    $(document).on('click', '.btnAddReceita', function(){
      $(".pacienteRefeicao").val($(this).data('paciente-refeicao'));
      $("#medida").val($(this).data('nome-medida'));
    });

    $('#meals-modal').on('hidden.bs.modal', function() {
        //window.location.reload();
    });

    $(".horario-refeicao").change(function() {
        send($(this), e);
    });

    $("#formAddRefeicao").submit(function(e) {

        e.preventDefault();

        openSwalScreen();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: $("#consulta-alimentos-sugeridos").val(),
            cache: false,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                $("#add-meals-modal").modal('hide');
                //openSwalScreenProgress();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });

    });

    $(document).on('click', '.editarRefeicaoConsulta', function(e){

      var self = $(this);
      var id = self.data('id');
      var url = self.data('url-micronutrientes');

      $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {

          data = JSON.parse(data);

          $.each(data, function(i, item) {
              lista[i] += parseFloat(item);
          });

          $.each(lista, function(i, item) {

              item = parseFloat(item);
              if (isNaN(item)) {
                  var item = 0;
              }
              $("#modal-editar-refeicao-" + i).html(Math.ceil(item));
              $("#modal-editar-refeicao-" + i + " span").html(Math.ceil(item));

          });

        },
        complete: function(data) {

        }
      });

      $("#edit-meals-modal").modal('show');
      $("#edit-meals-modal").find('.modal-title').html(self.data('nome-refeicao'));
      $("#modal-editar-refeicao-fonte").html(self.data('fonte'));
      $("#paciente-refeicao").val(self.data('id'));
      $("#url-remover-refeicao").val(self.data('url'));

    }).not('.form-control');

    $(".btnRemoverAlimentoRefeicao").click(function() {

        var pacienteRefeicao = $("#paciente-refeicao").val();
        var url = $("#url-remover-refeicao").val();

        var self = $(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            dataType: 'json',
            success: function(data) {
                $("#lista-refecoes-" + pacienteRefeicao).hide();
                $("#edit-meals-modal").modal('hide');
                //openSwalScreenProgress();

                limparTabela(self);
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    });

    $(document).on('click','.linkRemoverAlimentoRefeicao',function(){

        var self = $(this);
        var pacienteRefeicao = self.data('id');
        var url = self.data('url');

        var tr = self.parents('tr');

        var valor = tr.find('.inputAlterarQuantidadeRefeicao').val();

        var campoTotal = $("#quantidade-total-" + self.data('item'));

        var valorTotal = campoTotal.data('valor-original');

        var result = valorTotal - valor;

        campoTotal.html(result + ' g');

        swal({
          title: 'Remover Alimento?',
          text: "Esta ação não pode ser revertida!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remover!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: url,
                dataType: 'json',
                success: function(data) {
                    $("#lista-refecoes-" + pacienteRefeicao).hide();
                    $("#edit-meals-modal").modal('hide');
                    limparTabela(self);

                    self.parents('tr').hide();

                    const toast = swal.mixin({
                      toast: true,
                      position: 'top-end',
                      showConfirmButton: false,
                      timer: 3000
                    });

                    toast({
                      type: 'success',
                      title: 'Ok!, o registro foi removido com sucesso.'
                    });

                },
                error: function(data) {
                    openSwalMessage('Erro ao Processar Requisição', data.message);
                }
            })


          }
        });

    });

    $(document).on('click', '.linkRemoverReceitaoRefeicao', function(){

      var self = $(this);
      var pacienteRefeicao = self.data('id');
      var url = self.data('url');

      var tr = self.parents('tr');

      var valor = tr.find('.inputAlterarQuantidadeRefeicao').val();

      var campoTotal = $("#quantidade-total-" + self.data('item'));

      var valorTotal = campoTotal.data('valor-original');

      var result = valorTotal - valor;

      campoTotal.html(result + ' g');

      swal({
        title: 'Remover Alimento?',
        text: "Esta ação não pode ser revertida!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, remover!'
      }).then((result) => {
        if (result.value) {

          $.ajax({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type: "POST",
              url: url,
              dataType: 'json',
              success: function(data) {
                  $("#lista-refecoes-" + pacienteRefeicao).hide();
                  $("#edit-meals-modal").modal('hide');

                  tr.hide();

                  limparTabela(self);

                  const toast = swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

                  toast({
                    type: 'success',
                    title: 'Ok!, o registro foi removido com sucesso.'
                  });
              },
              error: function(data) {
                  openSwalMessage('Erro ao Processar Requisição', data.message);
              }
          })

        }
      });

    });

    $(".linkRemoverAlimentoRefeicaoModelo").click(function() {

        var self = $(this);
        var pacienteRefeicao = self.data('id');
        var url = self.data('url');

        var tr = self.parents('tr');

        var valor = tr.find('.inputAlterarQuantidadeRefeicaoModelo').val();

        var campoTotal = $("#quantidade-total-" + self.data('item'));

        var valorTotal = campoTotal.data('valor-original');

        var result = valorTotal - valor;

        campoTotal.html(result + ' g');

        swal({
          title: 'Remover Alimento?',
          text: "Esta ação não pode ser revertida!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remover!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: url,
                dataType: 'json',
                success: function(data) {
                    $("#lista-refecoes-" + pacienteRefeicao).hide();
                    $("#edit-meals-modal").modal('hide');
                    limparTabela(self);
                },
                error: function(data) {
                    openSwalMessage('Erro ao Processar Requisição', data.message);
                }
            })

          }
        });



    });

    function limparTabela(elemento) {
        var tbody = elemento.parents('tbody');

        if ($(tbody).children('tr:visible').length == 0) {
            tbody.parents('table').hide();
        }

    }

    $(".btnAddAtividadeFisica").click(function() {
        $("#physical-activities-modal").modal('show');
    });

    var lista = {
        sodio: 0,
        vitamina_a: 0,
        vitamina_b6: 0,
        vitamina_c: 0,
        calcio: 0,
        ferro: 0,
        magnesio: 0,
        fosforo: 0,
        potassio: 0,
        zinco: 0,
        cobre: 0,
        manganes: 0,
        tiamina: 0,
        riboflavina: 0,
        niacina: 0
    };

    $.each($('.editarRefeicaoConsulta'), function($index, $item) {

        var id = $($item).data('id');

        var url = "/food/" + id + "/ajax";

        $.ajax({
          type: 'GET',
          url: url,
          async: true,
          cache: true,
          success: function(data) {

            data = JSON.parse(data);

            $.each(data, function(i, item) {

                lista[i] += parseInt(item);

            });

          },
          complete: function(data) {

            $.each(lista, function(i, item) {

                if (isNaN(item)) {
                    var item = 0;
                }

                $("#lista-" + i + " span").html(Math.ceil(item));
            });

          }
        })

    });

    $(".selecionarRefeicaoPaciente").click(function() {

        var self = $(this);

        $("#adicionar-refeicao-paciente-horario-modal").modal("show");

        //$("#adicionar-refeicao-paciente-horario-modal").find('.modal-title').html(self.data('nome-refeicao'));
        $("#editar-nome-refeicao-modal").val(self.data('nome-refeicao'));
        $("#horario-refeicao-modal").val(self.data('horario'));
        $("#id-refeicao-modal").val(self.data('id'));
    });

    $(".selecionarRefeicaoModelo").click(function() {

        var self = $(this);

        $("#adicionar-refeicao-paciente-horario-modal").modal("show");
        $("#adicionar-refeicao-paciente-modal").modal("hide");

        $("#adicionar-refeicao-paciente-horario-modal").find('.modal-title').html(self.data('nome-refeicao'));
        $("#editar-nome-refeicao-modal").val(self.data('nome-refeicao'));
        $("#horario-refeicao-modal").val(self.data('horario'));
        $("#id-refeicao-modal").val(self.data('id'));
    });

    $("#formAddRefeicaoPacienteHorario").submit(function(e) {

        e.preventDefault();

        var refeicoesBoxRoute = $("#consulta-refeicoes-view").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: $("#url-adicionar-refeicao").val(),
            cache: false,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data) {
                $("#adicionar-refeicao-paciente-horario-modal").modal('hide');
                var idRefeicaoModal = $("#id-refeicao-modal").val();
                var idRefeicao = $("#id-refeicao-" + idRefeicaoModal).hide();

                $.ajax({
                  type: 'GET',
                  url: refeicoesBoxRoute,
                  async: true,
                  cache: true,
                  success: function(data) {
                      $("#box-refeicao").html(data);
                  }
                })

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });


    });

    $("#formAddRefeicaoPacienteHorarioModelo").submit(function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: $("#url-adicionar-refeicao").val(),
            cache: false,
            data: $(this).serialize(),
            dataType: 'json',
            async: true,
            success: function(data) {
                $("#adicionar-refeicao-paciente-horario-modal").modal('hide');
                var idRefeicaoModal = $("#id-refeicao-modal").val();
                var idRefeicao = $("#id-refeicao-" + idRefeicaoModal).hide();
                openSwalScreenProgress();
                window.location.reload();
            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });

    });

    $(document).on('click', '.btn-modelo-add-refeicao', function(e){
        var self = $(this);
        var modelo = self.data('modelo-refeicao');
        $("#modelo-alimentar-refeicao").val(modelo);
    });

    $(document).on('click', '.removerRefeicaoPaciente', function(e){

        e.preventDefault();

        var self = $(this);

        swal({
          title: 'Remover Refeição?',
          text: "Esta ação não pode ser revertida!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remover!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: self.data('url'),
                cache: false,
                dataType: 'json',
                async: true,
                success: function(data) {
                    self.parents('.ibox').hide();
                },
                error: function(data) {
                    openSwalMessage('Erro ao Processar Requisição', data.message);
                }
            });

          }
        });

    });

    $(".editar-campo").click(function() {

        var self = $(this);

        $("#editarMedidasPlanejamento").modal('show');
        $("#editarMedidasPlanejamento").find('.modal-title').html(self.data('title'))
        $('#label-modal').html(self.data('field'));

    });



    $(".input-planejamento-consulta").change(function(e) {

        e.preventDefault();

        var self = $(this);

        var url = self.data('url');
        var index = self.attr('name');
        var valor = self.val();
        var entidade = self.data('entidade');
        var planejamento = self.data('planejamento');

        //openSwalScreen();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: url,
            cache: false,
            data: {
                url: url,
                index: index,
                valor: valor,
                entidade: entidade,
                planejamento: planejamento
            },
            dataType: 'json',
            success: function(data) {





            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });

    });

    $(".formulasTmb").change(function() {

        var self = $(this);
        var route = self.data('route');

        $.ajax({
          type: 'GET',
          url: route,
          async: true,
          cache: true,
          success: function(data) {

            data = JSON.parse(data);

            $("#planejamento-tmb-atual").val(data.atual);
            $("#planejamento-tmb-recomendado").val(data.recomendado);

          }
        })

    });

    $(".formulasNed").change(function() {

        var self = $(this);
        var route = self.data('route');

        $.ajax({
          type: 'GET',
          url: route,
          async: true,
          cache: true,
          success: function(data) {

            data = JSON.parse(data);

            $("#planejamento-ned-atual").val(data.atual);
            $("#planejamento-ned-recomendado").val(data.recomendado);

          }
        })

    });

    var array = [
        1,
        1,
        1
    ];

    $(".sparkline5").sparkline(array, {
        type: 'pie',
        height: '160px',
        sliceColors: ['#1ab394', '#23c6c8', '#1c84c6', '#d1dade']
    });

    if (document.getElementById('url-macronutrientes')) {

      $.ajax({
        type: 'GET',
        url: $("#url-macronutrientes").val(),
        async: true,
        cache: true,
        success: function(retorno) {

          var doughnutData = JSON.parse(retorno);

          var doughnutOptions = {
              segmentShowStroke: true,
              segmentStrokeColor: "#fff",
              segmentStrokeWidth: 2,
              percentageInnerCutout: 45, // This is 0 for Pie charts
              animationSteps: 100,
              animationEasing: "easeOutBounce",
              animateRotate: true,
              animateScale: true,
          };

          var data = {

              datasets: [{
                  data: doughnutData.data,
                  backgroundColor: doughnutData.backgroundColor
              }],

              labels: doughnutData.labels

          };

          var config = {
              type: 'doughnut',
              data: data,
              options: doughnutOptions
          };

          var ctx = document.getElementById("refeicoes-pie").getContext("2d");
          var DoughnutChart = new Chart(ctx, config);

          var ctx2 = document.getElementById("analise-macronutrientes").getContext("2d");
          var DoughnutChart = new Chart(ctx2, config);

        }
      })

    }

    if (document.getElementById('url-distribuicao-energetica-refeicoes')) {

        var url = $("#url-distribuicao-energetica-refeicoes").val();

        $.ajax({
          type: 'GET',
          url: url,
          async: true,
          cache: true,
          success: function(retorno) {

            var doughnutData = JSON.parse(retorno);

            var doughnutOptions = {
                segmentShowStroke: true,
                segmentStrokeColor: "#fff",
                segmentStrokeWidth: 2,
                percentageInnerCutout: 45,
                animationSteps: 100,
                animationEasing: "easeOutBounce",
                animateRotate: true,
                animateScale: true,
                legend: {
                    display: false,
                    position: 'right',
                    labels: {}
                }
            };

            var data = {

                datasets: [{
                    data: doughnutData.data,
                    backgroundColor: doughnutData.backgroundColor
                }],

                labels: doughnutData.labels

            };

            var ctx = document.getElementById("analise-distribuicao-energetica").getContext("2d");

            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: doughnutOptions
            });

          }
        });

    }

    if (document.getElementById('url-distribuicao-proteinas-refeicoes')) {


      $.ajax({
        type: 'GET',
        url: $("#url-distribuicao-proteinas-refeicoes").val(),
        async: true,
        cache: true,
        success: function(retorno) {

          var doughnutData = JSON.parse(retorno);

          var doughnutOptions = {
              segmentShowStroke: true,
              segmentStrokeColor: "#fff",
              segmentStrokeWidth: 2,
              percentageInnerCutout: 45, // This is 0 for Pie charts
              animationSteps: 100,
              animationEasing: "easeOutBounce",
              animateRotate: true,
              animateScale: true,
              legend: {
                  display: false,
                  position: 'right',
                  labels: {}
              }
          };

          var data = {

              datasets: [{
                  data: doughnutData.data,
                  backgroundColor: doughnutData.backgroundColor
              }],

              labels: doughnutData.labels

          };

          var ctx = document.getElementById("analise-distribuicao-proteinas").getContext("2d");

          var myBarChart = new Chart(ctx, {
              type: 'horizontalBar',
              data: data,
              options: doughnutOptions
          });

        }
      })

    }

    if (document.getElementById('url-distribuicao-macronutrientes-refeicoes')) {

      $.ajax({
        type: 'GET',
        url: $("#url-distribuicao-macronutrientes-refeicoes").val(),
        async: true,
        cache: true,
        success: function(retorno) {

          var doughnutData = JSON.parse(retorno);

          $.each(doughnutData.data, function(i, item) {

              var doughnutOptions = {
                  segmentShowStroke: true,
                  segmentStrokeColor: "#fff",
                  segmentStrokeWidth: 2,
                  percentageInnerCutout: 45, // This is 0 for Pie charts
                  animationSteps: 100,
                  animationEasing: "easeOutBounce",
                  animateRotate: true,
                  animateScale: true,
                  legend: {
                      display: false,
                      position: 'left',
                      labels: {}
                  }
              };

              var data = {

                  datasets: [{
                      data: item,
                      backgroundColor: doughnutData.backgroundColor
                  }],

                  labels: doughnutData.labels

              };

              var ctx = document.getElementById("analise-distribuicao-macronutrientes-" + i).getContext("2d");

              var myBarChart = new Chart(ctx, {
                  type: 'bar',
                  data: data,
                  options: doughnutOptions
              });

          });

        }
      })

    }

    if (document.getElementById('url-micronutrientes')) {

      $.ajax({
        type: 'GET',
        url: $("#url-micronutrientes").val(),
        async: true,
        cache: true,
        success: function(retorno) {

          var doughnutData = JSON.parse(retorno);

          var doughnutOptions = {
              segmentShowStroke: true,
              segmentStrokeColor: "#fff",
              segmentStrokeWidth: 2,
              percentageInnerCutout: 45, // This is 0 for Pie charts
              animationSteps: 100,
              animationEasing: "easeOutBounce",
              animateRotate: true,
              animateScale: true,
          };

          var data = {

              datasets: [{
                  data: doughnutData.data,
                  backgroundColor: doughnutData.backgroundColor
              }],

              labels: doughnutData.labels

          };

          var config = {
              type: 'doughnut',
              data: data,
              options: doughnutOptions
          };

          var ctx = document.getElementById("divisao-micronutrientes").getContext("2d");
          var DoughnutChart = new Chart(ctx, config);

        }
      })

    }
});

function limparModal() {

    $('#consulta-status option')
        .removeAttr('selected');

    $('#consulta-paciente').selectpicker('val', "");
    $("#consulta-notas").val("");
}

function popularModalAndShow(event) {
    $("#formConsultaModal").prop('action', '/consults/' + event.id + '/update');

    $("#cadastra-consulta-modal").modal('show');
    $("#cadastra-consulta-modal").find('#title').val(event.title);

    $("#consulta-inicio").val(event.start.format('DD/MM/YYYY HH:mm'));
    $("#consulta-fim").val(event.end.format('DD/MM/YYYY HH:mm'));

    $('#consulta-status option')
        .removeAttr('selected')
        .filter('[value="' + event.status + '"]')
        .attr('selected', true)

    $('#consulta-paciente').selectpicker('val', event.paciente);

    $("#consulta-notas").val(event.notas);

    if (event.status_id == 3 || event.status_id == 4) {
        $("#btnConsulta").hide();
        $("#formConsultaModal input, select, textarea").attr('disabled', true);
    } else if (event.status_id == 2) {
        $("#btnConsulta").html('Editar Consulta').show();
        $("#formConsultaModal input, select, textarea").attr('disabled', false);
    } else {
        $("#btnConsulta").show();
        $("#formConsultaModal input, select, textarea").attr('disabled', false);
    }

}

function popularModal(event) {
    $("#formConsultaModal").prop('action', '/consults/' + event.id + '/update');

    //$("#cadastra-consulta-modal").modal('show');
    $("#cadastra-consulta-modal").find('#title').val(event.title);

    $("#consulta-inicio").val(event.start.format('DD/MM/YYYY HH:mm'));
    $("#consulta-fim").val(event.end.format('DD/MM/YYYY HH:mm'));

    $('#consulta-status option')
        .removeAttr('selected')
        .filter('[value="' + event.status + '"]')
        .attr('selected', true)

    $('#consulta-paciente').selectpicker('val', event.paciente);

    $("#consulta-notas").val(event.notas);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: $("#formConsultaModal").attr('action'),
        data: $("#formConsultaModal").serialize(),
        dataType: 'json',
        success: function(data) {
            //openSwalScreenProgress();
        },
        error: function(data) {
            openSwalMessage('Erro ao Processar Requisição', data.message);
        }
    })


}

$(function() {

    $(".locateCep").blur(function(e) {

        var self = $(this);
        var url = self.data('link');
        var cep = self.val();

        if(cep.lengh < 8) {
           e.preventDefault();
           return false;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: url,
            data: {
                cep: cep
            },
            dataType: 'json',
            success: function(data) {

                if (data.code == 304) {

                    self.data('url', $('#url-atualizar-informacoes-profissional').val())
                    send(self);

                    var reg = data.data;
                    var route = $("#url-atualizar-informacoes-profissional").val();

                    if (reg) {

                        var logradouro = $("#endereco");
                        logradouro.val(reg.logradouro);
                        logradouro.data('url', route)

                        send(logradouro);

                        var numero = $("#numero");
                        numero.val(reg.numero);
                        numero.data('url', route)

                        send(numero);

                        var bairro = $("#bairro");
                        bairro.val(reg.bairro);
                        bairro.data('url', route)

                        send(bairro);

                        var cidade = $("#cidade");
                        cidade.val(reg.localidade);
                        cidade.data('url', route)

                        send(cidade);

                        var estado = $("#estado");
                        estado.val(reg.uf);
                        estado.data('url', route)

                        send(estado);

                    }

                }

            },
            error: function(data) {
                //openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    });

    $(".checkZip").blur(function() {

        var self = $(this);
        var url = self.data('link');
        var cep = self.val();


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: url,
            data: {
                cep: cep
            },
            dataType: 'json',
            success: function(data) {

                if (data.code == 304) {

                    self.data('url', $('#paciente-route').val())
                    send(self);

                    var reg = data.data;
                    var route = $("#url-atualizar-informacoes-paciente").val();

                    if (reg) {

                        var logradouro = self.parents('form').find("#paciente-address");
                        logradouro.val(reg.logradouro);
                        logradouro.data('url', route)

                        sendStaticRoute(logradouro);

                        var cidade = self.parents('form').find("#paciente-city");
                        cidade.val(reg.localidade);
                        cidade.data('url', route)
                        sendStaticRoute(cidade);

                        var estado = self.parents('form').find("#paciente-state");
                        estado.val(reg.uf);
                        estado.data('url', route)
                        sendStaticRoute(estado);

                    }

                }

            },
            error: function(data) {
                //openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        })

    });

    $(".inputInformcoesPaciente").change(function() {
        $(this).data('url', $('#url-atualizar-informacoes-paciente').val())
        send($(this));
    });

    $(".inputInformcoesEditarPaciente").change(function() {
        $(this).data('url', $('#editar-paciente-route').val())
        $(this).append($("#method"));
        send($(this));
    });

    $(".btnNovopaciente").click(function(e) {
        $("#form-cadastra-paciente-modal input").val("");
    });

    $(".btnEditarPaciente").click(function() {

        var form = $("#formEditaPaciente");
        var self = $(this);
        var url = self.data('url');
        var paciente = self.data('id');
        var route = self.data('url-update');

        console.log(route);

        $("#formEditaPaciente").find(".input-group").removeClass('has-error').find('.help-block').remove();

        $("#editar-paciente-route").val(route);
        $("#url-atualizar-informacoes-paciente").val(route);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: url,
            data: {
                id: paciente
            },
            dataType: 'json',
            success: function(data) {

                if (data.code == 304) {

                    var reg = data.data;

                    $.each(reg, function(i, item) {
                        $("#paciente-" + i).val(item);
                    });

                }

            },
            error: function(data) {
                openSwalMessage('Erro ao Processar Requisição', data.message);
            }
        });

    });

    $("#form-cadastra-paciente-modal").submit(function(e) {

        $("#cadastrar-paciente").find('button[type="submit"]').attr('disabled', true);

        var self = $(this);

        e.preventDefault();

        var name = self.find('#paciente-name').val();
        var birth = self.find('#paciente-birth').val();
        var from = self.find('#paciente-from').val();
        var phone = self.find('#paciente-phone').val();
        var gender = self.find('#paciente-gender').val();
        var occupation = self.find('#paciente-occupation').val();
        var zip = self.find('#paciente-zip').val();
        var email = self.find('#paciente-email').val();

        var address = self.find('#paciente-address').val();
        var city = self.find('#paciente-city').val();
        var state = self.find('#paciente-state').val();
        var country = self.find('#paciente-country').val();
        var number = self.find('#paciente-number').val();

        var password = self.find('#paciente-password').val();

        var itens = [name, birth, phone, gender, email];

        var continuar = true;

        $.each(itens, function(i, item) {
            if (item === "") {

                swal({
                    type: 'warning',
                    title: 'Oops...',
                    text: 'Todos os campos devem ser preenchidos!',
                });

                continuar = false

                e.preventDefault();
                return false;
            }
        });

        $("#cadastrar-paciente").modal('hide');

        if(continuar === true) {
          $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: self.attr('action'),
            data: {
                name: name,
                birth: birth,
                from: from,
                phone: phone,
                gender: gender,
                occupation: occupation,
                zip: zip,
                email: email,
                address: address,
                city: city,
                state: state,
                country: country,
                number: number,
                password: password
            },
            dataType: 'json',
            success: function(data) {

                if (data.code === 201) {
                    openSwalScreenProgress();
                } else {
                    openSwalMessage('Erro ao cadastrar paciente.', data.message);
                    $("#cadastrar-paciente").modal('show');
                }

            },
            error: function(data) {
                openSwalMessage('Erro inesperado', data.message);
            },
            complete: function(data) {
                $("#cadastrar-paciente").find('button[type="submit"]').attr('disabled', false);
            }
        })
        }

    });

    $(".medida-valor").blur(function(e) {

      var self = $(this);

      if(self.val() == "") {
        e.preventDefault();
        return false;
      }

      var url = self.data('url');
      var form = self.parents('form');
      var ibox = self.parents('.ibox');
      var $table = ibox.find('.table-override');
      var tableRoute = self.data('table-route');

      $(".morrischart").empty();

      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          url: url,
          data: form.serialize(),
          dataType: 'json',
          success: function(data) {
              self.val("");

              $.ajax({
                type: 'GET',
                url: tableRoute,
                async: true,
                cache: true,
                success: function(data) {
                    $table.html(data);
                }
              })

          },
          error: function(data) {
              openSwalMessage('Erro ao Processar Requisição', data.message);
          }
      })

    });

    $('.btnStatusPaciente').click(function(e) {

        e.preventDefault();

        var self = $(this);
        var url = self.data('url');

        swal({
            title: 'Deseja prosseguir?',
            text: "Quer alterar o status deste paciente?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim'
        }).then((result) => {

            var route = url;

            if (result.value) {

                openSwalScreen();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: route,
                    data: [],
                    dataType: 'json',
                    async: true,
                    cache: true,
                    success: function(data) {
                        openSwalScreenProgress();
                    },
                    error: function(data) {
                        openSwalMessage('Erro ao Processar Requisição', data.message);
                    }
                })

            }

        })
    });

});



function gd(year, month, day) {
    return new Date(year, month, day).getTime();
}

if (document.getElementById("doughnutChart")) {

    $.ajax({
      type: 'GET',
      url: '/consults/situations/graph',
      async: true,
      cache: true,
      success: function(retorno) {

        var doughnutData = JSON.parse(retorno);

        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 45, // This is 0 for Pie charts
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            legend: {
                display: false,
                position: 'right',
                labels: {}
            }
        };

        var data = {

            datasets: [{
                data: doughnutData.data,
                backgroundColor: doughnutData.backgroundColor
            }],

            labels: doughnutData.labels,
            display: false,

        };

        var config = {
            type: 'doughnut',
            data: data,
            options: doughnutOptions
        };

        var ctx = document.getElementById("doughnutChart").getContext("2d");
        var DoughnutChart = new Chart(ctx, config);

      }
    })

}

if (document.getElementById("doughnutChart2")) {

  $.ajax({
    type: 'GET',
    url: '/consults/status/graph',
    async: true,
    cache: true,
    success: function(retorno) {

      var doughnutData = JSON.parse(retorno);

      var doughnutOptions = {
          segmentShowStroke: true,
          segmentStrokeColor: "#fff",
          segmentStrokeWidth: 2,
          percentageInnerCutout: 45, // This is 0 for Pie charts
          animationSteps: 100,
          animationEasing: "easeOutBounce",
          animateRotate: true,
          animateScale: false,
          legend: {
              display: false,
              position: 'right',
              labels: {}
          }
      };

      var data = {

          datasets: [{
              data: doughnutData.data,
              backgroundColor: doughnutData.backgroundColor
          }],

          labels: doughnutData.labels

      };

      var config = {
          type: 'doughnut',
          data: data,
          options: doughnutOptions
      };

      var ctx = document.getElementById("doughnutChart2").getContext("2d");
      var DoughnutChart = new Chart(ctx, config);

    }
  })

}

$('#endereco-cep').blur(function() {

    var self = $(this);
    var cep = self.val();
    var url = self.data('url');

    if (cep.length > 7) {

        $.ajax({
            url: url,
            data: {
                cep: cep
            },
            dataType: 'json',
            async: true,
            cache: true,
        }).done(function(data) {

            if (data.code == 101) {

                swal(
                    'Atenção!',
                    'Endereço não encontrado',
                    'error'
                )

                $("#adicionar-cep").val('1');

            } else {

                var info = data.data;

                $("#endereco-cep").val(info.cep);
                $("#endereco").val(info.logradouro);
                $("#endereco-bairro").val(info.bairro);
                $("#endereco-cidade").val(info.localidade);
                $("#endereco-uf").val(info.uf);

                $("#endereco-numero").focus();

            }

        })

    } else {

        swal(
            'Atenção!',
            'O CEP deve conter 8 digitos.',
            'info'
        )

    }

});

$("#formAlterarSenha").submit(function(e) {

    e.preventDefault();

    var self = $(this);
    var url = self.attr('action');

    $("#alterar-senha-modal").modal('hide');

    swal({
      title: 'Deseja trocar a Senha?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar'
      }).then((result) => {
      if (result.value) {

        $.ajax({
          type: 'POST',
          url: url,
          data: self.serialize(),
          async: true,
          cache: true,
          success: function(data) {

            swal({
              title: 'Ok!',
              text: data.message,
              type: 'success',
              showConfirmButton: true,
            })

          }
        })


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

  $('.bootstrap-select button').removeClass('btn-default').addClass('btn-white');
  $('.integer').mask('000.000.000.000.000,000', {reverse: true});
  $('.datemask').mask('00/00/0000', {placeholder: "__/__/____"});
  $('.phonemask').mask('(00) 00000-0000', {placeholder: "(__) _____-____"});
  $('.zipcode').mask('00000-000', {placeholder: "_____-___"});
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.money').mask('000.000.000.000.000,00', {reverse: true});

  //$("#table2 tbody tr:not(:containsIN('TACO'))").css("display", "none");



  function filterData(data, type) {
    	$(".table-search-food").bootstrapTable('load', $.grep(data, function (row) {
            return !type || row._class === type;
      }));
  }

/*
  $(".table-search-food").bootstrapTable({

      onClickRow: function (row, $element, field) {

          var elemento = $(row.checkbox);

          console.log(elemento);

          if(elemento.is(':checked')) {
              elemento.attr('checked', false);
          } else {
              elemento.attr('checked', true);
          }

      }
  });
  */
