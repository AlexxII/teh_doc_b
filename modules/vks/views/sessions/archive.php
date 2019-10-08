<?php

use yii\helpers\Html;
use app\assets\NotyAsset;

NotyAsset::register($this);

$this->title = 'Архив прошедших сеансов видеосвязи';

$about = "Архив сеансов видеосвязи за все время ведения данного журнала";
$add_hint = 'Добавить сеанс';
$dell_hint = 'Удалить выделенные сеансы';

?>

<div class="row">
  <div class="container-fluid" style="position: relative">
    <div id="delete" style="position: absolute; top: 70px; right:-60px;display: none">
      <a id="del-session-ex" class="fab-button" title="Удалить выделенный(е) сеанс(ы)"
         style="cursor: pointer; background-color: red">
        <svg width="50" height="50" viewBox="0 0 24 24">
          <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
          <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
        </svg>
      </a>
    </div>
    <div class="get-archive-pdf" style="position: absolute; top: 130px; right:-60px;display: none"
         data-pdf-header="Перечень прошедших сеансов видеосвязи" data-table="archive-table">
      <a class="fab-button" title="Передать в PDF" style="cursor: pointer; background-color: blue" >
        <svg width="50" height="50" viewBox="0 0 24 24" style="padding-left: 10px">
          <path d="M11.363 2c4.155 0 2.637 6 2.637 6s6-1.65 6 2.457v11.543h-16v-20h7.363zm.826-2h-10.189v24h20v-14.386c0-2.391-6.648-9.614-9.811-9.614zm4.811
           13h-2.628v3.686h.907v-1.472h1.49v-.732h-1.49v-.698h1.721v-.784zm-4.9 0h-1.599v3.686h1.599c.537 0 .961-.181
            1.262-.535.555-.658.587-2.034-.062-2.692-.298-.3-.712-.459-1.2-.459zm-.692.783h.496c.473
            0 .802.173.915.644.064.267.077.679-.021.948-.128.351-.381.528-.754.528h-.637v-2.12zm-2.74-.783h-1.668v3.686h.907v-1.277h.761c.619
            0 1.064-.277 1.224-.763.095-.291.095-.597 0-.885-.16-.484-.606-.761-1.224-.761zm-.761.732h.546c.235
            0 .467.028.576.228.067.123.067.366 0 .489-.109.199-.341.227-.576.227h-.546v-.944z"/>
        </svg>
      </a>
    </div>

    <table id="archive-table" class="display no-wrap cell-border dtable" style="width:100%">
      <thead>
      <tr>
        <th></th>
        <th>Дата</th>
        <th>Месяц</th>
        <th>Время</th>
        <th>Тип ВКС</th>
        <th>Студии</th>
        <th>Абонент</th>
        <th>Распоряжение</th>
        <th data-priority="3">Action</th>
        <th></th>
      </tr>
      </thead>
    </table>
  </div>
</div>

