<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapYearCalendarAsset::register($this);
BootstrapDatepickerAsset::register($this);

$this->title = 'Весь год';
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
    <div id="nav-calendar"></div>
    <button class="btn-primary" href="scheduler/full-year" onclick="test()">Годовой
  </div>
  <div class="col-md-10 col-lg-10">
    <div id="full-calendar"></div>
  </div>
</div>

<script>
  $(document).ready(function () {
    var currentYear = new Date().getFullYear();
    $('#full-calendar').calendar({
      language: 'ru',
      enableContextMenu: true,
      enableRangeSelection: true,
      mouseOnDay: function (e) {
        if (e.events.length > 0) {
          var content = '';
          for (var i in e.events) {

            console.log(e.events[i].color);

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
      dataSource: [
        {
          id: 0,
          name: 'Google I/O',
          location: 'San Francisco, CA',
          startDate: new Date(currentYear, 3, 28),
          endDate: new Date(currentYear, 4, 29)
        },
        {
          id: 1,
          name: 'Microsoft Convergence',
          location: 'New Orleans, LA',
          startDate: new Date(currentYear, 2, 16),
          endDate: new Date(currentYear, 2, 19)
        },
        {
          id: 2,
          name: 'Microsoft Build Developer Conference',
          location: 'San Francisco, CA',
          startDate: new Date(currentYear, 3, 29),
          endDate: new Date(currentYear, 4, 1)
        },
        {
          id: 3,
          name: 'Apple Special Event',
          location: 'San Francisco, CA',
          startDate: new Date(currentYear, 8, 1),
          endDate: new Date(currentYear, 8, 1)
        },
        {
          id: 4,
          name: 'Apple Keynote',
          location: 'San Francisco, CA',
          startDate: new Date(currentYear, 8, 9),
          endDate: new Date(currentYear, 8, 9)
        },
        {
          id: 5,
          name: 'Chrome Developer Summit',
          location: 'Mountain View, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 18)
        },
        {
          id: 6,
          name: 'F8 2015',
          location: 'San Francisco, CA',
          startDate: new Date(currentYear, 2, 25),
          endDate: new Date(currentYear, 2, 26)
        },
        {
          id: 7,
          name: 'Yahoo Mobile Developer Conference',
          location: 'New York',
          startDate: new Date(currentYear, 7, 25),
          endDate: new Date(currentYear, 7, 26)
        },
        {
          id: 8,
          name: 'Android Developer Conference',
          location: 'Santa Clara, CA',
          startDate: new Date(currentYear, 11, 1),
          endDate: new Date(currentYear, 11, 4)
        },
        {
          id: 9,
          name: 'LA Tech Summit',
          location: 'Los Angeles, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 17)
        },
        {
          id: 10,
          name: 'LA Tech Summit_2',
          location: 'Los Angeles, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 17)
        },
        {
          id: 11,
          name: 'LA Tech Summit_3',
          location: 'Los Angeles, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 17)
        },
        {
          id: 12,
          name: 'LA Tech Summit_4',
          location: 'Los Angeles, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 17)
        },
        {
          id: 13,
          name: 'LA Tech Summit_5',
          location: 'Los Angeles, CA',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 17)
        }
      ]
    });

    function test() {
      var data = [
        {
          id: 5,
          name: 'TEST MEEEEEEEEEE',
          location: 'eeeeeeee',
          startDate: new Date(currentYear, 10, 17),
          endDate: new Date(currentYear, 10, 18)
        }
      ];

      $('#full-calendar').data('calendar').setDataSource(data);

    }
  });


</script>