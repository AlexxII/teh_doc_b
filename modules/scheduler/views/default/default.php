<?php

use app\assets\NotyAsset;
use app\assets\AirDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;
use app\assets\fullcalendar\CalendarInteractionAsset;

NotyAsset::register($this);
CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);
CalendarInteractionAsset::register($this);
AirDatepickerAsset::register($this);

?>


<div class="row">
  <div class="col-md-3 col-lg-3">
    <div id="nav-calendar"></div>
  </div>
  <div class="col-md-9 col-lg-9">
    <div id="calendar">

    </div>
  </div>
</div>

<script>

  var calendar;

  $(document).ready(function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['dayGrid', 'timeGrid', 'interaction'],
      locale: 'ru',
      weekNumbers: true,
      selectable: true,
      nowIndicator:true,
      dateClick: function(info) {
        console.log(info.dateStr);
        console.log(info.jsEvent.pageX);
        console.log(info.jsEvent.pageY);
        console.log(info.view.type);
        info.dayEl.style.backgroundColor = 'red';
      },
      header: {
        left: 'dayGridMonth,timeGridWeek,timeGridDay custom1',
        center: 'title',
        right: 'prevYear,prev,next,nextYear'
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
          daysOfWeek: [ 1, 2, 3, 4], // Monday, Tuesday, Wednesday, Thursday
          startTime: '09:00',
          endTime: '18:15'
        },
        {
          daysOfWeek: [ 5 ], // Friday
          startTime: '09:00',
          endTime: '17:00'
        }
      ]
    });
    calendar.render();

    $('#test').on('click', function () {
      calendar.prevYear();
    });

    var tText = '<span style="font-weight: 600">Александр Михайлович!</span><br> Вы что-то не сделали!!!';
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
      todayButton: true,
      onSelect: function (formattedDate, date, inst) {
        var momentDate = moment(date);
        var fDate = momentDate.format('Y-MM-DD');
        calendar.gotoDate(fDate);
      }
    })

  });

</script>