<script>

  // ************************* Работа таблицы **************************************

  var archTable;
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $.fn.dataTable.pipeline = function (opts) {
      var conf = $.extend({
        pages: 2,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
      }, opts);
      var cacheLower = -1;
      var cacheUpper = null;
      var cacheLastRequest = null;
      var cacheLastJson = null;
      return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;
        if (settings.clearCache) {
          ajax = true;
          settings.clearCache = false;
        }
        else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
          ajax = true;
        }
        else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
          JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
          JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
          ajax = true;
        }
        cacheLastRequest = $.extend(true, {}, request);
        if (ajax) {
          if (requestStart < cacheLower) {
            requestStart = requestStart - (requestLength * (conf.pages - 1));
            if (requestStart < 0) {
              requestStart = 0;
            }
          }
          cacheLower = requestStart;
          cacheUpper = requestStart + (requestLength * conf.pages);
          request.start = requestStart;
          request.length = requestLength * conf.pages;
          if (typeof conf.data === 'function') {
            var d = conf.data(request);
            if (d) {
              $.extend(request, d);
            }
          }
          else if ($.isPlainObject(conf.data)) {
            $.extend(request, conf.data);
          }
          settings.jqXHR = $.ajax({
            "type": conf.method,
            "url": conf.url,
            "data": request,
            "dataType": "json",
            "cache": false,
            "success": function (json) {
              cacheLastJson = $.extend(true, {}, json);
              if (cacheLower != drawStart) {
                json.data.splice(0, drawStart - cacheLower);
              }
              if (requestLength >= -1) {
                json.data.splice(requestLength, json.data.length);
              }
              drawCallback(json);
            }
          });
        }
        else {
          json = $.extend(true, {}, cacheLastJson);
          json.draw = request.draw; // Update the echo for each response
          json.data.splice(0, requestStart - cacheLower);
          json.data.splice(requestLength, json.data.length);
          drawCallback(json);
        }
      }
    };
    $.fn.dataTable.Api.register('clearPipeline()', function () {
      return this.iterator('table', function (settings) {
        settings.clearCache = true;
      });
    });

    archTable = $('#archive-table').DataTable({
      'processing': true,
      'serverSide': true,
      'responsive': true,
      'lengthMenu': [[10, 25, 50, 100, 300], [10, 25, 50, 100, 300]],
      'fnRowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        if ((aData[19] <= 0 && aData[15] != '') || (aData[20] <= 0 && aData[17] != '')) {
          $('td', nRow).css('background-color', '#fff1ef');
          $('td:eq(1)', nRow).append('<br>' + '<strong>Проверьте <i class="fa fa-clock-o" aria-hidden="true"></i></strong>');
        }
      },
      'ajax': $.fn.dataTable.pipeline({
        url: '/vks/sessions/server-side-ex?index=0',
        pages: 2 // number of pages to cache
      }),
      orderFixed: [2, 'desc'],
      rowGroup: {
        dataSrc: 2
      },
      'columnDefs': [
        {
          'orderable': false,
          'targets': -2,
          'data': null,
          'width': '45px',
          'defaultContent':
            '<a href="#" class="fa fa-edit edit" style="padding-right: 5px" title="Обновить"></a>' +
            '<a href="#" class="fa fa-info view" style="padding-right: 5px" title="Подробности"></a>'
        }, {
          'orderable': false,
          'className': 'select-checkbox',
          'targets': -1,
          'defaultContent': ''
        }, {
          'targets': 0,
          'data': null,
          'visible': false
        }, {
          'targets': 2,
          'visible': false
        },
        {
          'targets': 3,
          'width': '105px',
          'render': function (data, type, row) {
            return row[15] + ' - ' + row[16] + ' /т' + '<br>' + row[17] + ' - ' + row[18] + ' /р';
          }
        },
        {
          'targets': 6,
          'render': function (data, type, row) {
            return row[6] + '<br>' + row[14];
          }
        },
      ],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: '/lib/ru.json'
      }
    });

    $('#archive-table tbody').on('click', '.edit', function (e) {
      e.preventDefault();
      var data = archTable.row($(this).parents('tr')).data();
      var url = '/vks/sessions/update-session-ajax?id=' + data[0];
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get',
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так!</div>');
          });
        },
        contentLoaded: function (data, status, xhr) {
          this.setContentAppend('<div>' + data + '</div>');
        },
        type: 'blue',
        columnClass: 'large',
        title: 'Обновить сеанс',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Обновить',
            action: function () {
              var $form = $('#w0'),
                data = $form.data('yiiActiveForm');
              $.each(data.attributes, function () {
                this.status = 3;
              });
              $form.yiiActiveForm('validate');
              if ($('#w0').find(".has-error").length) {
                return false;
              } else {
                var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.fact-date').val(d);
                var tehStart = (moment($('#teh-start').val(), 'HH:mm'));
                var tehEnd = (moment($('#teh-end').val(), 'HH:mm'));
                var duration = moment.duration(tehEnd.diff(tehStart)).asMinutes();
                if (duration > 0) {
                  $('#vks-duration-teh').val(duration);
                } else {
                  $('#vks-duration-teh').val('');
                }
                var workStart = (moment($('#work-start').val(), 'HH:mm'));
                var workEnd = (moment($('#work-end').val(), 'HH:mm'));
                var duration = moment.duration(workEnd.diff(workStart)).asMinutes();
                var label = $(this).parent().find('label');
                if (duration > 0) {
                  $('#vks-duration-work').val(duration);
                } else {
                  $('#vks-duration-work').val('');
                }
                var yText = '<span style="font-weight: 600">Успех!</span><br>Сеанс обновлен';
                var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Обновить не удалось';
                sendFormData(url, archTable, $form, yText, nText);
                $('#delete').hide();
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });
    $('#archive-table tbody').on('click', '.view', function (e) {
      e.preventDefault();
      var data = archTable.row($(this).parents('tr')).data();
      var url = '/vks/sessions/view-session-ajax?id=' + data[0];
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

    // Работа таблицы -> событие выделения и снятия выделения

    archTable.on('select', function (e, dt, type, indexes) {
      if (type === 'row') {
        $('#delete').show();
        $('.get-archive-pdf').show();
      }
    });
    archTable.on('deselect', function (e, dt, type, indexes) {
      if (type === 'row') {
        if (archTable.rows({selected: true}).count() > 0) return;
        $('#delete').hide();
        $('.get-archive-pdf').hide();
      }
    });

    // Работа таблицы -> перерисовка или изменение размера страницы

    archTable.on('length.dt', function (e, settings, len) {
      $('#delete').hide();
      $('.get-archive-pdf').hide();

    });

    archTable.on('draw.dt', function (e, settings, len) {
      $('#delete').hide();
      $('.get-archive-pdf').hide();
    });

    //********************** Удаление записей ***********************************

    $('#delete').click(function (event) {
      event.preventDefault();
      var csrf = $('meta[name=csrf-token]').attr("content");
      var url = '/vks/sessions/delete';
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
              deleteProcess(url, archTable, csrf)
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
  });

</script>
