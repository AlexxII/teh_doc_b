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


    // ************************* Работа таблицы **************************************

    table = $('#to-mscheduler-table').DataTable({
      "processing": true,
      "responsive": true,
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
      "ajax": {
        'url': '/to/schedule/month-schedules'
      },
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var today = new Date();
        console.log(nRow);
        console.log(aData);
      },
      "columnDefs": [
        {
          "orderable": false,
          "targets": -2,
          "data": null,
          "width": '70px',
          "defaultContent":
            "<a href='#' id='edit' class='fa fa-edit' style='padding-right: 5px' title='Обновить'></a>" +
            "<a href='#' id='view' class='fa fa-info ' title='Подробности' style='padding-right: 5px'></a>"
        }, {
          "orderable": false,
          "className": 'select-checkbox',
          "targets": -1,
          "defaultContent": ""
        },
        {
          "targets": 0,
          "data": null,
          "visible": false
        }
/*
        {
          "targets": 3,
          "width": '80px',
          "render": function (data, type, row) {
            if (row[3] == '') {
              return '<strong>' + row[4] + '</strong>' + ' / <strong>Р</strong>';
            } else if (row[4] == '') {
              return '<strong>' + row[3] + '</strong>' + ' / <strong>Т</strong>';
            } else {
              return '<strong>' + row[3] + '</strong>' +
                ' / <strong>Т</strong>' + "<br> " +
                '<strong>' + row[4] + '</strong>' + ' / <strong>Р</strong>';
            }
          }
        },
*/
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