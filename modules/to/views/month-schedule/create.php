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
<form id="schedule-create">

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
  <button class="btn btn-ml" id="create-new-schedule" style="background-color: #2196f3; color: #fff">Создать</button>
</form>
<br>
<br>
<script>

  //=============================== Работа с календарями =====================================

  var toDateInput = '<input class="to-date form-control" name="to-date" disabled style="max-width: 170px;">';

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
      ordering: false,
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
          'visible': false,
          'orderable': false
        }, {
          'targets': 4,
          'visible': false
        }
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


  $(document).on('click', '#create-new-schedule', function (e) {
    e.preventDefault();
    var $table = $('#schedule-create-tbl');
    var rows = $table[0].rows;
    var scheduleData = new Object();
    var tableData = table.rows().data();

    for (var key in rows) {
      if (rows[key].localName == 'tr') {
        if (rows[key].attributes.class != undefined && rows[key].attributes.class.value != 'group group-start') {
          if (rows[key].cells[3].firstChild.value == 'none') {
            $(rows[key].cells[3].firstChild).focus();
            $(rows[key]).effect("pulsate", {}, 2500);
            console.log('Есть пустые поля.');
            return;
          }
          var id = rows[key].cells[3].firstChild.attributes.id.value;
          var tempArray = {};
          tempArray['type'] = rows[key].cells[3].firstChild.value;
          if (rows[key].cells[4].firstChild.value == '') {
            var state = rows[key].cells[4].firstChild.disabled;
            rows[key].cells[4].firstChild.disabled = false;
            $(rows[key].cells[4].firstChild).focus();
            rows[key].cells[4].firstChild.disabled = state;
            $(rows[key]).effect("pulsate", {}, 2500);
            console.log('Есть пустые поля.');
            return;
          }
          tempArray['date'] = rows[key].cells[4].firstChild.value;
          if (rows[key].cells[5].firstChild.value == 'none') {
            $(rows[key].cells[5].firstChild).focus();
            $(rows[key]).effect("pulsate", {}, 2500);
            console.log('Есть пустые поля.');
            return;
          }
          tempArray['admin'] = rows[key].cells[5].firstChild.value;
          if (rows[key].cells[6].firstChild.value == 'none') {
            $(rows[key].cells[6].firstChild).focus();
            $(rows[key]).effect("pulsate", {}, 2500);
            console.log('Есть пустые поля.');
            return;
          }
          tempArray['auditor'] = rows[key].cells[6].firstChild.value;
          scheduleData[id] = tempArray;
        }
      }
    }
    console.log(scheduleData);
//        console.log($('#schedule-create').serialize());
    return;
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