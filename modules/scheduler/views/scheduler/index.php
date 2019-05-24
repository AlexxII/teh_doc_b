<?php

use app\assets\NotyAsset;
use app\assets\AirDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;
use app\assets\fullcalendar\CalendarInteractionAsset;
use app\assets\fullcalendar\CalendarBootstrapAsset;

NotyAsset::register($this);
CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);
CalendarInteractionAsset::register($this);
CalendarBootstrapAsset::register($this);
AirDatepickerAsset::register($this);

$this->title = 'Планировщик';
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
  .main-scheduler {
    margin-top: 20px;
  }
</style>


<div class="main-scheduler row">
  <div class="col-md-3 col-lg-3" style="margin-bottom: 15px">
    <div id="nav-calendar"></div>
  </div>
  <div class="col-md-9 col-lg-9">
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
      slotDuration: '00:30:00',

      eventSources: [
        {
          url: '/scheduler/events/list',
          method: 'POST',
          extraParams: {
            _csrf: csrf,
            show: 'vks'
          },
          failure: function() {
            console.log('there was an error while fetching events!');
          },
          color: 'yellow',   // a non-ajax option
          textColor: 'black' // a non-ajax option
        }

        // any other sources...

      ],

      dateClick: function (info) {
        // console.log(info.dateStr);
        // info.dayEl.style.backgroundColor = 'red';
      },
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function (info) {
      },
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
        right: 'today prev,next',
      },
      customButtons: {
        custom1: {
          text: 'custom 1',
          click: function () {
            alert('clicked custom button 1!');
          }
        },
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
      ]
    });
    calendar.render();

    var tText = '<span style="font-weight: 600">Александр Михайлович!</span><br> Вы что-то не сделали!!!';

    for (var i = 0; i < 2; i++) {
    }

    function initNoty(text) {
      new Noty({
        type: 'warning',
        theme: 'mint',
        text: text,
        progressBar: true,
        timeout: '8000',
        closeWith: ['click'],
        killer: true,
        animation: {
          open: 'animated noty_effects_open noty_anim_out', // Animate.css class names
          close: 'animated noty_effects_close noty_anim_in' // Animate.css class names
        }
      }).show();
    }


    $('#nav-calendar').datepicker({
      inline: true,
      onSelect: function (formattedDate, date, inst) {
        var momentDate = moment(date);
        var fDate = momentDate.format('Y-MM-DD');
        calendar.gotoDate(fDate);
      },
    })

  });

</script>