<?php

use app\assets\TableBaseAsset;
use app\modules\polls\asset\PollAsset;

PollAsset::register($this);
TableBaseAsset::register($this);                // регистрация ресурсов таблиц datatables

?>

<div class="row">
  <div id="result" style="padding-bottom: 20px">
  </div>
</div>

<div class="tool-task">
  <div class="" style="position: relative">
    <div class="container-fluid" style="position: relative">
      <div id="add-poll-wrap" class="hidden-xs hidden-sm">
        <a id="add-poll" class="fab-button ex-click"
           data-url="/poll/polls/create" data-back-url="/to" title="Добавить новый опрос">
          <div class="plus"></div>
        </a>
      </div>
    </div>

    <div id="delete-wrap" style="position: absolute; top: 10px; right:-60px;display: none;fill: white">
      <a id="del-session-ex" class="fab-button" title="Удалить выделенный(е) график(и)"
         style="cursor: pointer; background-color: red">
        <svg width="50" height="50" viewBox="-1 -1 24 24">
          <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
          <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
        </svg>
      </a>
    </div>

    <div class="container-fluid">
      <table id="poll-main-table" class="display no-wrap cell-border toTable" style="width:100%">
        <thead>
        <tr>
          <th></th>
          <th data-priority="1">№ п.п.</th>
          <th data-priority="1">Код</th>
          <th data-priority="7">Наименование</th>
          <th>Год</th>
          <th>Период</th>
          <th>Выборка</th>
          <th data-priority="3">Action</th>
          <th></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<script>

  $(document).ready(function (e) {

    initLeftMenu('/polls/menu/left-side');
    initAppConfig('/polls/menu/app-config');

    controlCallback = function () {
      return;
    };
    // процедуры возврата из второстепенного контента
    returnCallback = function () {
      pollTable.ajax.reload();
    };

    // ************************* Работа таблицы **************************************

    var editBtn = '<a href="#" id="edit" class="fa fa-edit" style="padding-right: 5px" title="Обновить"></a>';
    var infoBtn = '<a href="#" id="view" class="fa fa-info" ' +
      ' title="Подробности" data-url="/to/month-schedule/view" data-back-url="/to" style="padding-right: 5px"></a>';
    var cfrmBtn = '<a href="#" id="perform" class="fa fa-calendar-check-o" ' +
      'title="Подтвердить выполнение" style="padding-right: 5px"></a>';

    var pollTable;

    pollTable = $('#poll-main-table').DataTable({
      "processing": true,
      "responsive": true,
      "ajax": {
        'url': '/polls/polls/index'
      },
      "columns": [
        {"data": "id"},
        {"data": "plan_date"},
        {"data": "checkmark"},
        {"data": "plan_date"},
        {"data": "to_type"},
        {"data": "admins"},
        {"data": "auditors"},
        {"data": ""},
        {"data": ""}
      ],
      "searching": false,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var date = aData.plan_date;
        // var today = new Date();
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        var dDate = new Date(date.replace(pattern, '$3-$2-$1'));
        var month = monthNames[dDate.getMonth()];
        $('td:nth-child(2)', nRow).text(month);
        aData['monthText'] = month;
        aData['monthVal'] = ("0" + (dDate.getMonth() + 1)).slice(-2);
        // $('td:nth-child(7)', nRow).html(editBtn + infoBtn + cfrmBtn);
        if (aData.checkmark == 0) {
          $('td:nth-child(7)', nRow).html(editBtn + infoBtn + cfrmBtn);
          $('td:nth-child(3)', nRow).css({color: 'red'});
        } else {
          if (aData.checkmark.length > 1) {
            $('td:nth-child(7)', nRow).html(infoBtn + cfrmBtn);
            $('td:nth-child(3)', nRow).css({color: 'blue'});
          } else {
            $('td:nth-child(7)', nRow).html(infoBtn);
            $('td:nth-child(3)', nRow).css({color: 'green'});
          }
        }
      },
      orderFixed: [[4, 'desc']],
      order: [[1, 'desc']],
      rowGroup: {
        dataSrc: 'year'
      },
      'columnDefs': [
        {
          'targets': -2,                    // предпоследний столбец
          'orderable': false,
          'data': null,
          'width': '70px',
          'defaultContent': ''
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
        }, {
          'targets': 4,
          'data': null,
          'visible': false
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

    pollTable.on('order.dt search.dt', function () {
      pollTable.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();


    $('#add-poll').click(function (event) {
      event.preventDefault();
      var url = "/polls/polls/add-new-poll";
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get'
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так!</div>');
          });
        },
        contentLoaded: function (data, status, xhr) {
          this.setContentAppend('<div>' + data + '</div>');
        },
        type: 'blue',
        columnClass: 'large',
        title: 'Добавить опрос',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Добавить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function () {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
                return false;
              } else {
                var startDate = $('#polls-start_date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('#polls-start_date').val(startDate);
                var endDate = $('#polls-end_date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('#polls-end_date').val(endDate);
                var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;
                var year = startDate.replace(pattern, '$1');
                var yText = '<span style="font-weight: 600">Успех!</span><br>Новый опрос добавлен';
                var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить опрос не удалось';
                sendPollFormData(url, pollTable, $form, yText, nText);
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });
  });

</script>