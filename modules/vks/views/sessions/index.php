<?php

use yii\helpers\Html;
use app\assets\AirDatepickerAsset;

$this->title = 'Журнал предстоящих сеансов видеосвязи';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = "Журнал";

$about = "Журнал предстоящих сеансов видеосвязи";
$add_hint = 'Добавить предстоящий сеанс';
$dell_hint = 'Удалить выделенные сеансы';
$date_about = "Выберите период";

//AirDatepickerAsset::register($this);

Yii::$app->cache->flush();

?>

<style>
  #main-table tbody td {
    font-size: 12px;
  }
  strong {
    font-size: 14px;
    font-weight: 700;
  }
  #vks-dates {
    margin-top: 13px;
    width: 245px;
  }
  #delete-wrap {
    margin: 10px 10px 0px 0px;
    cursor: pointer;
  }
  #delete-wrap .fa {
    font-size: 28px;
    color: #ed1d1a !important;
  }
  .jconfirm {
    z-index: 9 !important;
  }
  i.check {
    display: inline-block;
    width: 15px;
    height: 30px;
    margin: 10px 20px 3px;
    border: solid #fff;
    border-width: 0 4px 4px 0;
    transform: rotate( 45deg);
  }

</style>

<div class="row">

  <div class="container-fluid" style="position: relative">
    <div id="add-session-wrap" style="position: absolute; top: 10px; left:-60px">
      <a id="add-session" class="fab-button" title="Добавить предстоящий сеанс" style="cursor: pointer">
        <div class="plus"></div>
      </a>
    </div>

    <div id="add-session-wrap-ex" style="position: absolute; top: 10px; right:-60px">
      <a id="add-session-ex" class="fab-button" title="Добавить прошедший сеанс" style="cursor: pointer; background-color: #4CAF50">
        <i class='check'></i>
      </a>
    </div>

    <input class="start-date" style="display: none">
    <input class="end-date" style="display: none">
    <?php

    echo '
        <table id="main-table" class="display no-wrap cell-border" style="width:100%">
          <thead>
            <tr>
              <th></th>
              <th >Дата</th>
              <th >Месяц</th>
              <th >Время</th>
              <th >Время</th>
              <th >Тип ВКС</th>
              <th >Студии</th>
              <th >Абонент</th>
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

  var periodInput = '<input class="form-control input-sm" id="vks-dates" type="text" data-range="true"' +
    'data-multiple-dates-separator=" - " placeholder="Период отображения"/>';

  var trashBtn = '<div id="delete-wrap" data-toggle="tooltip" data-placement="bottom" title="Удалить выделенные сеансы"' +
    'style="display: none"><i class="fa fa-trash" aria-hidden="true"></i></div>';

  // var addSession = '<a href="#" class="circle_fl ffdly"><i class="fa fa-plus"></i></a>';
  // var addSession = '<button id="add-session" type="button" class="btn btn-success">Добавить</button>';

  // var trashEx = '<img src="/images/logo.png" style="display:inline">';

  $(document).ready(function () {
    $('#right-custom-data').html(periodInput);
    $('#right-custom-data-ex').html(trashBtn);
    // $('#left-custom-data').html(addSession);
    // $('#left-custom-data').html(addd);

/*
    $('#vks-dates').datepicker({
      clearButton: true,
      toggleSelected: false,
      onHide: function (dp, animationCompleted) {
        if (animationCompleted) {
          var range = $('#vks-dates').val();
          var stDate = range.substring(6, 10) + '-' + range.substring(3, 5) + '-' + range.substring(0, 2);
          var eDate = range.substring(19, 24) + '-' + range.substring(16, 18) + '-' + range.substring(13, 15);
          $(".start-date").val(stDate);
          $(".end-date").val(eDate);
          $("#main-table").DataTable().clearPipeline().draw();
        }
      }
    });
*/

  });

  // ************************* Работа таблицы **************************************

  $(document).ready(function () {

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
  });

  $(document).ready(function () {
    var table = $('#main-table').DataTable({
      "processing": true,
      "serverSide": true,
      "responsive": true,
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
        var today = new Date();
        var date = aData[1];
        var important = aData[10];
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        var dt = new Date(date.replace(pattern, '$3-$2-$1'));
        if (important == 1) {
          $(nRow.cells[0]).css('color', 'red');
          $(nRow.cells[0]).css('font-weight', '600');
          // $(nRow.cells[0]).css('background-image', 'url("/lib/_warning.webp")');
          // $(nRow.cells[0]).css('background-repeat', 'no-repeat');
          // $(nRow.cells[0]).css('background-size', '20px 20px');
          // $(nRow.cells[0]).css('background-position', '90% 5%');

        }
        if (moment().isAfter(dt, 'day')) {
          $('td', nRow).css('background-color', '#faeeec');
        }
        else if (moment().isSame(dt, 'day')) {
          $('td', nRow).css('background-color', '#e4f0dc');
        }
      },
      "ajax": $.fn.dataTable.pipeline({
        url: '/vks/sessions/server-side?index=0',
        pages: 2, // number of pages to cache
        data: function () {
          var stDt = $(".start-date").val();
          var eDt = $(".end-date").val();
          if (stDt != '--') {
            var startDate = stDt;
          } else {
            var startDate = '1970-01-01';
          }
          if (eDt != '--') {
            var endDate = eDt;
          } else {
            var endDate = '2099-12-31';
          }
          return {
            'stDate': startDate,
            'eDate': endDate
          }
        }
      }),
      orderFixed: [2, 'asc'],
      order: [[4, 'asc'], [3, 'asc']],
      rowGroup: {
        dataSrc: 2
      },
      "columnDefs": [
        {
          "orderable": false,
          "targets": -2,
          "data": null,
          "width": '70px',
          "defaultContent":
            "<a href='#' id='edit' class='fa fa-edit' style='padding-right: 5px' title='Обновить'></a>" +
            "<a href='#' id='view' class='fa fa-info ' title='Подробности' style='padding-right: 5px'></a>" +
            "<a href='#' id='confirm-session' class='fa fa-calendar-check-o ' title='Подтвердить сеанс' style='padding-right: 5px'></a>"
          // "<a href='#' class='fa fa-calendar-minus-o abort' title='Отменить сеанс'></a>"
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
        }, {
          "targets": 2,
          "visible": false
        }, {
          "targets": 4,
          "visible": false
        },
        {
          "targets": 3,
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
        {
          "targets": 7,
          "render": function (data, type, row) {
            return row[7] + "<br> " + row[8];
          }
        }, {
          "targets": 8,
          "visible": false
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

    $('#main-table tbody').on('click', '#edit', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var url = "/vks/sessions/update-up-session-ajax?id=" + data[0];
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
        columnClass: 'large',
        title: 'Обновить предстоящий сеанс',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Обновить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function() {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
                return false;
              } else {
                var d = $('.vks-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.vks-date').val(d);
                var d = $('.vks_receive-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.vks_receive-date').val(d);
                $("#w0").submit();
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });

    $('#main-table tbody').on('click', '#view', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var url = "/vks/sessions/view-up-session-ajax?id=" + data[0];
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
    $('#main-table tbody').on('click', '#confirm-session', function (e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var url = "/vks/sessions/confirm-ajax?id=" + data[0];
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
        title: 'Подтвердить сеанс',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Сохранить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function() {
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
                $("#w0").submit();
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

  // Работа таблицы -> событие выделения и снятия выделения

  $(document).ready(function () {
    var table = $('#main-table').DataTable();
    table.on('select', function (e, dt, type, indexes) {
      if (type === 'row') {
        $('#delete-wrap').show();
      }
    });
    table.on('deselect', function (e, dt, type, indexes) {
      if (type === 'row') {
        if (table.rows({selected: true}).count() > 0) return;
        $('#delete-wrap').hide();
      }
    });
  });


  //********************** Удаление записей ***********************************

  $(document).ready(function () {
    $('#delete-wrap').click(function (event) {
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
              deleteProcess(url);
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


    function deleteProcess(url) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var table = $('#main-table').DataTable();
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
                  $("#main-table").DataTable().clearPipeline().draw();
                  $('#delete-wrap').hide();
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

    $('[data-toggle="tooltip"]').tooltip();

  });

  // создание предстоящего сеанса
  $(document).ready(function () {
    $('#add-session').click(function (event) {
      event.preventDefault();
      var url = "/vks/sessions/create-up-session-ajax";
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
        columnClass: 'large',
        title: 'Добавить предстоящий сеанс',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Добавить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function() {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
                return false;
              } else {
                var d = $('.vks-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.vks-date').val(d);
                var d = $('.vks_receive-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.vks_receive-date').val(d);
                $("#w0").submit();
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });

    $('#add-session-ex').click(function (event) {
      event.preventDefault();
      var url = "/vks/sessions/create-session-ajax";
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
        columnClass: 'large',
        title: 'Добавить прошедший сеанс',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Добавить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function() {
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
                $("#w0").submit();
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
