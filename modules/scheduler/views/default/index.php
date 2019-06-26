<?php

use app\assets\NotyAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\fullcalendar\CalendarDaygridAsset;
use app\assets\fullcalendar\CalendarTimegridAsset;
use app\assets\fullcalendar\CalendarInteractionAsset;
use app\assets\fullcalendar\CalendarBootstrapAsset;

NotyAsset::register($this);
CalendarDaygridAsset::register($this);
CalendarTimegridAsset::register($this);
CalendarInteractionAsset::register($this);
CalendarBootstrapAsset::register($this);
BootstrapDatepickerAsset::register($this);

$this->title = 'Планировщик';
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .main-scheduler {
    margin-top: 20px;
  }
  table.table-bordered > tbody > tr > td:nth-of-type(1) {
    /*background-color: #0a0a0a;*/
  }
  .fc-week-number {
    background-color: #e2e2e2;
  }
  .past div.fc-time, .past div.fc-title {
    text-decoration: line-through;
  }
  .datepicker {
    z-index: 999999999;
  }
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
  }
  .holiday {
    background-color: #df5000;
  }
  .cool-title {
    font-size: 25px;
  }
  .fc-more-popover {
    background-color: white;
  }
  .wrapper-class {
    display: flex;
    flex-direction: row;
  }
  .fc-calendar-button {
    font-size: 10px;
    background-color: #fff;
    border: 1px solid grey;
    color: #000;
  }

  .fc-navigation-button {
    font-size: 10px;
    background-color: #fff;
    border: 1px solid grey;
    color: #000;
  }

  .btn-primary:focus, .btn-primary.focus {
    background-color: #fff;
  }

  .btn-primary:active:focus {
    background-color: #fff;
  }

  .btn-primary:active, .btn-primary.active {
    background-color: lightgrey;

  }

  .btn-primary:active:hover {
    background-color: #fff;
  }

  .btn-primary.disabled:hover,
  .btn-primary[disabled]:hover,
  fieldset[disabled] .btn-primary:hover,
  .btn-primary.disabled:focus, .btn-primary[disabled]:focus,
  fieldset[disabled] .btn-primary:focus, .btn-primary.disabled.focus,
  .btn-primary[disabled].focus, fieldset[disabled] .btn-primary.focus {
    font-size: 10px;
    background-color: lightgrey;
    border: 1px solid grey;
    color: #000;
  }


  .btn-primary.disabled:visited,
  .btn-primary[disabled]:visited,
  fieldset[disabled] .btn-primary:visited {
    background-color: red;
  }

  .btn-primary.disabled:visited,
  .btn-primary[disabled]:visited,
  fieldset[disabled] .btn-primary:visited {
    background-color: #fff;
  }


  .btn-primary:hover  {
    font-size: 10px;
    background-color: rgba(211, 211, 211, 0.21);
    color: #000;
  }

  .fc-today-button:hover {
    font-size: 10px;
    background-color: lightgrey;
    border: 1px solid grey;
    color: #000;
  }

  #calendar .btn {
    color: #000;
  }

  #calendar .fc-left .fa {
    font-size: 10px;
    color: #5f6368;
  }

  .fc-prev-button {
    font-size: 10px;
    background-color: #fff;
    border: 0px;
  }

  .fc-next-button {
    font-size: 10px;
    background-color: #fff;
    border: 0px;
  }

  .fc-today-button {
    font-size: 10px;
    background-color: #fff;
    border: 1px solid grey;
  }

  .fc-left h2 {
    float: right;
  }


</style>


<div class="main-scheduler">
  <!--  <div class="col-md-2 col-lg-2" style="margin-bottom: 15px">-->
  <!--    <div id="nav-calendar"></div>-->
  <!--  </div>-->
  <div>
    <div id="calendar"></div>
  </div>
</div>

