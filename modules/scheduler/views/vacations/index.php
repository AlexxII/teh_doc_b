<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapYearCalendarAsset::register($this);
BootstrapDatepickerAsset::register($this);

$this->title = 'Календарь отпусков';
$this->params['breadcrumbs'][] = ['label' => 'Планировщик', 'url' => ['/scheduler']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
  .calendar {
    overflow: visible;
  }
</style>


<div class="main-scheduler row">
  <div class="col-md-2 col-lg-2" style="margin-bottom: 15px">
    <div id="info-panel">
      <span><h3>Сотрудники:</h3></span>
      <?php foreach ($models as $key => $model): ?>
        <div style="color: <?= $model->color_scheme ?>; font-weight: bold">
          <label style="cursor: pointer">
            <input type="checkbox" class="users-checkboxes" id="<?= $model->id ?>" data-id="<?= $model->id ?>">
            <?= $model->username ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-md-10 col-lg-10">
    <div id="full-calendar" data-provide="ec"></div>
  </div>
</div>

<script>

  $(document).ready(function () {
    var currentYear = new Date().getFullYear();
    var todayAll = new Date();
    todayAll.setHours(0, 0, 0, 0);
    var today = todayAll.getTime();

    var holidays;

    function getHolidays(year, callback) {
      $.ajax({
        url: "holidays/holidays-array",
        type: 'GET',
        data: {
          year: year
        },
        success: function (dataSource) {
          if (dataSource != '') {
            holidays = JSON.parse(dataSource);
            holidays instanceof Array ? holidays : [];
          }
        }
      });
      callback();
    }

    getHolidays(currentYear, initCalendar);

    function initCalendar() {
      $('#full-calendar').calendar({
        language: 'ru',
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems: [
          {
            text: 'Обновить',
            click: editVacation
          },
          {
            text: 'Удалить',
            click: deleteVacation
          }
        ],
        dayContextMenu: function (e) {
          $(e.element).popover('hide');
        },
        mouseOnDay: function (e) {
          if (e.events.length > 0) {
            var content = '';
            for (var i in e.events) {
              if ('hType' in e.events[i]) {
                return;
              }
              content += '<div class="event-tooltip-content">'
                + '<div class="event-name" style="color:' + e.events[i].color + ' ! important ">' + e.events[i].name + '</div>'
                + '<div class="event-location">' + e.events[i].location + ' - ' + e.events[i].duration + '</div>'
                + '</div>';
            }
            $(e.element).popover({
              trigger: 'manual',
              container: 'body',
              html: true,
              content: content
            });

            $(e.element).popover('show');
          }
        },
        mouseOutDay: function (e) {
          if (e.events.length > 0) {
            $(e.element).popover('hide');
          }
        },
        customDayRenderer: function (element, date) {
          if (date.getTime() == today) {
            $(element).css('background-color', 'orange');
            $(element).css('color', 'white');
            $(element).css('border-radius', '15px');
          }
          if (contains(holidays, date.getTime() / 1000)) {
            $(element).css('font-weight', 'bold');
            $(element).css('font-size', '15px');
            $(element).css('color', 'red');
          }

        },
        selectRange: function (e) {
          var day = 24 * 60 * 60 * 1000;
          var diff = ((e.endDate - e.startDate) / day) + 1;
          var sDate = e.startDate;
          var eDate = e.endDate;
          var sDateStr = sDate.getFullYear() + '-' + (sDate.getMonth() + 1) + '-' + sDate.getDate();
          var eDateStr = eDate.getFullYear() + '-' + (eDate.getMonth() + 1) + '-' + eDate.getDate();
          var c = $.confirm({
            content: function () {
              var self = this;
              return $.ajax({
                url: '/scheduler/vacations/form',
                method: 'get',
                data: {
                  startDate: sDateStr,
                  endDate: eDateStr,
                  diff: diff
                }
              }).fail(function () {
                self.setContentAppend('<div>Что-то пошло не так!</div>');
              });
            },
            contentLoaded: function (data, status, xhr) {
              this.setContentAppend('<div>' + data + '</div>');
            },
            type: 'blue',
            columnClass: 'medium',
            title: 'Добавить отпуск',
            buttons: {
              ok: {
                btnClass: 'btn-blue',
                text: 'Сохранить',
                action: function () {
                  var msg = {};
                  var title = $('#event-title').val();
                  if (title == '') {
                    return;
                  }
                  msg.user = $('#user').val();
                  msg.start = $('#start-date').val();
                  msg.end = $('#end-date').val();
                  msg.duration = $('#duration').val();
                  saveVacation(msg, msg.user);
                }
              },
              cancel: {
                btnClass: 'btn-red',
                text: 'Отмена'
              }
            }
          })
        },
        yearChanged: function (e) {
          console.log('11111');
          $(e.target).append('<div style="text-align:center"><img src="/lib/3.gif" /></div>');
          e.preventRendering = true;
          var currentYear = e.currentYear;
          getHolidays(currentYear, emptyFun);
          yearRender(e, currentYear);
        }
      });
    }

    function saveVacation(data, userId) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var currentYear = $('#full-calendar').data('calendar').getYear();
      $.ajax({
        url: '/scheduler/vacations/save-vacation',
        method: 'post',
        data: {
          _csrf: csrf,
          msg: data
        }
      }).done(function (response) {
        $('#' + userId).prop('checked', true);
        $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
      }).fail(function () {
        console.log('Что-то пошло не так!');
      });
    }

    function yearRender(e, year) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var users = [1];
      $('.users-checkboxes').each(function (e) {
        if ($(this).is(':checked')){
          users.push($(this).data('id'));
        }
      });
      data = [];
      if (users.length > 0) {
        data = [];
      }
      $.ajax({
        url: "vacations/vacations-data",
        type: 'POST',
        data: {
          _csrf: csrf,
          year: year,
          users: users
        },
        success: function (dataSource) {
          if (dataSource != '') {
            var data = JSON.parse(dataSource);
            data instanceof Array ? data : [];
            if (data instanceof Array) {
              data.forEach(function (el, index, theArray) {
                theArray[index].startDate = new Date(el.sYear, el.sMonth, el.sDay);
                theArray[index].endDate = new Date(el.eYear, el.eMonth, el.eDay);
              });
            } else {
              data = [];
            }
          }
          $(e.target).data('calendar').setDataSource(data);
        }
      });
    }

    function editVacation(event) {
      var currentYear = $('#full-calendar').data('calendar').getYear();
      var eventId = event.id;
      var c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: '/scheduler/vacations/update-form',
            method: 'get',
            data: {
              id: eventId
            }
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так!</div>');
          });
        },
        contentLoaded: function (data, status, xhr) {
          this.setContentAppend('<div>' + data + '</div>');
        },
        type: 'blue',
        columnClass: 'medium',
        title: 'Обновить отпуск',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Сохранить',
            action: function () {
              var msg = {};
              var title = $('#event-title').val();
              if (title == '') {
                return;
              }
              msg.id = eventId;
              msg.user = $('#user').val();
              msg.start = $('#start-date').val();
              msg.end = $('#end-date').val();
              msg.duration = $('#duration').val();
              updateVacation(msg);
            }
          },
          cancel: {
            btnClass: 'btn-red',
            text: 'Отмена'
          }
        }
      })
    }

    function updateVacation(data) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var currentYear = $('#full-calendar').data('calendar').getYear();
      $.ajax({
        url: '/scheduler/vacations/update-vacation',
        method: 'post',
        data: {
          _csrf: csrf,
          msg: data
        }
      }).done(function (response) {
        $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
      }).fail(function () {
        console.log('Что-то пошло не так!');
      });
    }


    function deleteVacation(event) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var currentYear = $('#full-calendar').data('calendar').getYear();
      var eventId = event.id;
      $.ajax({
        url: '/scheduler/vacations/delete-vacation',
        method: 'post',
        data: {
          _csrf: csrf,
          id: eventId
        }
      }).done(function (response) {
        $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
      }).fail(function () {
        console.log('Что-то пошло не так!');
      });
    }

    function contains(arr, elem) {
      for (var i = 0; i < arr.length; i++) {
        if (arr[i] === elem) {
          return true;
        }
      }
      return false;
    }

    $('.users-checkboxes').click('on', function (e) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      var currentYear = $('#full-calendar').data('calendar').getYear();
      var users = [];
      $('.users-checkboxes').each(function (e) {
        if ($(this).is(':checked')){
          users.push($(this).data('id'));
        }
      });
      if (users.length > 0) {
        $.ajax({
          url: "vacations/vacations-data",
          type: 'POST',
          data: {
            _csrf: csrf,
            year: currentYear,
            users: users
          },
          success: function (dataSource) {
            if (dataSource != '') {
              var data = JSON.parse(dataSource);
              data instanceof Array ? data : [];
              if (data instanceof Array) {
                data.forEach(function (el, index, theArray) {
                  theArray[index].startDate = new Date(el.sYear, el.sMonth, el.sDay);
                  theArray[index].endDate = new Date(el.eYear, el.eMonth, el.eDay);
                });
              } else {
                data = [];
              }
            }
            $('#full-calendar').data('calendar').setDataSource(data);
          }
        });
      } else {
        data = [];
        $('#full-calendar').data('calendar').setDataSource(data);
      }

    })

  });

  function emptyFun() {
    return 1;
  }

</script>