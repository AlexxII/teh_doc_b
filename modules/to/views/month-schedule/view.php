<?php

use yii\helpers\Html;

?>


<table id="view-schedule-tbl" data-id="<?= $scheduleId?>" class="display no-wrap cell-border" style="width:100%">
  <thead>
  <tr>
    <th></th>
    <th data-priority="1">№</th>
    <th data-priority="2">Наименование</th>
    <th>s/n</th>
    <th>ПАК</th>
    <th data-priority="2">Вид ТО</th>
    <th data-priority="2">Дата проведения</th>
    <th data-priority="2">Дата проведения</th>
    <th data-priority="2">Ответственный за проведение</th>
    <th data-priority="2">Ответственный за контроль</th>
  </tr>
  </thead>
</table>


<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function () {
    var id = $('#view-schedule-tbl').data('id');
    var table = $('#view-schedule-tbl').DataTable({
      'processing': true,
      'ajax': {
        'url': '/to/month-schedule/schedule-view?id=' + id
      },
      'columns': [
        {'defaultContent': ''},
        {'defaultContent': ''},
        {'data': 'equipment'},
        {'data': 's/n'},
        {'data': 'parent'},
        {'data': 'toType'},
        {'data': 'plan_date'},
        {'data': 'fact_date'},
        {'data': 'admin'},
        {'data': 'auditor'}
      ],
      paging: false,
      rowGroup: {
        dataSrc: 'parent'
      },
      fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        $('select.to-list', nRow).attr('id', aData.id);
        console.log(aData);
        var pDate = aData.plan_date;
        var fDate = aData.fact_date;
        var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;
        if (pDate != null) {
          $('td:nth-child(5)', nRow).text(pDate.replace(pattern, '$3.$2.$1'));
        } else {
          $('td:nth-child(5)', nRow).text('-');
        }
        if (fDate != null) {
          $('td:nth-child(6)', nRow).text(fDate.replace(pattern, '$3.$2.$1'));
        } else {
          $('td:nth-child(6)', nRow).text('-');
        }
      },
      columnDefs: [
        {
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

