  'use strict';
 $(document).ready(function() {
$('#example-1').Tabledit({

    editButton: false,
    deleteButton: false,
    hideIdentifier: true,
    columns: {
        identifier: [0, 'id'],
        editable: [[1, 'First Name'], [2, 'Last Name']]
    }
});
    $('#example-2').Tabledit({

        columns: {

          identifier: [0, 'id'],

          editable: [[1, 'First Name'], [2, 'Last Name']]

      }

  });
});
function add_row()
{
    var table = document.getElementById("example-1");
    var t1=(table.rows.length);
    var row = table.insertRow(t1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);

    cell1.className='abc';
    cell2.className='abc';

     $('<span class="tabledit-span" >Informe a quantidade</span><input class="tabledit-input form-control input-sm" type="text" name="First" value="undefined" placeholder="Informe a quantidade">').appendTo(cell1);
     $('<span class="tabledit-span" ></span><select class="tabledit-input form-control input-sm" name="Nickname"  disabled="" ><option value="Unidade">Unidade</option><option value="Serviço">Serviço</option><option value="Peça">Peça</option><option value="Kilo">Kilo</option><option value="Litro">Litro</option><option value="Metro">Metro</option><option value="Caixa">Caixa</option></select>').appendTo(cell2);
     $('<span class="tabledit-span" ></span><input class="tabledit-input form-control input-sm" type="text" name="Last" value="undefined" placeholder="Descreva a solicitação do Item"').appendTo(cell3);

};
