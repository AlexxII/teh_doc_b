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
    <div id="full-calendar" data-provide="ec"></div>
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
              + '<div class="event-location">' + e.events[i].location + ' - ' + e.events[i].duration + '</div>'
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
        var sDate = e.startDate;
        var eDate = e.endDate;
        var sDateStr = sDate.getFullYear() + '-' + (sDate.getMonth() + 1) + '-' + sDate.getDate();
        var eDateStr = eDate.getFullYear() + '-' + (eDate.getMonth() + 1) + '-' + eDate.getDate();
        $('#info-panel').append('<div style="font-size: 20px">' + diff + '</div>');
        var c = $.confirm({
          content: function () {
            var self = this;
            return $.ajax({
              url: '/scheduler/vacations/form',
              method: 'get',
              data: {
                startDate: sDateStr,
                endDate: eDateStr,
                diff: diff
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
          title: 'Добавить отпуск',
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
                msg.user = $('#user').val();
                msg.start = $('#start-date').val();
                msg.end = $('#end-date').val();
                msg.duration = $('#duration').val();
                saveVacation(msg);
              }
            },
            cancel: {
              btnClass: 'btn-red',
              text: 'Отмена'
            }
          }
        })
      },
      yearChanged: function (e) {
        e.preventRendering = true;
        $(e.target).append('<div style="text-align:center"><img src="/lib/3.gif" /></div>');
        var currentYear = e.currentYear;
        $.ajax({
          url: "vacations/vacations-data",
          type: 'GET',
          data: {
            year: currentYear
          },
          success: function (dataSource) {
            var data = JSON.parse(dataSource);
            data.forEach(function (el, index, theArray) {
              // var sDate = element.startDate;
              // var eDate = element.endDate;
              theArray[index].startDate = new Date(el.sYear, el.sMonth, el.sDay);
              theArray[index].endDate = new Date(el.eYear, el.eMonth, el.eDay);
            });
            // data instanceof Array ? console.log('true') : console.log('false');
            $(e.target).data('calendar').setDataSource(data);
          }
        });
      },
    });


    var testData = [{
      id: 0,
      name: 'Игнатенко А.М.',
      location: 'Часть отпуска',
      duration: '20 суток',
      color: 'blue',
      startDate: new Date(currentYear, 0, 21),
      endDate: new Date(currentYear, 1, 13)
    }];

    function saveVacation(data) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      $.ajax({
        url: '/scheduler/vacations/save-vacation',
        method: 'post',
        data: {
          _csrf: csrf,
          msg: data
        }
      }).done(function (response) {

      }).fail(function () {
        console.log('Что-то пошло не так!');
      });
    }



    var td = [
      {
        id: 0,
        name: 'Игнатенко А.М.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'blue',
        startDate: new Date(currentYear, 0, 21),
      endDate: new Date(currentYear, 1, 13)
      },
      {
        id: 1,
        name: 'Игнатенко А.М.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'blue',
        startDate: new Date(currentYear, 6, 8),
      endDate: new Date(currentYear, 7, 4)
      },
      {
        id: 2,
        name: 'Игнатенко А.М.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'blue',
        startDate: new Date(currentYear, 8, 16),
      endDate: new Date(currentYear, 9, 10)
      },
      {
        id: 3,
        name: 'Лесин С.Н.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'green',
        startDate: new Date(currentYear, 1, 19),
      endDate: new Date(currentYear, 2, 5)
      },
      {
        id: 4,
        name: 'Лесин С.Н.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'green',
        startDate: new Date(currentYear, 5, 3),
      endDate: new Date(currentYear, 5, 29)
      },
      {
        id: 5,
        name: 'Веснина Ю.В.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'orange',
        startDate: new Date(currentYear, 2, 14),
      endDate: new Date(currentYear, 2, 25)
      },
      {
        id: 6,
        name: 'Веснина Ю.В.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'orange',
        startDate: new Date(currentYear, 3, 28),
      endDate: new Date(currentYear, 4, 14)
      },
      {
        id: 7,
        name: 'Веснина Ю.В.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'orange',
        startDate: new Date(currentYear, 7, 18),
      endDate: new Date(currentYear, 8, 14)
      },
      {
        id: 8,
        name: 'Дубницкая Е.А.',
        location: 'Часть отпуска',
        duration: '20 суток',
        color: 'red',
        startDate: new Date(currentYear, 9, 10),
      endDate: new Date(currentYear, 10, 18)
      }
    ];

  });

</script>