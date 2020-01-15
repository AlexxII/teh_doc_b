<?php

use app\assets\TableBaseAsset;
use app\modules\polls\asset\PollAsset;
use app\assets\NotyAsset;
use app\assets\SortableJSAsset;
use app\assets\NprogressAsset;
use app\assets\Select2Asset;

PollAsset::register($this);
TableBaseAsset::register($this);                // регистрация ресурсов таблиц datatables
NotyAsset::register($this);
SortableJSAsset::register($this);
NprogressAsset::register($this);
Select2Asset::register($this);

?>

<div class="tool-task">
  <div class="" style="position: relative">
    <div class="container-fluid" style="position: relative">
      <div id="add-poll-wrap" class="hidden-xs hidden-sm">
        <a id="add-poll" class="fab-button"
           data-url="/poll/polls/create" data-back-url="/to" title="Добавить новый опрос">
          <div class="plus"></div>
        </a>
      </div>
    </div>

    <div id="delete-wrap" style="position: absolute; top: 10px; right:-60px;display: none ;fill: white">
      <a id="del-wrap" class="fab-button" title="Удалить выделенный опроc"
         style="cursor: pointer; background-color: red">
        <svg width="50" height="50" viewBox="-1 -1 24 24">
          <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
          <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
        </svg>
      </a>
    </div>

    <div id="construct-wrap" style="position: absolute; top: 70px; right:-60px;display: none;fill: white">
      <a id="del-wrap" class="fab-button" title="Редактировать выделенный опрос"
         style="cursor: pointer; background-color: green;padding-left: 10px;padding-top: 7px ">
        <svg viewBox="0 0 535.806 535.807" width="35" height="35">
          <g>
            <path d="M 440.956 373.932 c -11.934 -13.158 -26.315 -19.584 -44.676 -19.584 h -38.686 l -25.398 -24.479 c
            -18.666 15.3 -41.31 24.174 -65.791 24.174 c -22.95 0 -44.676 -7.956 -62.424 -21.726 l -22.645 21.726 h
            -40.262 c -20.502 0 -36.414 7.038 -48.96 21.421 c -36.414 42.227 -30.294 132.498 -27.54 160.344 h 407.592
            C 474.31 507.654 477.982 415.242 440.956 373.932 Z"/>
            <path d="M 160.343 182.376 c -7.344 6.12 -12.24 15.912 -12.24 27.234 c 0 16.83 11.016 30.6 25.092 33.048 c
            3.06 25.398 13.464 47.736 29.07 64.26 c 3.365 3.366 6.731 6.732 10.403 9.486 c 4.591 3.672 9.486 6.732
            14.688 9.486 c 11.628 6.119 24.479 9.485 38.25 9.485 c 13.77 0 26.623 -3.366 38.25 -9.485 c 5.202 -2.754
            10.098 -5.814 14.688 -9.486 c 3.673 -2.754 7.038 -6.12 10.404 -9.486 c 15.3 -16.523 26.01 -38.556 28.764
            -63.954 c 0.307 0 0.612 0 0.918 0 c 16.9219 0 29.07 -14.994 29.07 -33.354 c 0 -11.322 -4.896 -21.114 -12.24
            -27.234H 160.343 L 160.343 182.376 Z"/>
            <path d="M 377.409 118.116 c -9.486 -31.518 -34.578 -63.648 -66.402 -80.172 v 71.91 v 9.792 c 0 0.612 0
            0.918 0 1.224 c -0.306 3.366 -0.918 6.426 -2.447 9.486 c -3.979 7.65 -11.935 13.158 -21.114 13.158 h -4.896
             h -33.66 c -8.568 0 -16.219 -4.59 -20.196 -11.322 c -1.836 -2.754 -2.754 -5.813 -3.366 -9.18 c -0.306
             -1.224 -0.306 -2.142 -0.306 -3.366 v -8.568 v -73.44 c -31.824 16.83 -56.916 48.96 -66.402 80.478 l -2.142
             6.732 h -17.442 v 38.25 h 19.278 h 26.928 h 11.322 h 147.493 h 11.016 h 41.7 v -1.836 v -36.414 h -17.22
             L 377.409 118.116 Z"/>
            <path d="M 248.777 134.028 h 38.25 c 5.508 0 10.098 -3.06 12.546 -7.65 c 1.224 -2.142 1.836 -4.284 1.836
            -6.732 v -2.754 V 105.57 V 33.354 V 22.95 v -3.978 c 0 -2.448 -0.612 -4.59 -1.224 -6.732 C 297.432 5.202
            290.394 0 282.438 0 h -33.661 c -7.344 0 -13.464 5.508 -14.076 12.546 c 0 0.612 -0.306 1.224 -0.306 1.836
            v 8.568 v 10.404 v 73.44 v 11.628 v 1.224 c 0 3.06 0.918 5.814 2.448 8.262 C 239.598 131.58 243.881 134.028
            248.777 134.028 Z"/>
          </g>
        </svg>
      </a>
    </div>


    <div class="container-fluid">
      <table id="poll-main-table" class="display no-wrap cell-border poll-table" style="width:100%">
        <thead>
        <tr>
          <th></th>
          <th data-priority="1">№ п.п.</th>
          <th data-priority="1">Код</th>
          <th data-priority="7">Наименование</th>
          <th>Период</th>
          <th></th>
          <th>Выборка</th>
          <th data-priority="3">Action</th>
          <th></th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<div class="hidden">
  <div id="question-main-template" class="question-wrap">
    <div class="question-content">
      <h2 class="question-data">
        <span class="question-number"></span>
        <span class="question-title"></span>
      </h2>
      <div class="question-service-area">
        <div class="question-hide question-service-btn" title="Скрыть для заполнения" data-id="">
          <svg width="20" height="20" viewBox="0 0 24 24">
            <path fill="none" d="M0 0h24v24H0V0z"></path>
            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
                17.59 13.41 12 19 6.41z"></path>
          </svg>
        </div>
        <div class="question-options question-service-btn dropdown-anywhere" data-menu="question-extension-menu">
          <svg width="20" height="20" viewBox="0 0 24 24">
            <path fill="none" d="M0 0h24v24H0V0z"></path>
            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
                2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
          </svg>
        </div>
        <span class="question-limit question-service-btn" title="Максимальное количество ответов"> </span>
      </div>

      <div class="answers-content">
      </div>
    </div>
  </div>

  <div id="answer-template" class="list-group-item answer-data">
    <div class="answer-about-area">
      <span class="answer-number"></span>
      <span class="answer-title"></span>
    </div>

    <div class="answer-service-area">
      <span class="answer-hide answer-service-btn">
        <svg width="20" height="20" viewBox="0 0 24 24">
          <path fill="none" d="M0 0h24v24H0V0z"></path>
          <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19
          17.59 13.41 12 19 6.41z"></path>
        </svg>
      </span>
      <span class="answer-options answer-service-btn dropdown-anywhere" data-menu="answer-extension-menu">
        <svg width="20" height="20" viewBox="0 0 24 24">
          <path fill="none" d="M0 0h24v24H0V0z"></path>
          <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
          2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
        </svg>
      </span>
      <span class="answer-options answer-service-btn dropdown-anywhere" data-menu="answer-extension-menu">
        <svg width="20" height="20" viewBox="0 0 24 24">
          <path fill="none" d="M0 0h24v24H0V0z"></path>
          <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9
          2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"></path>
        </svg>
      </span>
    </div>
  </div>

  <div id="gridview-template" class="grid-item" data-id="">
    <div class="grid-content">
      <span class="question-order"></span><span class="dot">.</span>
      <span class="question-title"></span>
    </div>
  </div>

