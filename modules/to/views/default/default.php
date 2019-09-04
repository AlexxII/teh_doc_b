<?php

use yii\helpers\Html;
use app\assets\TableBaseAsset;
use app\modules\to\assets\ToAsset;


ToAsset::register($this);        // регистрация ресурсов модуля
TableBaseAsset::register($this);        // регистрация ресурсов таблиц datatables

$this->title = "Графики ТО";

?>

<style>
  td {
    text-align: center;
  }

  td .fa {
    font-size: 25px;
  }

  #main-table tbody td {
    font-size: 12px;
  }

  #main-table tr {
    font-size: 12px;
  }
</style>


<div class="tool-task">

  <div class="row">
    <div class="container-fluid" style="position: relative">
      <div id="add-scheduler-wrap" style="position: absolute; top: 10px; left:-60px">
        <a id="add-scheduler" class="fab-button ex-click"
           data-url="/to/month-schedule/archive" data-back-url="/to" title="Добавить график ТО" style="cursor: pointer">
          <div class="plus"></div>
        </a>
      </div>
    </div>

    <div class="container-fluid">
      <table id="to-mscheduler-table" class="display no-wrap cell-border" style="width:100%">
        <thead>
        <tr>
          <th data-priority="1">№ п.п.</th>
          <th></th>
          <th data-priority="1">Месяц</th>
          <th data-priority="7">Отметки</th>
          <th>Год</th>
          <th>Объем ТО</th>
          <th>Ответственный за проведение</th>
          <th>Ответственный за контроль</th>
          <th data-priority="2">DO_it</th>
          <th data-priority="3">Action</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {

        $('[data-toggle="tooltip"]').tooltip();

        $('#push-it').removeClass('hidden');
        $('#app-control').removeClass('hidden');

        initLeftMenu('/to/menu/left-side');
        initAppConfig('/to/menu/app-config');


        // ************************* Работа таблицы **************************************

        $.fn.dataTable.pipeline = function (opts) {
            var conf = $.extend({
                pages: 2,     // number of pages to cache
                url: '',      // script url
                data: null,   // function or object with parameters to send to the server
                              // matching how `ajax.data` works in DataTables
                method: 'GET' // Ajax HTTP method
            }, opts);
            var cacheLower = -1;
            var cacheUpper = null;
            var cacheLastRequest = null;
            var cacheLastJson = null;
            return function (request, drawCallback, settings) {
                var ajax = false;
                var requestStart = request.start;
                var drawStart = request.start;
                var requestLength = request.length;
                var requestEnd = requestStart + requestLength;
                if (settings.clearCache) {
                    ajax = true;
                    settings.clearCache = false;
                }
                else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
                    ajax = true;
                }
                else if (JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
                    JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
                    JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
                ) {
                    ajax = true;
                }
                cacheLastRequest = $.extend(true, {}, request);
                if (ajax) {
                    if (requestStart < cacheLower) {
                        requestStart = requestStart - (requestLength * (conf.pages - 1));
                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }
                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);
                    request.start = requestStart;
                    request.length = requestLength * conf.pages;
                    if (typeof conf.data === 'function') {
                        var d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    }
                    else if ($.isPlainObject(conf.data)) {
                        $.extend(request, conf.data);
                    }
                    settings.jqXHR = $.ajax({
                        "type": conf.method,
                        "url": conf.url,
                        "data": request,
                        "dataType": "json",
                        "cache": false,
                        "success": function (json) {
                            cacheLastJson = $.extend(true, {}, json);
                            if (cacheLower != drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            if (requestLength >= -1) {
                                json.data.splice(requestLength, json.data.length);
                            }
                            drawCallback(json);
                        }
                    });
                }
                else {
                    json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);
                    drawCallback(json);
                }
            }
        };
        $.fn.dataTable.Api.register('clearPipeline()', function () {
            return this.iterator('table', function (settings) {
                settings.clearCache = true;
            });
        });

        table = $('#to-mscheduler-table').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                var today = new Date();
                var date = aData[1];
                var important = aData[10];
                var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
                var dt = new Date(date.replace(pattern, '$3-$2-$1'));
                if (important == 1) {
                    $(nRow.cells[0]).css('color', 'red');
                    $(nRow.cells[0]).css('font-weight', '600');
                }
                if (moment().isAfter(dt, 'day')) {
                    $('td', nRow).css('background-color', '#faeeec');
                }
                else if (moment().isSame(dt, 'day')) {
                    $('td', nRow).css('background-color', '#e4f0dc');
                }
            },
            "ajax": $.fn.dataTable.pipeline({
                url: '/to/schedule/server-side?index=0',
                pages: 2, // number of pages to cache
                data: function () {
                    var stDate = $("#start-date").val();
                    var eDate = $("#end-date").val();
                    var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
                    if (stDate == undefined || eDate == undefined) {
                        return {
                            'stDate': '1970-01-01',
                            'eDate': '2099-12-31'
                        }
                    }
                    stDate = stDate.replace(pattern, '$3-$2-$1');
                    eDate = eDate.replace(pattern, '$3-$2-$1');
                    if (stDate != '--') {
                        var startDate = stDate;
                    } else {
                        var startDate = '1970-01-01';
                    }
                    if (eDate != '--') {
                        var endDate = eDate;
                    } else {
                        var endDate = '2099-12-31';
                    }
                    return {
                        'stDate': startDate,
                        'eDate': endDate
                    }
                }
            }),
            orderFixed: [2, 'asc'],
            order: [[4, 'asc'], [3, 'asc']],
            rowGroup: {
                dataSrc: 2
            },
            "columnDefs": [
                {
                    "orderable": false,
                    "targets": -2,
                    "data": null,
                    "width": '70px',
                    "defaultContent":
                    "<a href='#' id='edit' class='fa fa-edit' style='padding-right: 5px' title='Обновить'></a>" +
                    "<a href='#' id='view' class='fa fa-info ' title='Подробности' style='padding-right: 5px'></a>" +
                    "<a href='#' id='confirm-session' class='fa fa-calendar-check-o ' title='Подтвердить сеанс' style='padding-right: 5px'></a>"
                }, {
                    "orderable": false,
                    "className": 'select-checkbox',
                    "targets": -1,
                    "defaultContent": ""
                },
                {
                    "targets": 0,
                    "data": null,
                    "visible": false
                }, {
                    "targets": 2,
                    "visible": false
                }, {
                    "targets": 4,
                    "visible": false
                },
                {
                    "targets": 3,
                    "width": '80px',

                    "render": function (data, type, row) {
                        if (row[3] == '') {
                            return '<strong>' + row[4] + '</strong>' + ' / <strong>Р</strong>';
                        } else if (row[4] == '') {
                            return '<strong>' + row[3] + '</strong>' + ' / <strong>Т</strong>';
                        } else {
                            return '<strong>' + row[3] + '</strong>' +
                                ' / <strong>Т</strong>' + "<br> " +
                                '<strong>' + row[4] + '</strong>' + ' / <strong>Р</strong>';
                        }
                    }
                },
                {
                    "targets": 7,
                    "render": function (data, type, row) {
                        return row[7] + "<br> " + row[8];
                    }
                }, {
                    "targets": 8,
                    "visible": false
                }
            ],
            select: {
                style: 'os',
                selector: 'td:last-child'
            },
            language: {
                url: "/lib/ru.json"
            }
        });

    });


</script>