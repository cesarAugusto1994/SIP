!function(e){var t={};function a(o){if(t[o])return t[o].exports;var n=t[o]={i:o,l:!1,exports:{}};return e[o].call(n.exports,n,n.exports,a),n.l=!0,n.exports}a.m=e,a.c=t,a.d=function(e,t,o){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(a.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)a.d(o,n,function(t){return e[t]}.bind(null,n));return o},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="/",a(a.s=40)}({40:function(e,t,a){e.exports=a(41)},41:function(e,t){var a;function o(e,t,a){return t in e?Object.defineProperty(e,t,{value:a,enumerable:!0,configurable:!0,writable:!0}):e[t]=a,e}$(".select2").select2({width:"100%",placeholder:"Selecione"}),$(".select-client").select2({ajax:{type:"GET",dataType:"json",delay:250,url:$("#input-search-clientes").val(),data:function(e){return{search:e.term,type:"public"}},processResults:function(e){return{results:$.map(e,function(e){return{text:e.name,id:e.id}})}}},cache:!0,placeholder:"Procurar cliente",minimumInputLength:1}),$(".select-employees").select2((o(a={placeholder:"Procurar Funcionario",ajax:{type:"GET",dataType:"json",delay:250,url:$("#input-search-employees").val(),data:function(e){return{search:e.term,type:"public"}},processResults:function(e,t){return{results:$.map(e,function(e){return{text:e.name+" - "+e.company+" - "+e.document,id:e.id}})}}},cache:!0},"placeholder","Procurar Funcionario"),o(a,"minimumInputLength",3),a)),$(".select-client-occuparions").select2({ajax:{type:"GET",dataType:"json",delay:250,url:$(".select-client-occuparions").data("url"),data:function(e){return{search:e.term,type:"public"}},processResults:function(e){return{results:$.map(e,function(e){return{text:e.name,id:e.id}})}}},cache:!0,placeholder:"Procurar um cliente",minimumInputLength:1}),Array.prototype.slice.call(document.querySelectorAll(".js-switch")).forEach(function(e){new Switchery(e,{color:"#93BE52",jackColor:"#fff",size:"small"})}),$(".inputDate").mask("00/00/0000"),$(".inputDateTime").mask("00/00/0000 00:00",{placeholder:"__/__/____ __:__"}),$(".inputCep").mask("00000-000"),$(".inputPhone").mask("(00)00000-0000"),$(".inputCpf").mask("000.000.000-00",{reverse:!0}),$(".inputCnpj").mask("00.000.000/0000-00",{reverse:!0}),$(".inputMoney").mask("000.000.000.000.000,00",{reverse:!0}),$(".inputDate").datepicker({language:"pt-BR",format:"dd/mm/yyyy",todayBtn:"linked",clearBtn:!0,calendarWeeks:!0,autoclose:!0,todayHighlight:!0,toggleActive:!0}),$(".inputCep").blur(function(){var e=$(this).data("cep"),t=$(this).val();t&&(window.swal({title:"Em progresso...",text:"Aguarde enquanto a requisição é processada.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),$.ajax({type:"GET",async:!0,url:e+"?search="+t,success:function(e){e.success||Swal.fire({type:"error",title:"Oops...",text:e.message});var t=e.data.response,a=e.data.coordenadas;$("#street").val(t.logradouro),$("#district").val(t.bairro),$("#city").val(t.localidade),$("#state").val(t.uf),a&&($("#long").val(a.lng),$("#lat").val(a.lat)),swal.close()},done:function(){swal.close()}}))}),$(".btnRemoveItem").click(function(e){var t=$(this);swal({title:"Remover este registro?",text:"Não será possível recuperá-lo!",showCancelButton:!0,confirmButtonColor:"#0ac282",cancelButtonColor:"#D46A6A",confirmButtonText:"Sim, Remover",cancelButtonText:"Não"}).then(function(a){a.value&&(e.preventDefault(),window.swal({title:"Em progresso...",text:"Aguarde enquanto a requisição é processada.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:t.data("route"),type:"POST",dataType:"json",data:{_method:"DELETE"}}).done(function(e){swal.close(),e.success?(t.parents(".list-phones").remove(),t.parents("tr").remove(),t.parents(".cardMessageTypes").remove(),t.parents(".cardRemove").remove(),t.parents(".mediaFile").remove(),m(e.message,"inverse")):m(e.message,"danger")}))})}),$(".btnRemoveItemToBack").click(function(e){var t=$(this);swal({title:"Remover registro?",text:"Deseja remover este registro?",showCancelButton:!0,confirmButtonColor:"#0ac282",cancelButtonColor:"#D46A6A",confirmButtonText:"Sim, Deletar",cancelButtonText:"Não"}).then(function(a){a.value&&(e.preventDefault(),window.swal({title:"Em progresso...",text:"Aguarde enquanto a requisição é processada.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:t.data("route"),type:"POST",dataType:"json",data:{_method:"DELETE"}}).done(function(e){swal.close(),e.success?(m(e.message,"inverse"),window.location.href=e.route):m(e.message,"danger")}))})}),$(".btnRemoveFolder").click(function(e){var t=$(this);swal({title:"Deseja remover esta Pasta?",text:"Não será possível recuperá-lo!",showCancelButton:!0,confirmButtonColor:"#0ac282",cancelButtonColor:"#D46A6A",confirmButtonText:"Sim, Deletar",cancelButtonText:"Não"}).then(function(a){a.value&&(e.preventDefault(),window.swal({title:"Em progresso...",text:"Aguarde enquanto a requisição é processada.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:t.data("route"),type:"POST",dataType:"json",data:{_method:"DELETE"}}).done(function(e){swal.close(),e.success?(m(e.message,"inverse"),window.location.href=e.route):m(e.message,"danger")}))})}),$(".btnLogout").click(function(){swal({title:"Finalizar Sessão?",type:"question",showCancelButton:!0,confirmButtonColor:"#0ac282",cancelButtonColor:"#D46A6A",confirmButtonText:"Sim, Finalizar",cancelButtonText:"Não"}).then(function(e){e.value&&(document.getElementById("logout-form").submit(),swal({title:"Até logo!",text:"Sua sessão será finalizada.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}))})}),$(".btnRedirectSoc").click(function(){var e=$("#usu").val();$("#senha").val(),$("#empsoc").val();usu&&e&&e?$("#formularioLoginSoc").submit():Swal.fire({type:"error",title:"Falha ao logar no SOC",text:"Informe as suas credenciais SOC no seu perfil"})}),$(".checkboxPermissions").change(function(){var e=$(this),t=e[0].checked,a=e.data("route-grant");!0!==t&&(a=e.data("route-revoke")),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:a,type:"POST",dataType:"json",data:{}}).done(function(e){e.success?swal.mixin({toast:!0,position:"top-center",showConfirmButton:!1,timer:3e3})({type:"success",title:e.message}):Swal.fire({type:"error",title:"Oops...",text:e.message})})}),$(".changeUserPermission").change(function(){var e=$(this),t=(e[0].checked,e.data("route"));$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:t,type:"POST",dataType:"json",data:{}}).done(function(e){e.success?swal.mixin({toast:!0,position:"top-center",showConfirmButton:!1,timer:3e3})({type:"success",title:e.message}):Swal.fire({type:"error",title:"Oops...",text:e.message})})});var n=$(".select-client-addresses"),r=$("#select-address");n.change(function(){var e=$(this),t=e.data("search-addresses"),a=e.val();$.ajax({type:"GET",url:t+"?param="+a,async:!0,success:function(e){var t="";r.html(""),r.trigger("change"),$.each(e.data,function(e,a){var o=(a.description?a.description:"")+", "+(a.street?a.street:"")+", "+(a.number?a.number:"")+" - "+(a.district?a.district:"")+", "+(a.city?a.city:"")+" - "+(a.zip?a.zip:"");t+="<option value="+a.uuid+">"+o+"</option>"}),r.append(t),r.trigger("change")}})});$(".select-client-employees"),$("#select-employee");$(document).on("change",".select-client-employees",function(){var e=$(this),t=e.data("search-employees"),a=$(e.data("target")),o=e.val();$.ajax({type:"GET",url:t+"?param="+o,async:!0,success:function(e){data=e.data,data=$.map(data,function(e){if(e)return{id:e.uuid,text:e.name}}),a.html(""),a.trigger("change"),a.select2({data:data})}})});$(".select-client-emails");var s=$("#select-email");$(document).on("change",".select-client-emails",function(){var e=$(this),t=e.data("search-emails"),a=e.val();$.ajax({type:"GET",url:t+"?param="+a,async:!0,success:function(e){data=e.data,data=$.map(data,function(e){if(e)return{id:e.email,text:e.email}}),s.html(""),s.trigger("change"),s.select2({data:data})}})});var i=$(".select-occupations"),c=$("#occupation");i.change(function(){swal({title:"Aguarde um instante.",text:"Carregando os dados...",type:"info",showConfirmButton:!1,allowOutsideClick:!1});var e=$(this),t=e.data("search-occupations"),a=e.val();$.ajax({type:"GET",url:t+"?param="+a,async:!0,success:function(e){var t="<option value=''>Selecione um cargo</option>";c.html(""),$.each(e.data,function(e,a){t+="<option value="+a.uuid+">"+a.name+"</option>"}),c.append(t),swal.close()}})});var l=$(".select-client-documents"),u=$("#table-documents");function m(e,t){$.growl({message:e},{type:t,allow_dismiss:!1,label:"Cancel",className:"btn-xs btn-inverse",placement:{from:"bottom",align:"center"},delay:5e3,animate:{enter:"animated fadeInRight",exit:"animated fadeOutRight"},offset:{x:30,y:30}})}l.change(function(){var e=$(this),t=e.data("search-documents"),a=e.val();swal({title:"Carregando",text:"Procurando documentos do Cliente.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),$.ajax({type:"GET",url:t+"?param="+a,async:!0,success:function(e){u.html(""),swal.close();var t="";$.each(e.data,function(e,a){t+="<tr>",t+="<td><input class='js-switch2 select-item' type='checkbox' name='documents[]' value='"+a.uuid+"'/></td>",t+="<td>"+a.id+"</td>",t+="<td>"+a.type+"</td>",t+="<td>"+a.employee+"</td>",t+="<td>"+a.reference+"</td>",t+="<td>"+a.status+"</td>",t+="</tr>"}),u.append(t),Array.prototype.slice.call(document.querySelectorAll(".js-switch2")).forEach(function(e){new Switchery(e,{color:"#93BE52",jackColor:"#fff"})}),$("#select-all").is(":checked")&&$("#select-all").trigger("click")}})}),$("#select-department").change(function(){$(this);var e=$("#select-department").select2("val");e="id="+e,$("#select-user").html(""),$.ajax({type:"GET",url:$("#select-department").data("route"),dataType:"html",data:e}).done(function(e){e=JSON.parse(e),e=$.map(e.data,function(e){if(e)return{id:e.id,text:e.name}}),$("#select-user").select2({data:e}),$("#select-user").trigger("change")})});var d=function(e){return e.replace(/\D/g,"").length<=11?"000.000.000-009":"00.000.000/0000-00"},p={onKeyPress:function(e,t,a,o){a.mask(d.apply({},arguments),o)}};$(function(){$(":input[name=document]").mask(d,p),$(".inputDocument").mask(d,p)}),$("#daterange").daterangepicker({showDropdowns:!0,autoApply:!0,ranges:{Hoje:[moment(),moment()],Ontem:[moment().subtract(1,"days"),moment().subtract(1,"days")],"Últimos 7 dias":[moment().subtract(6,"days"),moment()],"Últimos 30 dias":[moment().subtract(29,"days"),moment()],"Este Mês":[moment().startOf("month"),moment().endOf("month")],"Mês Anterior":[moment().subtract(1,"month").startOf("month"),moment().subtract(1,"month").endOf("month")]},locale:{format:"DD/MM/YYYY",separator:" - ",applyLabel:"Applicar",cancelLabel:"Cancelar",fromLabel:"De",toLabel:"Até",customRangeLabel:"Editar",weekLabel:"W",daysOfWeek:["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],firstDay:1}},function(e,t,a){$("#start").val(e.format("DD/MM/YYYY")),$("#end").val(t.format("DD/MM/YYYY"))});var f=$(".formValidation").parsley();function h(e){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},type:"POST",url:e.update,data:{id:e.id,uuid:e.uuid,title:e.title,description:e.description,start:e.start.format("DD/MM/YYYY HH:mm"),end:e.end.format("DD/MM/YYYY HH:mm"),_method:"PUT"},dataType:"json",success:function(e){},error:function(e){}})}f&&f.on("form:submit",function(e){window.swal({title:"Em progresso...",text:"Aguarde enquanto os dados são salvos.",type:"success",showConfirmButton:!1,allowOutsideClick:!1})}),$("#calendar").fullCalendar({height:380,contentHeight:590,views:{listDay:{buttonText:"list day",titleFormat:"dddd, DD MMMM YYYY",columnFormat:"",timeFormat:"HH:mm"},listWeek:{buttonText:"list week",columnFormat:"ddd D",timeFormat:"HH:mm"},listMonth:{buttonText:"list month",titleFormat:"MMMM YYYY",timeFormat:"HH:mm"},month:{buttonText:"month",titleFormat:"MMMM YYYY",columnFormat:"ddd",timeFormat:"HH:mm"},agendaWeek:{buttonText:"agendaWeek",columnFormat:"ddd D",timeFormat:"HH:mm"},agendaDay:{buttonText:"agendaDay",titleFormat:"dddd, DD MMMM YYYY",columnFormat:"",timeFormat:"HH:mm"}},lang:"pt-br",defaultView:"month",eventBorderColor:"#de1f1f",eventColor:"#AC1E23",slotLabelFormat:"HH:mm",eventLimitText:"Compromissos",borderColor:"#FC6180",backgroundColor:"#FC6180",droppable:!0,businessHours:!0,editable:!0,allDaySlot:!0,eventLimit:!1,minTime:"06:00:00",maxTime:"22:00:00",header:{left:"prev,next,today",center:"title",right:"month,agendaWeek,agendaDay,listMonth,listWeek,listDay"},navLinks:!0,selectable:!0,selectHelper:!0,select:function(e,t,a,o){$(".calendar").fullCalendar("getView");$("#sechedule-modal").modal("show"),$("#start").val(e.format("DD/MM/YYYY HH:mm")),$("#end").val(t.format("DD/MM/YYYY HH:mm"))},eventClick:function(e,t,a){window.swal({title:"Em progresso...",text:"Aguarde enquanto carregamos o compromisso.",type:"success",showConfirmButton:!1,allowOutsideClick:!1}),window.location.href=e.route},dayClick:function(e,t,a){t.preventDefault(),setTimeout(function(){$("#formConsultaModal").prop("action",$("#consultas-store").val())},100)},events:$("#schedule-json").val(),eventDrop:function(e,t,a){h(e)},eventResize:function(e,t,a){h(e)},eventRender:function(e,t){$(t).tooltip({title:e.title})},ignoreTimezone:!1,allDayText:"Dia Inteiro",monthNames:["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],monthNamesShort:["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],dayNames:["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sabado"],dayNamesShort:["Dom","Seg","Ter","Qua","Qui","Sex","Sab"],axisFormat:"HH:mm",buttonText:{prev:"<",next:">",prevYear:"Ano anterior",nextYear:"Proximo ano",today:"Hoje",month:"Mês",week:"Semana",day:"Dia",listMonth:"Lista Mensal",listWeek:"Lista Semanal",listDay:"Lista Diária"}})}});