<?php

use app\assets\BootstrapYearCalendarAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);
BootstrapYearCalendarAsset::register($this);

$this->title = 'Глобальный';
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
      style: 'custom',
      enableContextMenu: true,
      enableRangeSelection: true,
      contextMenuItems: [
        {
          text: 'Обновить',
          click: editEvent
        },
        {
          text: 'Удалить',
          click: deleteEvent
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
      selectRange: function (e) {
        var day = 24 * 60 * 60 * 1000;
        // console.log(((e.endDate - e.startDate) / day) + 1);
        createEvent(e);
      },
      mouseOutDay: function (e) {
        if (e.events.length > 0) {
          $(e.element).popover('hide');
        }
      },
      customDataSourceRenderer: function (elt, date, events) {
        var weight = 0;
        if (events.length == 1) {
          weight = 4;
        }
        else if (events.length <= 3) {
          weight = 2;
        }
        else {
          elt.parent().css('box-shadow', 'inset 0 -4px 0 0 black');
        }
        if (weight > 0) {
          var boxShadow = '';
          for (var i = 0; i < events.length; i++) {
            if (boxShadow != '') {
              boxShadow += ",";
            }
            boxShadow += 'inset 0 -' + (parseInt(i) + 1) * weight + 'px 0 0 ' + events[i].color;
            if (events[i].hType == '3') {
              elt.parent().css('font-weight', 'bold');
              elt.parent().css('font-size', '14px');
              elt.parent().css('color', 'red');
            }
          }
          elt.parent().css('box-shadow', boxShadow);
        }
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
  });

  function createEvent(e) {
    var sDate = e.startDate;
    var eDate = e.endDate;
    // var sDateStr = sDate.getFullYear() + '-' + (sDate.getMonth() + 1) + '-' + sDate.getDate();
    // var eDateStr = eDate.getFullYear() + '-' + (eDate.getMonth() + 1) + '-' + eDate.getDate();
    var sDateStr = sDate.getDate() + '.' + (sDate.getMonth() + 1) + '.' + sDate.getFullYear();
    var eDateStr = eDate.getDate() + '.' + (eDate.getMonth() + 1) + '.' + eDate.getFullYear();

    var c = $.confirm({
      content: function () {
        var self = this;
        return $.ajax({
          url: '/scheduler/events/event-form',
          method: 'get',
          data: {
            startDate: sDateStr,
            endDate: eDateStr
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




</script>