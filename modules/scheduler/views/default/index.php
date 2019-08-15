<?php

use app\modules\scheduler\assets\SchedulerAppAsset;

use app\assets\NotyAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;
use app\assets\fullcalendar\CalendarInteractionAsset;
use app\assets\fullcalendar\CalendarBootstrapAsset;
use app\assets\fullcalendar\CalendarListAsset;

SchedulerAppAsset::register($this);

NotyAsset::register($this);
CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);
CalendarInteractionAsset::register($this);
CalendarBootstrapAsset::register($this);
CalendarListAsset::register($this);
BootstrapDatepickerAsset::register($this);

?>

<div class="main-wrap">
  <div class="main-scheduler">
    <div id="calendar">

    </div>
  </div>
</div>

<script>

  var calendar;
  $(document).ready(function () {

    $('#push-it').removeClass('hidden');
    $('#app-control').removeClass('hidden');

    initLeftCustomData('/scheduler/menu/left-side-data');
    initRightCustomData('/scheduler/menu/right-side-data');
    initLeftMenu('/scheduler/menu/left-side');
    initAppConfig('/scheduler/menu/app-config');

    $('.main-scheduler').bind('mousewheel', function (e) {
      console.log(e);
      if (e.originalEvent.wheelDelta / 120 > 0) {
        console.log('scrolling up !');
      }
      else {
        console.log('scrolling down !');
      }
    });


    var csrf = $('meta[name=csrf-token]').attr("content");
    var fcSources = {
      vks: {
        id: '1111',
        url: '/scheduler/events/vks-data',
        method: 'POST',
        extraParams: {
          _csrf: csrf
        },
        failure: function () {
          console.log('Внимание! Ошибка получения сеансов ВКС!');
        },
        color: 'green',   // a non-ajax option
        textColor: 'white' // a non-ajax optio
      },
      to: {
        url: '/scheduler/events/to-data',
        method: 'POST',
        extraParams: {
          _csrf: csrf
        },
        failure: function () {
          console.log('Внимание! Ошибка получения графиков ТО!');
        },
        color: 'green',   // a non-ajax option
        textColor: 'white' // a non-ajax optio
      },
      events: {
        url: '/scheduler/events/events-data',
        method: 'POST',
        extraParams: {
          _csrf: csrf
        },
        failure: function () {
          console.log('Внимание! Ошибка получения событий!');
        },
        color: 'green',   // a non-ajax option
        textColor: 'white' // a non-ajax optio
      },
      holidays: {
        url: '/scheduler/events/holidays-data',
        method: 'POST',
        extraParams: {
          _csrf: csrf
        },
        failure: function () {
          console.log('Внимание! Ошибка получения дат дней рождений!');
        },
        textColor: 'white'
      }
    };

    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid', 'bootstrap', 'list'],
      locale: 'ru',
      height: function () {
        return $(window).height() - 55;
      },
      windowResize: function (view) {
        var size = $(window).height() - 55;
        // calendar.updateSize();
      },
      themeSystem: 'bootstrap',
      navLinks: true,
      weekNumbers: true,
      weekNumbersWithinDays: true,
      selectable: true,
      nowIndicator: true,
      slotDuration: '00:15:00',
      minTime: '06:00:00',
      eventLimit: true,
      eventSources: [
        fcSources.vks,
        fcSources.to,
        fcSources.events,
        fcSources.holidays
      ],
      defaultView: 'dayGridMonth',
      header: false,
      customButtons: {
        calendars: {
          text: 'Календари',
          click: function (e) {
            showDialog(e);
            // calendar.addEventSource(fcSources.vks);
            // var eb = calendar.getEventSourceById(1111);
            // eb.remove();
          }
        },
        custom2: {
          text: 'ГОД',
          click: function () {
            $('.fc-view-container').html('');
            $.ajax({
              url: '/scheduler/full-year/test',
              method: 'get',
            }).done(function (resp) {
              $('.fc-view-container').html(resp);
            }).fail(function () {
              self.setContentAppend('<div>Что-то пошло не так!</div>');
            });
          }
        }
      },
      businessHours: [
        {
          daysOfWeek: [1, 2, 3, 4], // Monday, Tuesday, Wednesday, Thursday
          startTime: '09:00',
          endTime: '18:15'
        },
        {
          daysOfWeek: [5], // Friday
          startTime: '09:00',
          endTime: '17:00'
        }
      ],
      showNonCurrentDates: true,

      //========================= rendering ==================================
      eventRender: function (info) {
        var ntoday = new Date();
        if (info.event._def.rendering == 'background') {
          var type = info.event._def.extendedProps.holiday_type;
          if (type == 0) {
            $(info.el).css('background-color', '#E0FFFF');
          } else if (type == 1 || type == 2) {
            $(info.el).css('background-color', '#FFA07A');
          } else {
            $(info.el).css('background-color', '#ff5a35');
          }
        }
      },
      dayRender: function (info) {
        var title = info.view.title;
        $("#left-custom-data-ex").html(title);
      },
      //========================= actions =====================================
      select: function (info) {
        var c = $.confirm({
          content: function () {
            var self = this;
            return $.ajax({
              url: '/scheduler/events/event-form',
              method: 'get',
              data: {
                startDate: info.startStr,
                endDate: info.endStr
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
          title: 'Добавить событие',
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
                msg.title = $('#event-title').val();
                msg.start = $('#start-date').val();
                msg.end = $('#end-date').val();
                msg.desc = $('#event-description').val();
                msg.color = $('#colorpicker').val();
                var q = saveEvent(msg);
              }
            },
            cancel: {
              btnClass: 'btn-red',
              text: 'Отмена'
            }
          },
          onContentReady: function () {
            var self = this;
            this.buttons.ok.disable();
            this.$content.find('#event-title').on('keyup mouseclick', function () {
              if ($(this).val() != '') {
                self.buttons.ok.enable();
              } else {
                self.buttons.ok.disable();
              }
            });
          }
        })
      },

      //========================= events =======================================
      eventClick: function (info) {
        info.jsEvent.preventDefault();
        if (info.event.extendedProps) {
          var url = info.event.url;
          var urlText = info.event.extendedProps.exUrl;
          var ar = urlText.split('/');
          var req = ar[0];
          var ident = ar[1];
          c = $.confirm({
            content: function () {
              var self = this;
              return $.ajax({
                url: '/scheduler/events/' + req,
                method: 'get',
                data: {
                  i: ident
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
            title: 'Подробности',
            buttons: {
              ok: {
                btnClass: 'btn-blue',
                text: 'К СОБЫТИЮ',
                action: function () {
                  window.open(url);
                }
              },
              edit: {
                btnClass: 'btn-blue',
                text: 'Обновить',
                action: function () {
                  editEvent(ident);
                }
              },
              del: {
                btnClass: 'btn-red',
                text: 'Удалить',
                action: function () {
                  deleteEvent(ident)
                }
              },
              cancel: {
                text: 'НАЗАД'
              }
            },
            onContentReady: function () {
              var self = this;
              if (req == 'sub-event') {
                this.buttons.ok.hide();
              } else {
                this.buttons.del.hide();
                this.buttons.edit.hide();
              }
              this.$content.find('#event-title').on('keyup mouseclick', function () {
                if ($(this).val() != '') {
                  self.buttons.ok.enable();
                } else {
                  self.buttons.ok.disable();
                }
              });
            }
          })
        }
      }
    });
    calendar.render();
    $('#left-custom-data-ex').html(calendar.view.title);


  });

  function calendarShow(e) {
    var id = $(e).attr('id');
    $('#' + id).datepicker({}).data('datepicker');
    $('#' + id).datepicker('show');
    $('#' + id).datepicker()
      .on('hide', function (e) {
        var momentDate = moment(e.date);
        var fDate = momentDate.format('Y-MM-DD');
        calendar.gotoDate(fDate);
        navCalendar.close();
      });
  }

  $(document).on('click', '#view-selector li', function (e) {
    e.preventDefault();
    var viewType = $(this).attr('value');
    $('#view-menu-btn > #title').text($(this).text());
    $('#view-menu-btn > #title').attr('title', $(this).text());
    calendar.changeView(viewType);
  });

  $(document).on('click', '#previous-date', function (e) {
    e.preventDefault();
    calendar.prev();
  });

  $(document).on('click', '#next-date', function (e) {
    e.preventDefault();
    calendar.next();
  });

  $(document).on('click', '#today-btn', function (e) {
    e.preventDefault();
    calendar.today();
  });

  /* скролл над календарем (вид - месяц) */
  var timeStamp = new Date().getTime();
  $(document).on('wheel', '.fc-dayGridMonth-view', function (e) {
    if(e.ctrlKey == true) return;
    e.preventDefault();
    var timeNow = new Date().getTime();
    if (timeNow - timeStamp < 200) {          //задержка для прокрутки (сдвиг на один месяц)
      timeStamp = timeNow;
      return;
    } else {
      timeStamp = timeNow;
      if(e.originalEvent.deltaY < 0){
        calendar.prev();
      }
      else {
        calendar.next();
      }
    }
  });

  /* нажатие на неделю */
  $(document).on('click', '.fc-week-number', function (e) {
    $('#view-menu-btn > #title').text('Неделя');
  });

  /* нажатие на день */
  $(document).on('click', '.fc-day-number', function (e) {
    $('#view-menu-btn > #title').text('День');
  });
  $(document).on('click', '.fc-day-number, .fc-day-header, .fc-list-heading-main', function (e) {
    $('#view-menu-btn > #title').text('День');
  });


</script>