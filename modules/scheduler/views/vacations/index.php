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
      <div>
        <div id="title">Сотрудники:</div>
        <div>Военнослужащие:</div>
        <span style="color: blue;">Игнатенко А.М.</span><br>
        <span style="color: green;">Лесин С.Н.</span><br>
        <span style="color: orange;">Веснина Ю.В.</span>
        <div>Гражданские:</div>
        <span style="color: red;">Дубницкая Е.А.</span>
      </div>
    </div>
  </div>
  <div class="col-md-10 col-lg-10">
    <div id="full-calendar"></div>
  </div>
</div>

<script>
  $(document).ready(function () {
    var currentYear = new Date().getFullYear();

    var redDateTime = new Date(currentYear, 2, 13).getTime();
    var circleDateTime = new Date(currentYear, 1, 20).getTime();
    var borderDateTime = new Date(currentYear, 0, 12).getTime();

    var today = new Date(currentYear, 5, 1).getTime();

    $('#full-calendar').calendar({
      language: 'ru',
      enableContextMenu: true,
      enableRangeSelection: true,
      mouseOnDay: function (e) {
        if (e.events.length > 0) {
          var content = '';
          for (var i in e.events) {

            // console.log(e.events[i].color);

            content += '<div class="event-tooltip-content">'
              + '<div class="event-name" style="color: #ff5a35">' + e.events[i].name + '</div>'
              + '<div class="event-location">' + e.events[i].location + '</div>'
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
          $(element).css('background-color', 'red');
          $(element).css('color', 'white');
          $(element).css('border-radius', '15px');
        }
      },
      selectRange: function (e) {
        var day = 24 * 60 * 60 * 1000;
        var diff = ((e.endDate - e.startDate) / day) + 1;
        $('#info-panel').append('<div style="font-size: 20px">' + diff + '</div>')
      },
      dataSource: [
        {
          id: 0,
          name: 'Игнатенко А.М.',
          location: 'Часть отпуска',
          color: 'blue',
          startDate: new Date(currentYear, 0, 21),
          endDate: new Date(currentYear, 1, 13)
        },
        {
          id: 1,
          name: 'Игнатенко А.М.',
          location: 'Часть отпуска',
          color: 'blue',
          startDate: new Date(currentYear, 6, 8),
          endDate: new Date(currentYear, 7, 4)
        },
        {
          id: 2,
          name: 'Игнатенко А.М.',
          location: 'Часть отпуска',
          color: 'blue',
          startDate: new Date(currentYear, 8, 16),
          endDate: new Date(currentYear, 9, 10)
        },
        {
          id: 3,
          name: 'Лесин С.Н.',
          location: 'Часть отпуска',
          color: 'green',
          startDate: new Date(currentYear, 1, 19),
          endDate: new Date(currentYear, 2, 5)
        },
        {
          id: 4,
          name: 'Лесин С.Н.',
          location: 'Часть отпуска',
          color: 'green',
          startDate: new Date(currentYear, 5, 3),
          endDate: new Date(currentYear, 5, 29)
        },
        {
          id: 5,
          name: 'Веснина Ю.В.',
          location: 'Часть отпуска',
          color: 'orange',
          startDate: new Date(currentYear, 2, 14),
          endDate: new Date(currentYear, 2, 25)
        },
        {
          id: 6,
          name: 'Веснина Ю.В.',
          location: 'Часть отпуска',
          color: 'orange',
          startDate: new Date(currentYear, 3, 28),
          endDate: new Date(currentYear, 4, 14)
        },
        {
          id: 7,
          name: 'Веснина Ю.В.',
          location: 'Часть отпуска',
          color: 'orange',
          startDate: new Date(currentYear, 7, 18),
          endDate: new Date(currentYear, 8, 14)
        },
        {
          id: 8,
          name: 'Дубницкая Е.А.',
          location: 'Часть отпуска',
          color: 'red',
          startDate: new Date(currentYear, 9, 10),
          endDate: new Date(currentYear, 10, 18)
        },
      ]


    });

  });

</script>