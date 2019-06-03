<?php

use app\assets\AirDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;
use app\assets\fullcalendar\CalendarInteractionAsset;
use app\assets\fullcalendar\CalendarBootstrapAsset;

CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);
CalendarInteractionAsset::register($this);
CalendarBootstrapAsset::register($this);
AirDatepickerAsset::register($this);

$this->title = 'График дежурств';
$this->params['breadcrumbs'][] = ['label' => 'Планировщик', 'url' => ['/scheduler']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
  .main-scheduler {
    margin-top: 20px;
  }
  table.table-bordered > tbody > tr > td:nth-of-type(1) {
    /*background-color: #0a0a0a;*/
  }
  .fc-week-number {
    background-color: #e2e2e2;
  }
  .past div.fc-time, .past div.fc-title {
    text-decoration: line-through;
  }
</style>


<div class="main-scheduler">
  <div class="col-md-12 col-lg-12">
    <div id="calendar">
    </div>
  </div>
</div>

<script>

  var calendar, Draggable;

  $(document).ready(function () {

    // initialize the external events
    // -----------------------------------------------------------------
    var csrf = $('meta[name=csrf-token]').attr("content");
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid', 'bootstrap'],
      locale: 'ru',
      themeSystem: 'bootstrap',
      weekNumbers: true,
      selectable: true,
      nowIndicator: true,
      slotDuration: '00:15:00',
      minTime: '06:00:00',
      navLinks: true,
      eventSources: [
        {
          url: '/scheduler/events/list',
          method: 'POST',
          extraParams: {
            _csrf: csrf
          },
          failure: function () {
            console.log('Внимание! Ошибка получения событий из Журнала ВКС');
          }
        }
      ],
      buttonText: {
        month: 'M',
        week: 'Н',
        day: 'Д',
        list: 'Лист'
      },
      bootstrapFontAwesome: {
        close: 'fa-times',
        prev: 'fa-chevron-left',
        next: 'fa-chevron-right',
        prevYear: 'fa-angle-double-left',
        nextYear: 'fa-angle-double-right'
      },
      header: {
        left: 'dayGridMonth,timeGridWeek,timeGridDay',
        center: 'title',
        right: 'today prev,next'
      },
      customButtons: {
        custom1: {
          text: 'custom 1',
          click: function () {
            alert('clicked custom button 1!');
          }
        }
      },
      businessHours: [ // specify an array instead
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
      droppable: true, // this allows things to be dropped onto the calendar

      //========================= rendering ==================================
      eventRender: function (info) {
        var ntoday = new Date();
        if (info.event._instance.range.start < ntoday.getTime()) {
//                    console.log(info.el);
//                    info.el.addClass('past');
//                    info.el.children().addClass('past');
        }
      },


      //========================= actions =====================================


      drop: function (info) {

      },
      dateClick: function (info) {
//                 console.log(info.dateStr);
        console.log(info);
        // info.dayEl.style.backgroundColor = 'red';
      },
      select: function (info) {
//                console.log('selected ' + info.startStr + ' to ' + info.endStr);
      },

      //========================= events =======================================
      eventResizeStart: function (info) {
        console.log(info.view);
      },
      eventClick: function (info) {
        info.jsEvent.preventDefault();
        console.log(info.event.extendedProps);
        if (info.event.extendedProps) {
          var url = info.event.url;
          var urlText = info.event.extendedProps.exUrl;
          var ar = urlText.split('/');
          var req = ar[0];
          var ident = ar[1];

          var c = $.confirm({
            content: function () {
              var self = this;
              return $.ajax({
                url: '/scheduler/events/' + req,
                method: 'get',
                data: {
                  i: ident
                }
              }).done(function (response) {
                console.log(response);
              }).fail(function () {
                self.setContentAppend('<div>Что-то пошло не так!</div>');
              });
            },
            contentLoaded: function (data, status, xhr) {
              console.log(xhr);
              this.setContentAppend('<div>' + data + '</div>');
            },
            type: 'blue',
            columnClass: 'medium',
            title: 'Подробности',
            buttons: {
              go: {
                btnClass: 'btn-blue',
                text: 'К СОБЫТИЮ',
                action: function () {

                  window.open(url);
                }
              },
              cancel: {
                text: 'НАЗАД'
              }
            }
          })
        }
      }
    });
    calendar.render();

    $('#nav-calendar').datepicker({
      inline: true,
      onSelect: function (formattedDate, date, inst) {
        var momentDate = moment(date);
        var fDate = momentDate.format('Y-MM-DD');
        calendar.gotoDate(fDate);
      }
    })

  });

</script>