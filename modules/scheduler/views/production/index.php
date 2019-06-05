<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapYearCalendarAsset::register($this);
BootstrapDatepickerAsset::register($this);

$this->title = 'Производственный календарь';
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
    <div id="info-panel"></div>
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
      displayWeekNumber: true,
      enableRangeSelection: true,
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
        $('#info-panel').html('<div style="font-size: 20px">' + diff + '</div>')
      }
    });

  });

</script>