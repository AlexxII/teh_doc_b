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
  <div class="">
    <div class="container-fluid" style="margin-bottom: 20px">
      <a href="#" class="btn btn-sm btn-danger"
         data-toggle="tooltip" data-placement="top" title="<?= $dell_hint ?>" id="delete" disabled="true">Удалить</a>
    </div>
  </div>

  <div class="container-fluid">
    <?php

    echo '
        <table id="main-table" class="display no-wrap cell-border" style="width:100%">
          <thead>
            <tr>
              <th></th>
              <th >Дата</th>
              <th >Месяц</th>
              <th >Время</th>
              <th >Тип ВКС</th>
              <th >Студии</th>
              <th >Абонент</th>
              <th >Распоряжение</th>
              <th data-priority="3">Action</th>
              <th></th>
            </tr>
          </thead>
        </table>';
    ?>
  </div>

  <input class="csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" style="display: none">
</div>
<br>


<script>

  // ************************* Работа таблицы **************************************

  var table;
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

    table = $('#main-table').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        if ((aData[19] <= 0 && aData[15] != '') || (aData[20] <= 0 && aData[17] != '')) {
          $('td', nRow).css('background-color', '#fff1ef');
          $('td:eq(1)', nRow).append('<br>' + '<strong>Проверьте <i class="fa fa-clock-o" aria-hidden="true"></i></strong>');
        }
      },
      "ajax": $.fn.dataTable.pipeline({
        url: '/vks/sessions/server-side-ex?index=0',
        pages: 2 // number of pages to cache
      }),
      orderFixed: [2, 'desc'],
      rowGroup: {
        dataSrc: 2
      },
      "columnDefs": [
        {
          "orderable": false,
          "targets": -2,
          "data": null,
          "width": '45px',
          "defaultContent":
            "<a href='#' class='fa fa-edit edit' style='padding-right: 5px' title='Обновить'></a>" +
            "<a href='#' class='fa fa-info view' style='padding-right: 5px' title='Подробности'></a>"
        }, {
          "orderable": false,
          "className": 'select-checkbox',
          "targets": -1,
          "defaultContent": ""
        }, {
          "targets": 0,
          "data": null,
          "visible": false
        }, {
          "targets": 2,
          "visible": false
        },
        {
          "targets": 3,
          "width": '105px',
          "render": function (data, type, row) {
            return row[15] + ' - ' + row[16] + ' /т' + "<br> " + row[17] + ' - ' + row[18] + ' /р';
          }
        },
        {
          "targets": 6,
          "render": function (data, type, row) {
            return row[6] + "<br> " + row[14];
          }
        },
      ],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: "/lib/ru.json"
      }
    });

    $('#main-table tbody').on('click', '.edit', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var url = "/vks/sessions/update-session-ajax?id=" + data[0];
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get',
          }).done(function (response) {
            // console.log(response);
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
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function () {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
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
                sendFormData(url, table, $form, yText, nText);
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });
    $('#main-table tbody').on('click', '.view', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var url = "/vks/sessions/view-session-ajax?id=" + data[0];
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get'
          }).done(function (response) {
            // console.log(response);
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

    table = $('#main-table').DataTable();
    table.on('select', function (e, dt, type, indexes) {
      if (type === 'row') {
        $('#delete').removeAttr('disabled');
      }
    });
    table.on('deselect', function (e, dt, type, indexes) {
      if (type === 'row') {
        if (table.rows({selected: true}).count() > 0) return;
        $('#delete').attr('disabled', true);
      }
    });

    //********************** Удаление записей ***********************************

    $('#delete').click(function (event) {
      event.preventDefault();
      var url = "/vks/sessions/delete";
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
              deleteProcess(url)
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

  function deleteProcess(url) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    var data = table.rows({selected: true}).data();
    var ar = [];
    var count = data.length;
    for (var i = 0; i < count; i++) {
      ar[i] = data[i][0];
    }
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
      data: {jsonData: ar, _csrf: csrf},
    }).done(function (response) {
      if (response != false) {
        jc.close();
        jc = $.confirm({
          icon: 'fa fa-thumbs-up',
          title: 'Успех!',
          content: 'Ваш запрос выполнен.',
          type: 'green',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-success',
              action: function () {
                table.clearPipeline().draw();
                $('#delete').attr('disabled', true);
              }
            }
          }
        });
      } else {
        jc.close();
        jc = $.confirm({
          icon: 'fa fa-exclamation-triangle',
          title: 'Неудача!',
          content: 'Запрос не выполнен. Что-то пошло не так.',
          type: 'red',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-danger',
              action: function () {
              }
            }
          }
        });
      }
    }).fail(function () {
      jc.close();
      jc = $.confirm({
        icon: 'fa fa-exclamation-triangle',
        title: 'Неудача!',
        content: 'Запрос не выполнен. Что-то пошло не так.',
        type: 'red',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|4000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
            }
          }
        }
      });
    });
  }


</script>
