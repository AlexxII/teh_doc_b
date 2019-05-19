<?php

use app\assets\NotyAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;

NotyAsset::register($this);
BootstrapDatepickerAsset::register($this);
CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);

?>


<div class="row">
  <div class="col-md-3 col-lg-3">
    <?php echo 'Планировщик'; ?>
    <button id="test">1111111</button>
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
      plugins: [ 'dayGrid', 'timeGrid'],
      locale: 'ru',
      weekNumbers: true,
      header: {
        left: '',
        center: '',
        right: ''
      },
      // header: {
      //   left: 'dayGridMonth,timeGridWeek,timeGridDay custom1',
      //   center: 'title',
      //   right: 'prevYear,prev,next,nextYear'
      // },
      customButtons: {
        custom1: {
          text: 'custom 1',
          click: function() {
            alert('clicked custom button 1!');
          }
        },
      }
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

  });

</script>