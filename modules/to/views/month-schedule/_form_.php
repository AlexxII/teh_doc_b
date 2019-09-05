<?php

use \yii\helpers\Html;
use \yii\widgets\ActiveForm;

use app\assets\TableBaseAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);
TableBaseAsset::register($this);

?>

<style>
  tr input, select {
    min-height: 20px;
  }
  #main-table tbody td {
    font-size: 12px;
  }
  #main-table tbody tr select {
    font-size: 12px;
  }
  #main-table tr {
    font-size: 12px;
  }
  .highlight {
    /*background-color: #b2dba1;*/
    color: #CC0000;
    font-weight: 700;
  }
  .form-control {
    width: 140px
  }
  .to-list {
    width: 170px
  }
</style>

<?php
$form = ActiveForm::begin([
  'fieldConfig' => [
    'options' => [
      'tag' => false,
      'class' => 'userform',
    ],
  ],
  'id' => 'schedule-creation'
]); ?>

<?= $form->field($to, "to_type", ['template' => "<div >{input}</div>"])->dropDownList($to->toList,
  [
    'prompt' => [
      'text' => 'Выберите',
      'options' => [
        'value' => 'none',
        'disabled' => 'true',
        'selected' => 'true'
      ]
    ],
    'class' => 'form-control to-list m-select',
    'id' => 'test-form'
  ])->label(false); ?>

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
<?php ActiveForm::end(); ?>


<script>

  //=============================== Работа с календарями =====================================

  var toTypeForm = '<input class="form-control" style="max-width: 170px">';

  $(document).ready(function () {

    var tt = $('#test-form');
    console.log(tt);

    var table = $('#schedule-create-tbl').DataTable({
      'processing': true,
      'ajax': {
        'url': '/to/month-schedule/test'
      },
      'columns': [
        {'defaultContent': ''},
        {'data': 'name'},
        {'data': 'eq_serial'},
        {'data': 'parent_id'},
        {'defaultContent': tt},
        {'defaultContent': '2'},
        {'defaultContent': '3'},
        {'defaultContent': '4'},
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
          'targets': 2,
          'render': function (data) {
            return data;
          }
        }, {
          'targets': 3,
          'data': null,
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
      table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
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
    })
  });

  $(document).ready(function () {
    // обработчик события - выбрать месяц проведения ТО
    // и формирование массива выходных дней

    $('#to-month').on('change', function (e) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      if (e.target.value != '') {
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


  // обработка выбора ответственного за проведение ТО
  $('.admin-list').on('change', function (e) {
    var val = e.target.value;
    $(this).closest('tr').find('.to-date').prop('disabled', false);
    if ($(this).closest('tr').hasClass('selected')) {
      $('.selected').each(function () {
        $(this).find('.admin-list').val(val);
        $(this).find('.to-date').prop('disabled', false);
      });
    }
  });

  // копирование селектов в выделенные ячейки
  $('.m-select').on('change', function (e) {
    var i = $(this).closest('td').index();
    var val = e.target.value;
    if ($(this).closest('tr').hasClass('selected')) {
      $('.selected').each(function () {
        $(this).find('td').eq(i).find(e.target.nodeName).val(val);
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

  $(document).ready(function () {
    $('#to-month').mouseover(function () {
      if ($(this).val() == "") {
        $('#to-month').tooltip('enable');
        $('#to-month').tooltip('show');
      } else {
        $('#to-month').prop('title', '');
        $('#to-month-tooltip').tooltip('disable');
      }
    })
  });

  $(document).ready(function () {
    $('.admin-list').mouseover(function () {
      if ($(this).prop('disabled')) {
        $('#to-month').tooltip('enable');
        $('#to-month').tooltip('show');
      }
    })
  });

  $(document).ready(function () {
    $('.to-date').mouseover(function () {
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
    })
  });


  $('.to-date').mouseleave(function () {
    $('#to-month').tooltip('hide');
    $('#to-month').tooltip('disable');
  });
  $('.to-date').mouseleave(function () {
    $('.admin-list').tooltip('hide');
    $('.admin-list').tooltip('disable');
  });
  $('.admin-list').mouseleave(function () {
    $('#to-month').tooltip('hide');
    $('#to-month').tooltip('disable');
  });

  //==================================================== 76859

</script>