</div>

<script>
    var pollTable;

    $(document).ready(function (e) {

        NProgress.configure({showSpinner: false});
        NProgress.start();
        setTimeout(() => NProgress.done(), 1300);

        initLeftMenu('/polls/menu/left-side');
        initAppConfig('/polls/menu/app-config');

        controlCallback = function () {
            return;
        };
        // процедуры возврата из второстепенного контента
        returnCallback = function () {
            pollTable.ajax.reload();
        };

        // ************************* Работа таблицы **************************************

        var editBtn = '<a href="#" id="edit" class="fa fa-edit" style="padding-right: 5px" title="Обновить"></a>';
        var infoBtn = '<a href="#" id="view" class="fa fa-info" ' +
            ' title="Подробности" data-url="/to/month-schedule/view" data-back-url="/to" style="padding-left: 5px"></a>';

        pollTable = $('#poll-main-table').DataTable({
            'processing': true,
            'responsive': true,
            'ajax': {
                'url': '/polls/polls/index'
            },
            'columns': [
                {'data': 'id'},
                {'data': 'year'},
                {'data': 'code'},
                {'data': 'title'},
                {'data': 'start_date'},
                {'data': 'end_date'},
                {'data': 'sample'},
                {'data': ''},
                {'data': ''}
            ],
            'searching': false,
            'fnRowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var date = aData.start_date;
                var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
                $('td:nth-child(6)', nRow).html(editBtn + infoBtn);
            },
            orderFixed: [[1, 'desc']],
            order: [[1, 'desc']],
            rowGroup: {
                dataSrc: 'year'
            },
            'columnDefs': [
                {
                    'targets': -2,                    // предпоследний столбец
                    'orderable': false,
                    'data': null,
                    'width': '70px',
                    'defaultContent': ''
                }, {
                    'targets': -1,                    // последний столбец
                    'orderable': false,
                    'className': 'select-checkbox',
                    'defaultContent': ''
                }, {
                    'targets': 0,
                    'data': null,
                    'visible': false
                }, {
                    'targets': 2,
                    'render': function (data, type, row) {
                        return '<span class="poll-in" data-id="' + row['id'] + '"><strong>' + row['code'] + '</strong></span>';
                    }
                }, {
                    'targets': 3,
                    'render': function (data, type, row) {
                        return '<span class="poll-in" data-id="' + row['id'] + '"><strong>' + row['title'] + '</strong></span>';
                    }
                }, {
                    'targets': 5,
                    'visible': false
                }, {
                    'targets': 4,
                    'render': function (data, type, row) {
                        var pattern = /(\d{4})\-(\d{2})\-(\d{2})/;

                        return row['start_date'].replace(pattern, '$3.$2.$1') +
                            "<br> " +
                            row['end_date'].replace(pattern, '$3.$2.$1');
                    }
                }
            ],
            select: {
                style: 'single',
                selector: 'td:last-child',
            },
            language: {
                url: '/lib/ru.json'
            }
        });

        pollTable.on('order.dt search.dt', function () {
            pollTable.column(1, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        // Работа таблицы -> событие выделения и снятия выделения

        pollTable.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                $('#delete-wrap').show();
                $('#construct-wrap').show();
            }
        });
        pollTable.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                if (pollTable.rows({selected: true}).count() > 0) return;
                $('#delete-wrap').hide();
                $('#construct-wrap').hide();
            }
        });

        // Работа таблицы -> перерисовка или изменение размера страницы

        pollTable.on('length.dt', function (e, settings, len) {
            pollTable.rows().deselect();
            $('#delete-wrap').hide();
            $('#construct-wrap').hide();
        });

        pollTable.on('draw.dt', function (e, settings, len) {
            pollTable.rows().deselect();
            $('#delete-wrap').hide();
            $('#construct-wrap').hide();
        });

        $('#delete-wrap').click(function (event) {
            event.preventDefault();
            var csrf = $('meta[name=csrf-token]').attr("content");
            var url = "/polls/polls/delete";
            if ($(this).attr('disabled')) {
                return;
            }
            jc = $.confirm({
                icon: 'fa fa-question',
                title: 'Вы уверены?',
                content: 'Вы действительно хотите удалить выделенное?',
                type: 'red',
                closeIcon: false,
                autoClose: 'cancel|9000',
                buttons: {
                    ok: {
                        btnClass: 'btn-danger',
                        action: function () {
                            jc.close();
                            deleteProcess(url, pollTable, csrf);
                        }
                    },
                    cancel: {
                        action: function () {
                            return;
                        }
                    }
                }
            });
        });

        pollTable.on('click', '#edit', function (e) {
            e.preventDefault();
            var data = pollTable.row($(this).parents('tr')).data();
            var url = "/polls/polls/update-poll?id=" + data['id'];
            c = $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: url,
                        method: 'get'
                    }).fail(function () {
                        self.setContentAppend('<div>Что-то пошло не так!</div>');
                    });
                },
                contentLoaded: function (data, status, xhr) {
                    this.setContentAppend('<div>' + data + '</div>');
                },
                type: 'blue',
                columnClass: 'large',
                title: 'Обновление сведений об опросе',
                buttons: {
                    ok: {
                        btnClass: 'btn-blue',
                        text: 'Обновить',
                        action: function () {
                            var $form = $("#w0"),
                                data = $form.data("yiiActiveForm");
                            $.each(data.attributes, function () {
                                this.status = 3;
                            });
                            $form.yiiActiveForm("validate");
                            if ($("#w0").find(".has-error").length) {
                                return false;
                            } else {
                                var startDate = $('.start-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                                $('.start-date').val(startDate);
                                var endDate = $('.end-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                                $('.end-date').val(endDate);
                                var yText = '<span style="font-weight: 600">Успех!</span><br>Сведения об опросе обновлены';
                                var nText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Обновить не удалось';
                                sendPollFormData(url, pollTable, $form, xmlData, yText, nText);
                            }
                        }
                    },
                    cancel: {
                        text: 'НАЗАД'
                    }
                }
            });
        });

        pollTable.on('click', '#view', function (e) {
            e.preventDefault();
            var data = pollTable.row($(this).parents('tr')).data();
            var url = "/polls/polls/view-poll?id=" + data['id'];
            c = $.confirm({
                content: function () {
                    var self = this;
                    return $.ajax({
                        url: url,
                        method: 'get'
                    }).fail(function () {
                        self.setContentAppend('<div>Что-то пошло не так!</div>');
                    });
                },
                contentLoaded: function (data, status, xhr) {
                    this.setContentAppend('<div>' + data + '</div>');
                },
                type: 'blue',
                columnClass: 'xlarge',
                title: 'Подробности',
                buttons: {
                    cancel: {
                        text: 'НАЗАД'
                    }
                }
            });
        });
    });

    function deleteProcess(url, table, csrf) {
        var data = table.rows({selected: true}).data();
        var id = data[0].id;
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
            data: {pollId: id, _csrf: csrf}
        }).done(function (response) {
            if (response != false) {
                jc.close();
                var text = 'Опрос удален полностью!';
                var yText = '<span style="font-weight: 600">Успех!</span><br>' + text;
                initNoty(yText, 'success');
                table.ajax.reload();
            } else {
                jc.close();
                var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Удалить опрос не удалось';
                initNoty(tText, 'warning');
            }
        }).fail(function () {
            jc.close();
            var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Удалить опрос не удалось';
            initNoty(tText, 'warning');
        });
    }


</script>