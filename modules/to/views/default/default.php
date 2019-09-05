<?php

use yii\helpers\Html;
use app\assets\TableBaseAsset;
use app\modules\to\assets\ToAsset;

ToAsset::register($this);        // регистрация ресурсов модуля
TableBaseAsset::register($this);        // регистрация ресурсов таблиц datatables

$this->title = "Графики ТО";

?>

<div class="tool-task">

  <div class="row">
    <div class="container-fluid" style="position: relative">
      <div id="add-scheduler-wrap">
        <a id="add-scheduler" class="fab-button ex-click"
           data-url="/to/month-schedule/archive" data-back-url="/to" title="Добавить график ТО">
          <div class="plus"></div>
        </a>
      </div>
    </div>

    <div class="container-fluid">
      <table id="to-mscheduler-table" class="display no-wrap cell-border" style="width:100%">
        <thead>
        <tr>
          <th></th>
          <th data-priority="1">№ п.п.</th>
          <th data-priority="1">Месяц</th>
          <th data-priority="7">Отметки</th>
          <th>Год</th>
          <th>Объем ТО</th>
          <th>Ответственный за проведение</th>
          <th>Ответственный за контроль</th>
          <th data-priority="3">Action</th>
          <th></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('#push-it').removeClass('hidden');
    $('#app-control').removeClass('hidden');

    initLeftMenu('/to/menu/left-side');
    initAppConfig('/to/menu/app-config');

    var monthNames = [
      'Январь',
      'Февраль',
      'Март',
      'Апрель',
      'Май',
      'Июнь',
      'Июль',
      'Август',
      'Сентябрь',
      'Октябрь',
      'Ноябрь',
      'Декабрь'
    ];

    // ************************* Работа таблицы **************************************

    table = $('#to-mscheduler-table').DataTable({
      "processing": true,
      "responsive": true,
      "ajax": {
        'url': '/to/schedule/month-schedules'
      },
      "columns": [
        { "data": "id" },
        { "data": "id" },
        { "data": "plan_date" },
        { "data": "checkmark" },
        { "data": "plan_date" },
        { "data": "to_type" },
        { "data": "admins" },
        { "data": "auditors" },
        { "data": "" },
        { "data": "" }
      ],
      "searching": false,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var date = aData.plan_date;
        // var today = new Date();
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        var dDate = new Date(date.replace(pattern, '$3-$2-$1'));
        $('td:nth-child(2)', nRow).text(monthNames[dDate.getMonth()]);
      },
      orderFixed: [[4, 'desc']],
      order: [[1, 'desc']],
      rowGroup: {
        dataSrc: 'year',
      },
      "columnDefs": [
        {
          "targets": -2,                    // предпоследний столбец
          "orderable": false,
          "data": null,
          "width": '70px',
          "defaultContent":
            "<a href='#' id='edit' class='fa fa-edit' style='padding-right: 5px' title='Обновить'></a>" +
            "<a href='#' id='view' class='fa fa-info ' title='Подробности' style='padding-right: 5px'></a>"
        }, {
          'targets': -1,                    // последний столбец
          'orderable': false,
          'className': 'select-checkbox',
          'defaultContent': ''
        }, {
          'targets': 0,
          'data': null,
          'visible': false
        }, {
          'targets': 1,
          'data': null
        }, {
          'targets': 2,
          'render': function (data) {
            return moment(data).format('MMMM');
          }
        }, {
          'targets': 3,
          'render': function (data) {
            if (data.length == 1) {
              if (data == '1') {
                return '<strong>ТО проведено</strong>';
              } else {
                return '<strong>ТО не проведено</strong>';
              }
            } else {
              return '<strong>Проведено не полность</strong>';
            }
          }
        }
      ],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: "/lib/ru.json"
      }
    });
    table.on('order.dt search.dt', function () {
      table.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

  });


</script>