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

?>
<style>
  html, body {
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
  }

  #external-events {
    width: 150px;
    padding: 10px 10px;
    border: 1px solid #ccc;
    background: #eee;
  }

  .demo-topbar + #external-events { /* will get stripped out */
    top: 60px;
  }

  #external-events .fc-event {
    margin: 1em 0;
    cursor: move;
  }

  #calendar-container {
    position: relative;
    z-index: 1;
    margin-left: 200px;
  }

  #calendar {
    max-width: 900px;
    margin: 20px auto;
  }

</style>


<div class="row">
  <div class="col-md-3 col-lg-3" style="margin-bottom: 15px">
    <div id="nav-calendar"></div>
    <div id='external-events'>
      <p>
        <strong>Draggable Events</strong>
      </p>
      <div class='fc-event'>My Event 1</div>
      <div class='fc-event'>My Event 2</div>
      <div class='fc-event'>My Event 3</div>
      <div class='fc-event'>My Event 4</div>
      <div class='fc-event'>My Event 5</div>
      <p>
        <input type='checkbox' id='drop-remove'/>
        <label for='drop-remove'>remove after drop</label>
      </p>
    </div>
  </div>
  <div class="col-md-9 col-lg-9">
    <div id="calendar">

    </div>
  </div>
</div>

<script>

  var calendar, Draggable;

  $(document).ready(function () {

    calendar = FullCalendar.Calendar;
    Draggable = FullCalendarInteraction.Draggable;

    var containerEl = document.getElementById('external-events');
    // initialize the external events
    // -----------------------------------------------------------------
    new Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText
        };
      }
    });

    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid', 'bootstrap'],
      locale: 'ru',
      themeSystem: 'bootstrap',
      weekNumbers: true,
      selectable: true,
      nowIndicator: true,
      slotDuration: '00:30:00',
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

    $('#test').on('click', function () {
      calendar.prevYear();
    });

    var tText = '<span style="font-weight: 600">Внимание!</span><br> Вы что-то не сделали!!!';
    new Noty({
      type: 'warning',
      theme: 'mint',
      text: tText,
      progressBar: true,
      timeout: '8000',
      closeWith: ['click'],
      killer: true,
      animation: {
        open: 'animated noty_effects_open noty_anim_out', // Animate.css class names
        close: 'animated noty_effects_close noty_anim_in' // Animate.css class names
      }
    }).show();


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