<?php

use yii\helpers\Html;

$this->title = 'Перечень всего оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

$about = 'На представленные данные опирается все приложение.
Корректность этих данных - залог успешной работы системы.';
$add_hint = 'Добавить оборудование';
$dell_hint = 'Удалить выделенное оборудование';
$classif_hint = 'Присвоить выделенному оборудованию пользовательский классификатор';


?>
<div class="to-schedule-archive">

  <h3><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-info-circle" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup></h3>

</div>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
</style>


<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 20px">
      <?= Html::a('Добавить',
          ['create'], [
              'class' => 'btn btn-success btn-sm',
              'style' => ['margin-top' => '5px'],
              'data-toggle' => "tooltip",
              'data-placement' => "top",
              'title' => $add_hint,
          ]) ?>
      <?= Html::a('Удалить',
          [''], [
              'class' => 'btn btn-danger btn-sm hiddendel',
              'style' => ['margin-top' => '5px', 'display' => 'none'],
              'data-toggle' => "tooltip",
              'data-placement' => "top",
              'title' => $dell_hint,
          ]) ?>
      <?= Html::a('Классиф-тор',
          [''], [
              'class' => 'btn btn-info btn-sm classif',
              'style' => ['margin-top' => '5px', 'display' => 'none'],
              'data-toggle' => "tooltip",
              'data-placement' => "top",
              'title' => $classif_hint,
          ]) ?>
    </div>
  </div>

  <div class="container-fluid">
    <?php

    echo '
        <table id="main-table" class="display no-wrap cell-border" style="width:100%">
          <thead>
            <tr>
              <th></th>
              <th >Наименование</th>
              <th >Производитель</th>
              <th >Модель</th>
              <th >s/n</th>
              <th >Дата производства</th>
              <th >Количество</th>
              <th data-priority="3">Action</th>
              <th></th>
            </tr>
          </thead>
        </table>';
    ?>
  </div>

  <input class="csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" style="display: none">
</div>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // ************************* Работа таблицы **************************************

    $(document).ready(function () {
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
    });

    $(document).ready(function () {
        var table = $('#main-table').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "ajax": $.fn.dataTable.pipeline({
                url: '/tehdoc/equipment/complex/tools/server-side',
                pages: 2 // number of pages to cache
            }),
            "columnDefs": [{
                "targets": -2,
                "data": null,
                "defaultContent": "<a href='#' class='fa fa-edit edit' style='padding-right: 5px'>" +
                "</a><a href='#' class='fa fa-eye view'></a>"
            }, {
                "orderable": false,
                "className": 'select-checkbox',
                "targets": -1,
                "defaultContent": ""
            }, {
                "targets": 0,
                "data": null,
                "visible": false
            }],
            select: {
                style: 'os',
                selector: 'td:last-child'
            },
            language: {
                url: "/lib/ru.json"
            }
        });

        $('#main-table tbody').on('click', '.edit', function (e) {
            e.preventDefault();
            var data = table.row($(this).parents('tr')).data();
            location.href = "/tehdoc/equipment/tools/update?id=" + data[0];
        });
        $('#main-table tbody').on('click', '.view', function (e) {
            e.preventDefault();
            var data = table.row($(this).parents('tr')).data();
            var href = "/tehdoc/equipment/tools/view?id=" + data[0];
            window.open(href);
        });
    });

    // Работа таблицы -> событие выделения и снятия выделения

    $(document).ready(function () {
        var table = $('#main-table').DataTable();
        table.on('select', function (e, dt, type, indexes) {
            if (type === 'row') {
                $('.hiddendel').show();
                $('.classif').show();
            }
        });
        table.on('deselect', function (e, dt, type, indexes) {
            if (type === 'row') {
                $('.hiddendel').hide();
                $('.classif').hide();
            }
        });
    });

    //********************** Удаление записей ***********************************

    $(document).ready(function () {
        $('.hiddendel').click(function (event) {
            event.preventDefault();
            var csrf = $('meta[name=csrf-token]').attr("content");
            var table = $('#main-table').DataTable();
            var data = table.rows({selected: true}).data();
            var ar = [];
            var count = data.length;
            for (var i = 0; i < count; i++) {
                ar[i] = data[i][0];
            }
            if (confirm('Вы действительно хотите удалить выделенное оборудование? Выделено ' + data.length + '!!!  ')) {
                $(".modal").modal("show");
                $.ajax({
                    url: "/tehdoc/equipment/tools/delete",
                    type: "post",
                    dataType: "JSON",
                    data: {jsonData: ar, _csrf: csrf},
                    success: function (result) {
                        $("#main-table").DataTable().clearPipeline().draw();
                        $(".modal").modal('hide');
                        $('.hiddendel').hide();
                        $('.classif').hide();
                    },
                    error: function () {
                        alert('Ошибка! Обратитесь к разработчику.');
                        $(".modal").modal('hide');
                    }
                });
            }
        })
    });

    //************************** Добавление классификатора **********************************

    $(document).ready(function () {
        $('.classif').click(function (event) {
            event.preventDefault();
            var csrf = $("meta[name=csrf-token]").attr("content");
            var table = $("#main-table").DataTable();
            var data = table.rows({selected: true}).data();
            var ar = [];
            var count = data.length;
            for (var i = 0; i < count; i++) {
                ar[i] = data[i][0];
            }
            $("#classifier-modal").modal("show");
            $('#classifier').off('change').on('change', function () {
                var val = $(this).val();
                if (val != '') {
                    var el = $('#kv-tree-dropdown-container').find('.kv-selected');
                    $.ajax({
                        url: "/admin/classifier/extended-data-form?id=" + val,
                        type: "GET",
                        success: function (result) {
                            $("#classifier-body").html(result);
                            $("#assign-classifier-btn").removeAttr('disabled');
                            $("#assign-classifier-btn").off('click').on("click", function (e) {
                                e.preventDefault();
                                var data = $('#form-classifier').serializeArray();
                                var sendData = data.filter(function (item, i, arr) {
                                    return arr[i]['value'] != 0;
                                });
                                $.ajax({
                                    url: "/admin/classifier/assign-classifier",
                                    type: "post",
                                    data: {id: ar, _csrf: csrf, data: sendData},
                                    success: function (result) {
                                        $("#form-classifier")[0].reset();
                                        $("#classifier-modal").modal("hide");

                                    },
                                    error: function () {
                                        console.log("Ошибка cat_1! Обратитесь к разработчику.");
                                        $("#classifier-modal").modal("hide");
                                    }
                                });
                            })
                        },
                        error: function () {
                            console.log("Ошибка cat_2! Обратитесь к разработчику.");
                            $("#classifier-modal").modal("hide");
                        }
                    });
                } else {
                    $("#classifier-body").html('');
                    $("#assign-classifier-btn").attr("disabled", "disabled");
                }
            });
        })
    });

</script>