<script>


  $(document).ready(function () {
    $('#nav-calendar').datepicker({
      language: 'ru'
    });
  });

  function showDialog(event) {
    c = $.confirm({
      content: function () {
        var self = this;
        return $.ajax({
          url: '/scheduler/events/calendars-array',
          method: 'get'
        }).done(function (response) {
          // console.log(response);
        }).fail(function () {
          self.setContentAppend('<div>Что-то пошло не так!</div>');
        });
      },
      contentLoaded: function (data, status, xhr) {
        this.setContentAppend('<div>' + data + '</div>');
      },
      type: 'blue',
      columnClass: 'medium',
      title: 'Подробности',
      buttons: {
        ok: {
          btnClass: 'btn-blue',
          text: 'ОК',
          action: function () {
            c.close();
          }
        },
        cancel: {
          text: 'НАЗАД'
        }
      },
    })

  }

  var calendar, Draggable, navCalendar, c;
  var calInput = '<input class="form-control" id="nav-calendar" placeholder="Выберите дату" onclick="calendarShow(this)">';

  var csrf = $('meta[name=csrf-token]').attr("content");

  var fcSources = {
    vks: {
      id: '1111',
      url: '/scheduler/events/vks-data',
      method: 'POST',
      extraParams: {
        _csrf: csrf
      },
      failure: function () {
        console.log('Внимание! Ошибка получения сеансов ВКС!');
      },
      color: 'green',   // a non-ajax option
      textColor: 'white' // a non-ajax optio
    },
    to: {
      url: '/scheduler/events/to-data',
      method: 'POST',
      extraParams: {
        _csrf: csrf
      },
      failure: function () {
        console.log('Внимание! Ошибка получения графиков ТО!');
      },
      color: 'green',   // a non-ajax option
      textColor: 'white' // a non-ajax optio
    },
    events: {
      url: '/scheduler/events/events-data',
      method: 'POST',
      extraParams: {
        _csrf: csrf
      },
      failure: function () {
        console.log('Внимание! Ошибка получения событий!');
      },
      color: 'green',   // a non-ajax option
      textColor: 'white' // a non-ajax optio
    },
    holidays: {
      url: '/scheduler/events/holidays-data',
      method: 'POST',
      extraParams: {
        _csrf: csrf
      },
      failure: function () {
        console.log('Внимание! Ошибка получения событий!');
      },
      // color: 'green',   // a non-ajax option
      textColor: 'white' // a non-ajax optio
    }
  };

  $(document).ready(function () {

    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'timeGrid', 'bootstrap'],
      locale: 'ru',
      themeSystem: 'bootstrap',
      weekNumbers: true,
      selectable: true,
      nowIndicator: true,
      slotDuration: '00:15:00',
      minTime: '06:00:00',
      navLinks: true,
      eventLimit: true,
      eventSources: [
        fcSources.vks,
        fcSources.to,
        fcSources.events,
        fcSources.holidays,
      ],
      header: {
        // left: 'dayGridMonth,timeGridWeek,timeGridDay, custom1, custom3',
        left: 'today prev next title',
        // center: 'title',
        right: 'calendar navigation'
      },
      customButtons: {
        navigation: {
          text: 'Навигация',
          click: function () {
            navCalendar = $.confirm({
              title: 'Установка даты',
              content: calInput,
              buttons: {
                cancel: {
                  btnClass: 'btn-red',
                  text: 'Отмена'
                }
              }
            })
          }
        },
        custom3: {
          text: 'Фильтр',
          click: function () {
            // calendar.changeView('dayGridMonth');
            // calendar.addEventSource(fcSources.vks);
            // var eb = calendar.getEventSourceById(1111);
            // eb.remove();
          }
        },
        calendar: {
          text: 'Календари',
          click: function (e) {
            showDialog(e);
          }
        },
        custom2: {
          text: 'ГОД',
          click: function () {
            $('.fc-view-container').html('');
            $.ajax({
              url: '/scheduler/full-year/test',
              method: 'get',
            }).done(function (resp) {
              $('.fc-view-container').html(resp);
            }).fail(function () {
              self.setContentAppend('<div>Что-то пошло не так!</div>');
            });
          }
        }
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
      ],
      showNonCurrentDates: true,

      //========================= rendering ==================================
      eventRender: function (info) {
        var ntoday = new Date();
        if (info.event._def.rendering == 'background') {
          var type = info.event._def.extendedProps.holiday_type;
          if (type == 0) {
            $(info.el).css('background-color', '#E0FFFF');
          } else if (type == 1 || type == 2) {
            $(info.el).css('background-color', '#FFA07A');
          } else {
            $(info.el).css('background-color', '#ff5a35');
          }
        }
      },
      dayRender: function (dayRenderInfo) {
      },

      //========================= actions =====================================

      select: function (info) {
        var c = $.confirm({
          content: function () {
            var self = this;
            return $.ajax({
              url: '/scheduler/events/event-form',
              method: 'get',
              data: {
                startDate: info.startStr,
                endDate: info.endStr
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
          title: 'Добавить событие',
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
                msg.title = $('#event-title').val();
                msg.start = $('#start-date').val();
                msg.end = $('#end-date').val();
                msg.desc = $('#event-description').val();
                msg.color = $('#colorpicker').val();
                var q = saveEvent(msg);
              }
            },
            cancel: {
              btnClass: 'btn-red',
              text: 'Отмена'
            }
          },
          onContentReady: function () {
            var self = this;
            this.buttons.ok.disable();
            this.$content.find('#event-title').on('keyup mouseclick', function () {
              if ($(this).val() != '') {
                self.buttons.ok.enable();
              } else {
                self.buttons.ok.disable();
              }
            });
          }
        })
      },

      //========================= events =======================================
      eventClick: function (info) {
        info.jsEvent.preventDefault();
        if (info.event.extendedProps) {
          var url = info.event.url;
          var urlText = info.event.extendedProps.exUrl;
          var ar = urlText.split('/');
          var req = ar[0];
          var ident = ar[1];
          c = $.confirm({
            content: function () {
              var self = this;
              return $.ajax({
                url: '/scheduler/events/' + req,
                method: 'get',
                data: {
                  i: ident
                }
              }).done(function (response) {
                // console.log(response);
              }).fail(function () {
                self.setContentAppend('<div>Что-то пошло не так!</div>');
              });
            },
            contentLoaded: function (data, status, xhr) {
              this.setContentAppend('<div>' + data + '</div>');
            },
            type: 'blue',
            columnClass: 'medium',
            title: 'Подробности',
            buttons: {
              ok: {
                btnClass: 'btn-blue',
                text: 'К СОБЫТИЮ',
                action: function () {
                  window.open(url);
                }
              },
              edit: {
                btnClass: 'btn-blue',
                text: 'Обновить',
                action: function () {
                  editEvent(ident);
                }
              },
              del: {
                btnClass: 'btn-red',
                text: 'Удалить',
                action: function () {
                  deleteEvent(ident)
                }
              },
              cancel: {
                text: 'НАЗАД'
              }
            },
            onContentReady: function () {
              var self = this;
              if (req == 'sub-event') {
                this.buttons.ok.hide();
              } else {
                this.buttons.del.hide();
                this.buttons.edit.hide();
              }
              this.$content.find('#event-title').on('keyup mouseclick', function () {
                if ($(this).val() != '') {
                  self.buttons.ok.enable();
                } else {
                  self.buttons.ok.disable();
                }
              });
            }
          })
        }
      }
    });
    calendar.render();
  });

  function calendarShow(e) {
    var id = $(e).attr('id');
    $('#' + id).datepicker({
      autoclose: true,
      language: "ru",
    }).data('datepicker');
    $('#' + id).datepicker('show');
    $('#' + id).datepicker()
      .on('hide', function (e) {
        var momentDate = moment(e.date);
        var fDate = momentDate.format('Y-MM-DD');
        calendar.gotoDate(fDate);
        navCalendar.close();
      });
  }

  function saveEvent(data) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    $.ajax({
      url: '/scheduler/events/save-event',
      method: 'post',
      data: {
        _csrf: csrf,
        msg: data
      }
    }).done(function (response) {
      calendar.refetchEvents();
    }).fail(function () {
      console.log('Что-то пошло не так!');
    });
  }

  function editEvent(id) {
    var url = '/scheduler/events/update-event';
    $.confirm({
      content: function () {
        var self = this;
        return $.ajax({
          url: url,
          method: 'get',
          data: {
            id: id
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
      title: 'Обновить событие',
      buttons: {
        ok: {
          btnClass: 'btn-blue',
          text: 'Обновить',
          action: function () {
            var msg = {};
            var title = $('#event-title').val();
            if (title == '') {
              return;
            }
            msg.title = $('#event-title').val();
            msg.start = $('#start-date').val();
            msg.end = $('#end-date').val();
            msg.desc = $('#event-description').val();
            msg.color = $('#colorpicker').val();
            updateEvent(msg, id);
          }
        },
        cancel: {
          btnClass: 'btn-red',
          text: 'Отмена'
        }
      },
      onContentReady: function () {
        var self = this;
        this.buttons.ok.disable();
        this.$content.find('#event-title').on('keyup mouseclick', function () {
          if ($(this).val() != '') {
            self.buttons.ok.enable();
          } else {
            self.buttons.ok.disable();
          }
        });
      }
    })
  }

  function updateEvent(msg, id) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    $.ajax({
      url: '/scheduler/events/save-updated-event',
      method: 'post',
      data: {
        _csrf: csrf,
        id: id,
        msg: msg
      }
    }).done(function (response) {
      calendar.refetchEvents();
    }).fail(function () {
      console.log('Что-то пошло не так!');
    });
  }

  function deleteEvent(id) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    var url = '/scheduler/events/delete-event';
    jc = $.confirm({
      icon: 'fa fa-question',
      title: 'Вы уверены?',
      content: 'Вы действительно хотите удалить событие?',
      type: 'red',
      closeIcon: false,
      autoClose: 'cancel|9000',
      buttons: {
        ok: {
          btnClass: 'btn-danger',
          action: function () {
            jc.close();
            deleteProcess(url, id);
          }
        },
        cancel: {
          action: function () {
            return;
          }
        }
      }
    });
  }

  function deleteProcess(url, id) {
    var csrf = $('meta[name=csrf-token]').attr("content");
    jc = $.confirm({
      icon: 'fa fa-cog fa-spin',
      title: 'Подождите!',
      content: 'Ваш запрос выполняется!',
      buttons: false,
      closeIcon: false,
      confirmButtonClass: 'hide'
    });
    $.ajax({
      url: url,
      method: 'post',
      dataType: "JSON",
      data: {
        event: id,
        _csrf: csrf
      }
    }).done(function (response) {
      if (response != false) {
        jc.close();
        jc = $.confirm({
          icon: 'fa fa-thumbs-up',
          title: 'Успех!',
          content: 'Ваш запрос выполнен.',
          type: 'green',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-success',
              action: function () {
                calendar.refetchEvents();
              }
            }
          }
        });
      } else {
        jc.close();
        jc = $.confirm({
          icon: 'fa fa-exclamation-triangle',
          title: 'Неудача!',
          content: 'Запрос не выполнен. Что-то пошло не так.',
          type: 'red',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-danger',
              action: function () {
              }
            }
          }
        });
      }
    }).fail(function () {
      jc.close();
      jc = $.confirm({
        icon: 'fa fa-exclamation-triangle',
        title: 'Неудача!',
        content: 'Запрос не выполнен. Что-то пошло не так.',
        type: 'red',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|4000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
            }
          }
        }
      });
    });
  }


  // ================================ Оповещенияя =====================================

  var tText = '<span style="font-weight: 600"></span><br> Вы что-то не сделали!!!';

  for (var i = 0; i < 1; i++) {
    // initNoty(tText);
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


</script>