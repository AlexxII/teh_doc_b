<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

use app\assets\TableBaseAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);
TableBaseAsset::register($this);

?>

<div class="row">
  <div class="col-lg-10 col-md-8">
    <div style="float: left; padding-top: 18px; padding-bottom: 15px; max-width: 290px">
      <div class="input-group date to-month-tooltip" data-toggle='tooltip' data-placement='top'>
        <input type="text" class="form-control" id="to-month" title="Необходимо ввести месяц"
               style="font-size: 22px;color:#C50100;font-weight: 600" name="month"><span
                class="input-group-addon"><i
                  class="fa fa-calendar" aria-hidden="true" style="font-size: 18px"></i></span>
      </div>
    </div>
  </div>
</div>

<table id="schedule-create-tbl" class="display no-wrap cell-border" style="width:100%">
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
<br>
<button class="btn btn-ml" id="create-new-schedule" style="background-color: #2196f3; color: #fff*">Создать</button>
<br>
<br>
<script>

  //=============================== Работа с календарями =====================================

  var toTypeSelect = '<select class="form-control to-list m-select" style="max-width: 120px">' +
    '<option value="none" selected="true" disabled="true">Выберите</option>' +
    '<option value="2117077616">ТО-1</option>' +
    '<option value="1497463421">ТО-2</option>' +
    '</select>';
  var toAdminsSelect = '<select class="form-control admin-list" disabled style="width: 170px">' +
    '<option value="none" selected="true" disabled="true">Выберите</option>' +
    '<option>Лесин С.Н.</option>' +
    '<option>Игнатенко А.М.</option>' +
    '</select>';
  var toAuditorsSelect = '<select class="form-control audit-list m-select" style="width: 170px">' +
    '<option value="none" selected="true" disabled="true">Выберите</option>' +
    '<option>Малышев В.Ю.</option>' +
    '<option>Врачев Д.С.</option>' +
    '</select>';
  var toDateInput = '<input class="to-date form-control" disabled style="max-width: 170px;">';


  $.ajax({
    url: '/to/settings/select-data',
    method: 'get',
    dataType: "JSON",
  }).done(function (response) {

  }).fail(function () {
    console.log('fail')
  });


  var table;
  $(document).ready(function () {

    table = $('#schedule-create-tbl').DataTable({
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
        {'defaultContent': toTypeSelect},
        {'defaultContent': toDateInput},
        {'defaultContent': toAdminsSelect},
        {'defaultContent': toAuditorsSelect},
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

  var freeDays = new Array();
  var busyDays = new Array(); // глобальный массив хранения
  var startDay, endDay, startDayBorder, endDayBorder; // глобальные переменных хранения дат

  $(document).ready(function () {
    //первичные настройки интерфейса и календаря

    $.fn.datepicker.defaults.format = "dd.mm.yyyy";
    $.fn.datepicker.defaults.language = "ru";
    $.fn.datepicker.defaults.daysOfWeekDisabled = "0,6";

    $('.admin-list').prop('disabled', true);
    $('.to-date').prop('disabled', true);

    // инициализация календаря месяца проведения ТО
    $('#to-month').datepicker({
      format: 'MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "months",
      minViewMode: "months",
      clearBtn: true
    });

    // обработчик события - выбрать месяц проведения ТО
    // и формирование массива выходных дней

  });

  $(document).on('change', '#to-month', function (e) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    if (e.target.value != '') {
      var table = $('#schedule-create-tbl').DataTable();
      table.rows('.selected').deselect();
      jc = $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Подождите!',
        content: 'Формируются необходимые данные на выбранный месяц!',
        buttons: false,
        closeIcon: false,
        confirmButtonClass: 'hide'
      });
      var toMonth = $('#to-month').datepicker('getDate');
      var year = toMonth.getFullYear();
      var month = toMonth.getMonth();
      var url = '/to/month-schedule/get-types';
      $.ajax({
        url: url,
        type: "post",
        data: {year: year, month: month, _csrf: csrf}
      }).done(function (response) {
        if (response != false) {
          var result = JSON.parse(response);
          result.forEach(function (item, i, ar) {
            if (item.month == null) return;
            $('#' + item.eq_id).val(item.month);
          });
          getMonthBorders();
          setMonth();
          $('.to-date').val('');
          $('.to-date').prop('disabled', true);
          $('.admin-list').val('none');
          $('.admin-list').prop('disabled', false);
          jc.close();
          jc = $.confirm({
            icon: 'fa fa-thumbs-up',
            title: 'Успех!',
            content: 'Данные сформированы',
            type: 'green',
            buttons: false,
            closeIcon: false,
            autoClose: 'ok|8000',
            confirmButtonClass: 'hide',
            buttons: {
              ok: {
                btnClass: 'btn-success',
                action: function () {
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
    } else {
      $('.to-date').val('');
      $('.to-date').prop('disabled', true);
      $('.admin-list').prop('disabled', true);
      $('.admin-list').val('none');
    }
  });

  function getMonthBorders() {
    var toMonth = $('#to-month').datepicker('getDate');
    var month = toMonth.getMonth();
    var year = toMonth.getFullYear();
    var mDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var nMonth = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    var start_date = year + '-' + nMonth[month] + '-01';
    var end_date = year + '-' + nMonth[month] + '-' + mDays[month];

    startDayBorder = '01-' + nMonth[month] + '-' + year;
    endDayBorder = mDays[month] + '-' + nMonth[month] + '-' + year;

    startDay = '01.' + nMonth[month] + '.' + year;
    endDay = mDays[month] + '.' + nMonth[month] + '.' + year;
  }


  function setMonth() {
    var m = $('#to-month');
    if (m.val() != '') {
      var fullDate = new Date(m.val());
      var year = fullDate.getFullYear();
      var month = fullDate.getMonth();
      var nMonth = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
      $('.to-date').prop('disabled', false);
      $('.to-date').datepicker('setStartDate', startDay);
      $('.to-date').datepicker('update', startDay);
      $('.to-date').on('change', copySl);                    // обработчик события 'change'
    }
    return;
  }

  // копирование селектов в выделенные ячейки

  $(document).on('change', '.m-select', function (e) {
    var i = $(this).closest('td').index();
    var val = e.target.value;
    if ($(this).closest('tr').hasClass('selected')) {
      $('.selected').each(function () {
        $(this).find('td').eq(i).find(e.target.nodeName).val(val);
      });
    }
  });

  // обработка выбора ответственного за проведение ТО

  $(document).on('change', '.admin-list', function (e) {
    var val = e.target.value;
    $(this).closest('tr').find('.to-date').prop('disabled', false);
    if ($(this).closest('tr').hasClass('selected')) {
      $('.selected').each(function () {
        $(this).find('.admin-list').val(val);
        $(this).find('.to-date').prop('disabled', false);
      });
    }
  });

  // функция копирования дат проведения ТО
  function copySl(e) {
    if ($(this).closest('tr').hasClass('selected')) {
      var dt = $(this).data('datepicker').getFormattedDate('dd-mm-yyyy');
      $('.selected').each(function () {
        var toDate = $(this).find('.to-date');
        toDate.off('change', copySl);           // чтобы не сработала рекурсия события 'change'
        if (!toDate.prop('disabled'))
          toDate.datepicker('update', dt);
        toDate.on('change', copySl);           //
      });
    }
  }

  //****************************************************************************

  // форматирование дат в соответствии с форматом MySQL(UNIX) перед отправкой формы
  $(document).ready(function () {
    $('#w0').submit(function () {
      var d = $('#to-month').data('datepicker').getFormattedDate('yyyy-mm-dd');
      $('#to-month').val(d);
      $('.to-date').each(function () {
        var dy = $(this).data('datepicker').getFormattedDate('yyyy-mm-dd');
        $(this).val(dy);
      })
    });
  });


  // ======================= Обработка подсказки ("Необходимо ввести месяц")==== ===================

  $(document).on('mouseover', '#to-month', function (e) {
    if ($(this).val() == "") {
      $('#to-month').tooltip('enable');
      $('#to-month').tooltip('show');
    } else {
      $('#to-month').prop('title', '');
      $('#to-month-tooltip').tooltip('disable');
    }
  });

  $(document).on('mouseover', '.admin-list', function (e) {
    if ($(this).prop('disabled')) {
      $('#to-month').tooltip('enable');
      $('#to-month').tooltip('show');
    }
  });


  $(document).on('mouseover', '.to-date', function (e) {
    if ($(this).prop('disabled')) {
      if ($('#to-month').val() == '') {
        $('#to-month').prop('title', 'Необходимо выбрать месяц');
        $('#to-month').tooltip('enable');
        $('#to-month').tooltip('show');
      } else {
        var adminList = $(this).closest('tr').find('.admin-list');
        adminList.tooltip('enable');
        adminList.tooltip('show');
      }
    }
  });

  $(document).on('mouseleave', '.to-date', function (e) {
    $('#to-month').tooltip('hide');
    $('#to-month').tooltip('disable');
    $('.admin-list').tooltip('hide');
    $('.admin-list').tooltip('disable');
  });

  $(document).on('mouseleave', '.admin-list', function (e) {
    $('#to-month').tooltip('hide');
    $('#to-month').tooltip('disable');
  });

  //==================================================== 76859

</script>