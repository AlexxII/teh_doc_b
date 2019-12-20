<?php

use app\assets\TableBaseAsset;
use app\modules\polls\asset\PollAsset;
use app\assets\NotyAsset;
use app\assets\SortableJSAsset;

PollAsset::register($this);
TableBaseAsset::register($this);                // регистрация ресурсов таблиц datatables
NotyAsset::register($this);
SortableJSAsset::register($this);


?>

<div class="tool-task">
  <div class="" style="position: relative">
    <div class="container-fluid" style="position: relative">
      <div id="add-poll-wrap" class="hidden-xs hidden-sm">
        <a id="add-poll" class="fab-button"
           data-url="/poll/polls/create" data-back-url="/to" title="Добавить новый опрос">
          <div class="plus"></div>
        </a>
      </div>
    </div>

    <div id="delete-wrap" style="position: absolute; top: 10px; right:-60px;display: none;fill: white">
      <a id="del-wrap" class="fab-button" title="Удалить выделенный(е) опрос(ы)"
         style="cursor: pointer; background-color: red">
        <svg width="50" height="50" viewBox="-1 -1 24 24">
          <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
          <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
        </svg>
      </a>
    </div>

    <div class="container-fluid">
      <div style="padding: 10px 10px 10px 0">
        <button class="btn btn-ml" id="test-xml">XML-test</button>
      </div>
      <table id="poll-main-table" class="display no-wrap cell-border poll-table" style="width:100%">
        <thead>
        <tr>
          <th></th>
          <th data-priority="1">№ п.п.</th>
          <th data-priority="1">Код</th>
          <th data-priority="7">Наименование</th>
          <th>Период</th>
          <th></th>
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
  var pollTable;

  $(document).ready(function (e) {

    //*********************************************
    $('#test-xml').on('click', function () {
      var url = 'polls/polls/test-xml-reader';
      $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
          console.log(response.data.data);
        },
        error: function (response) {
          console.log(response.data.data);
        }
      });

    });
    //********************************************

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


    pollTable = $('#poll-main-table').DataTable({
      'processing': true,
      'responsive': true,
      'ajax': {
        'url': '/polls/polls/index'
      },
      'columns': [
        {'data': 'id'},
        {'data': 'year'},
        {'data': 'code'},
        {'data': 'title'},
        {'data': 'start_date'},
        {'data': 'end_date'},
        {'data': 'sample'},
        {'data': ''},
        {'data': ''}
      ],
      'searching': false,
      'fnRowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var date = aData.start_date;
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        $('td:nth-child(6)', nRow).html(editBtn + infoBtn + cfrmBtn);
      },
      orderFixed: [[1, 'desc']],
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
          'targets': 3,
          'render': function (data, type, row) {
            return '<span class="poll-in" data-id="' + row['id'] + '"><strong>' + row['title'] + '</strong></span>';
          }
        }, {
          'targets': 5,
          'visible': false
        }, {
          'targets': 4,
          'render': function (data, type, row) {
            var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;

            return row['start_date'].replace(pattern, '$3.$2.$1') +
              "<br> " +
              row['end_date'].replace(pattern, '$3.$2.$1');
          }
        }
      ],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: '/lib/ru.json'
      }
    });

    pollTable.on('order.dt search.dt', function () {
      pollTable.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();

    // Работа таблицы -> событие выделения и снятия выделения

    pollTable.on('select', function (e, dt, type, indexes) {
      if (type === 'row') {
        $('#delete-wrap').show();
      }
    });
    pollTable.on('deselect', function (e, dt, type, indexes) {
      if (type === 'row') {
        if (pollTable.rows({selected: true}).count() > 0) return;
        $('#delete-wrap').hide();
      }
    });

    // Работа таблицы -> перерисовка или изменение размера страницы

    pollTable.on('length.dt', function (e, settings, len) {
      pollTable.rows().deselect();
      $('#delete-wrap').hide();
    });

    pollTable.on('draw.dt', function (e, settings, len) {
      pollTable.rows().deselect();
      $('#delete-wrap').hide();
    });

    $('#delete-wrap').click(function (event) {
      event.preventDefault();
      var csrf = $('meta[name=csrf-token]').attr("content");
      var url = "/polls/polls/delete";
      if ($(this).attr('disabled')) {
        return;
      }
      jc = $.confirm({
        icon: 'fa fa-question',
        title: 'Вы уверены?',
        content: 'Вы действительно хотите удалить выделенное?',
        type: 'red',
        closeIcon: false,
        autoClose: 'cancel|9000',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
              jc.close();
              deleteProcess(url, pollTable, csrf);
            }
          },
          cancel: {
            action: function () {
              return;
            }
          }
        }
      });
    });

    pollTable.on('click', '#edit', function (e) {
      e.preventDefault();
      var data = pollTable.row($(this).parents('tr')).data();
      var url = "/polls/polls/update-poll?id=" + data['id'];
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
        title: 'Обновление сведений об опросе',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Обновить',
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
                var startDate = $('.start-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.start-date').val(startDate);
                var endDate = $('.end-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.end-date').val(endDate);
                var yText = '<span style="font-weight: 600">Успех!</span><br>Сведения об опросе обновлены';
                var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Обновить не удалось';
                sendPollFormData(url, pollTable, $form, xmlData, yText, nText);
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });

    pollTable.on('click', '#view', function (e) {
      e.preventDefault();
      var data = pollTable.row($(this).parents('tr')).data();
      var url = "/polls/polls/view-poll?id=" + data['id'];
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
        columnClass: 'xlarge',
        title: 'Подробности',
        buttons: {
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });
  });

  function deleteProcess(url, table, csrf) {
    var data = table.rows({selected: true}).data();
    var id = data[0].id;
    jc = $.confirm({
      icon: 'fa fa-cog fa-spin',
      title: 'Подождите!',
      content: 'Ваш запрос выполняется!',
      buttons: false,
      closeIcon: false,
      confirmButtonClass: 'hide'
    });
    $.ajax({
      url: url,
      method: 'post',
      dataType: "JSON",
      data: {pollId: id, _csrf: csrf}
    }).done(function (response) {
      if (response != false) {
        jc.close();
        var text = 'Опрос удален полностью!';
        var yText = '<span style="font-weight: 600">Успех!</span><br>' + text;
        initNoty(yText, 'success');
        table.ajax.reload();
      } else {
        jc.close();
        var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Удалить опрос не удалось';
        initNoty(tText, 'warning');
      }
    }).fail(function () {
      jc.close();
      var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Удалить опрос не удалось';
      initNoty(tText, 'warning');
    });
  }


</script>