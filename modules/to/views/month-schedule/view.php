<?php

use yii\helpers\Html;

?>

<style>
  td .fa {
    font-size: 25px;
  }
  #main-table tbody td {
    font-size: 12px;
  }
  #main-table tr {
    font-size: 12px;
  }

</style>


<table id="view-schedule-tbl" class="display no-wrap cell-border" style="width:100%">
  <thead>
  <tr>
    <th></th>
    <th data-priority="1">№</th>
    <th data-priority="2">Наименование</th>
    <th>s/n</th>
    <th>ПАК</th>
    <th data-priority="2">Вид ТО</th>
    <th data-priority="2">Дата проведения</th>
    <th data-priority="2">Ответственный за проведение</th>
    <th data-priority="2">Ответственный за контроль</th>
    <th data-priority="2"></th>
  </tr>
  </thead>
</table>


<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function () {

    var table = $('#view-schedule-tbl').DataTable({
      'processing': true,
      'ajax': {
        'url': '/to/month-schedule/equipment'
      },
      'columns': [
        {'defaultContent': 'id'},
        {'defaultContent': ''},
        {'data': 'name'},
        {'data': 'eq_serial'},
        {'data': 'parent'},
        {'defaultContent': ''},
        {'defaultContent': ''},
        {'defaultContent': ''},
        {'defaultContent': ''}
      ],
      dom: 'Bfrtip',
      buttons: [
        'selectAll',
        'selectNone'
      ],
      paging: false,
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      rowGroup: {
        dataSrc: 'parent'
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        $('select.to-list', nRow).attr('id', aData.id);
      },
      columnDefs: [
        {
          'targets': -2,                    // предпоследний столбец
          'orderable': false,
          'data': null,
          'width': '70px',
          'defaultContent':
            '<a href="#" id="edit" class="fa fa-edit" style="padding-right: 5px" title="Обновить"></a>' +
            '<a href="#" id="view" class="fa fa-info" title="Подробности" style="padding-right: 5px"></a>'
        }, {
          'targets': -1,                    // последний столбец
          'orderable': false,
          'className': 'select-checkbox',
          'defaultContent': ''
        }, {
          'targets': 0,
          'visible': false
        }, {
          'targets': 4,
          'visible': false
        },
      ],
      responsive: true,
      language: {
        url: '/lib/ru.json',
        'buttons': {
          'selectAll': 'Выделить все',
          'selectNone': 'Снять выделение'
        }
      }
    });
    table.on('order.dt search.dt', function () {
      table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    $('#schedule-create-tbl')
      .on('processing.dt', function (e, settings, processing) {
        $('#processingIndicator').css('display', processing ? 'block' : 'none');

      }).dataTable();
  });



</script>

