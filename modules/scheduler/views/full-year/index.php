<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);
BootstrapYearCalendarAsset::register($this);

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
    <button class="btn-primary" href="scheduler/full-year" onclick="test()">Годовой</button>
    <br>
    <span style="color: green">Лесин С.Н.</span>
    <br>
    <span style="color: red">Игнатенко А.М.</span>
    <br>
    <span style="color: blue">Вестина Ю.В.</span>
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
                    color: 'red',
                    name: 'Игнтенко А.М.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 0, 21),
                    endDate: new Date(currentYear, 1, 9)
                },
                {
                    id: 1,
                    color: 'red',
                    name: 'Игнатенко А.М.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 6, 8),
                    endDate: new Date(currentYear, 7, 6)
                },
                {
                    id: 1,
                    color: 'red',
                    name: 'Игнатенко А.М.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 8, 16),
                    endDate: new Date(currentYear, 9, 10)
                },
                {
                    id: 2,
                    color: 'green',
                    name: 'Лесин С.Н.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 1, 15),
                    endDate: new Date(currentYear, 2, 1)
                },
                {
                    id: 3,
                    color: 'green',
                    name: 'Лесин С.Н.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 5, 3),
                    endDate: new Date(currentYear, 6, 2)
                },
                {
                    id: 4,
                    color: 'green',
                    name: 'Лесин С.Н.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 10, 1),
                    endDate: new Date(currentYear, 10, 15)
                },
                {
                    id: 5,
                    color: 'blue',
                    name: 'Веснина Ю.В.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 2, 1),
                    endDate: new Date(currentYear, 2, 15)
                },
                {
                    id: 5,
                    color: 'blue',
                    name: 'Веснина Ю.В.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 4, 13),
                    endDate: new Date(currentYear, 5, 9)
                },
                {
                    id: 5,
                    color: 'blue',
                    name: 'Веснина Ю.В.',
                    location: 'Часть отпуска',
                    startDate: new Date(currentYear, 8, 9),
                    endDate: new Date(currentYear, 8, 25)
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