<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapYearCalendarAsset::register($this);
BootstrapDatepickerAsset::register($this);

$this->title = 'Календарь праздников';
$this->params['breadcrumbs'][] = ['label' => 'Планировщик', 'url' => ['/scheduler']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
  .calendar {
    overflow: visible;
  }
</style>


<div class="main-scheduler row">
  <div class="col-md-12 col-lg-12">
    <div id="full-calendar" data-provide="ec"></div>
  </div>
</div>

<script>

    $(document).ready(function () {
        var currentYear = new Date().getFullYear();
        var todayAll = new Date();
        todayAll.setHours(0, 0, 0, 0);
        var today = todayAll.getTime();

        $('#full-calendar').calendar({
            language: 'ru',
            enableContextMenu: true,
            enableRangeSelection: true,
            contextMenuItems: [
                {
                    text: 'Обновить',
                    click: editVacation
                },
                {
                    text: 'Удалить',
                    click: deleteVacation
                }
            ],
            dayContextMenu: function (e) {
                $(e.element).popover('hide');
            },
            mouseOnDay: function (e) {
                if (e.events.length > 0) {
                    var content = '';
                    for (var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                            + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                            + '<div class="event-location">' + e.events[i].location + ' ' + e.events[i].duration + '</div>'
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
                var c = $.confirm({
                    content: function () {
                        var self = this;
                        return $.ajax({
                            url: '/scheduler/holidays/form',
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
                    title: 'Добавить праздник',
                    buttons: {
                        ok: {
                            btnClass: 'btn-blue',
                            text: 'Сохранить',
                            action: function () {
                                var msg = {};
                                msg.title = $('#holiday-title').val();
                                msg.hType = $('#holiday-type').val();
                                msg.start = $('#start-date').val();
                                msg.end = $('#end-date').val();
                                msg.duration = $('#duration').val();
                                msg.repeat = 0;
                                if ($('#year-repeat').prop('checked')) {
                                    msg.repeat = 1;
                                }
                                msg.description = $('#holiday-description').val();
                                saveHoliday(msg);
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
                    url: "holidays/holidays",
                    type: 'GET',
                    data: {
                        year: currentYear
                    },
                    success: function (dataSource) {
                        if (dataSource != '') {
                            var data = JSON.parse(dataSource);
                            data instanceof Array ? data : [];
                            if (data instanceof Array) {
                                data.forEach(function (el, index, theArray) {
                                    theArray[index].startDate = new Date(el.sYear, el.sMonth, el.sDay);
                                    theArray[index].endDate = new Date(el.eYear, el.eMonth, el.eDay);
                                });
                            } else {
                                data = [];
                            }
                        }
                        $(e.target).data('calendar').setDataSource(data);
                    }
                });
            }
        });

        function saveHoliday(data) {
            var csrf = $('meta[name=csrf-token]').attr("content");
            var currentYear = $('#full-calendar').data('calendar').getYear();
            $.ajax({
                url: '/scheduler/holidays/save-holiday',
                method: 'post',
                data: {
                    _csrf: csrf,
                    msg: data
                }
            }).done(function (response) {
                $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
            }).fail(function () {
                console.log('Что-то пошло не так!');
            });
        }

        function editVacation(event) {
            var currentYear = $('#full-calendar').data('calendar').getYear();
            var eventId = event.id;
            var c = $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: '/scheduler/vacations/update-form',
                        method: 'get',
                        data: {
                            id: eventId
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
                title: 'Обновить отпуск',
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
                            msg.id = eventId;
                            msg.user = $('#user').val();
                            msg.start = $('#start-date').val();
                            msg.end = $('#end-date').val();
                            msg.duration = $('#duration').val();
                            updateVacation(msg);
                        }
                    },
                    cancel: {
                        btnClass: 'btn-red',
                        text: 'Отмена'
                    }
                }
            })
        }

        function updateVacation(data) {
            var csrf = $('meta[name=csrf-token]').attr("content");
            var currentYear = $('#full-calendar').data('calendar').getYear();
            $.ajax({
                url: '/scheduler/vacations/update-vacation',
                method: 'post',
                data: {
                    _csrf: csrf,
                    msg: data
                }
            }).done(function (response) {
                $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
            }).fail(function () {
                console.log('Что-то пошло не так!');
            });
        }


        function deleteVacation(event) {
            var csrf = $('meta[name=csrf-token]').attr("content");
            var currentYear = $('#full-calendar').data('calendar').getYear();
            var eventId = event.id;
            $.ajax({
                url: '/scheduler/vacations/delete-vacation',
                method: 'post',
                data: {
                    _csrf: csrf,
                    id: eventId
                }
            }).done(function (response) {
                $('#full-calendar').data('calendar').setYear(currentYear); // для перезагрузки
            }).fail(function () {
                console.log('Что-то пошло не так!');
            });
        }

    });

</script>