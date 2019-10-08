<?php
//
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$about = "Панель отображения оборудования по категориям. При сбое, перезапустите форму, воспользовавшись соответствующей клавишей.";
$refresh_hint = 'Перезапустить форму';
$task_hint = 'Добавить в задание на обновление';
$send_hint = 'Передать выделенные строки в основное дерево';

?>

<div id="category-show" class="row">
    <span class="page-data" data-tree="fancytree_categories_show" data-table="main-table">

  <div class="col-lg-4 col-md-4 fancy-tree" style="padding-bottom: 5px; position: relative">
    <div id="refresh-tree-wrap" class="hidden-xs hidden-sm" style="position: absolute; top: 0px; left:-40px">
      <a class="fab-button refresh-button refresh-tree" title="Обновить"
         style="cursor: pointer; background-color: green" data-tree="fancytree_categories_show">
        <svg width="37" height="37" viewBox="0 0 24 24">
          <path d="M9 12l-4.463 4.969-4.537-4.969h3c0-4.97 4.03-9 9-9 2.395 0 4.565.942 6.179
        2.468l-2.004 2.231c-1.081-1.05-2.553-1.699-4.175-1.699-3.309 0-6 2.691-6 6h3zm10.463-4.969l-4.463 4.969h3c0
        3.309-2.691 6-6 6-1.623 0-3.094-.65-4.175-1.699l-2.004 2.231c1.613 1.526 3.784 2.468 6.179 2.468 4.97 0 9-4.03
        9-9h3l-4.537-4.969z"/>
        </svg>
      </a>
    </div>

    <div style="position: relative">
      <div class="small-nidden-btns visible-xs visible-sm">
        <button class="btn btn-sm btn-success refresh-tree" data-tree="fancytree_categories_show">Обновить</button>
      </div>

      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" data-tree="fancytree_categories_show"
               autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 10px; position: absolute">
        <a href="" class="btnResetSearch" data-tree="fancytree_categories_show">
          <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
        </a>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">
        <div id="fancytree_categories_show" class="ui-draggable-handle"></div>
      </div>
    </div>
  </div>


  <div class="col-lg-8 col-md-8 about about-padding" style="position: relative;">
    <div class="control-buttons-wrap" style="position: absolute;top:0;width:300px">
      <button class="btn btn-primary btn-sm sendbtn" style="display:none" data-toggle="tooltip"
              data-placement="bottom" title="<?= $send_hint ?>">Передать
      </button>
    </div>
    <input class="root" style="display: none">
    <input class="lft" style="display: none">
    <input class="rgt" style="display: none">
    <div class="table-wrapper" style="min-height:40px">
    </div>
    <table id="main-table" class="display no-wrap cell-border d-table" style="width:100%">
      <thead>
      <tr>
        <th></th>
        <th data-priority="1">Наименование</th>
        <th data-priority="3">Производитель</th>
        <th data-priority="3">Модель</th>
        <th data-priority="6">s/n</th>
        <th>Дата производства</th>
        <th data-priority="4" title="Количество">Кол.</th>
        <th data-priority="3"></th>
      </tr>
      </thead>
    </table>
  </div>


</div>

<script>
  // Глобальные переменные
  var nodeid;
  var treeCategoryShowId;


  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $('#main-table').on('length.dt', function (e, settings, len) {
    $('.task-it').hide();
    $('.sendbtn').hide();
  });

  $('#main-table').on('draw.dt', function (e, settings, len) {
    $('.task-it').hide();
    $('.sendbtn').hide();
  });


  // ************************* Работа таблицы **************************************

  $(document).ready(function () {
    $.fn.dataTable.pipeline = function (opts) {
      var conf = $.extend({
        pages: 5,     // number of pages to cache
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
          // API requested that the cache be cleared
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
      "lengthMenu": [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]],
      "ajax": $.fn.dataTable.pipeline({
        url: '/equipment/show/server-side',
        pages: 2, // number of pages to cache
        data: function () {
          var root = $(".root").text();
          var lft = $(".lft").text();
          var rgt = $(".rgt").text();
          return {
            'db_tbl': 'equipment_category_tbl',
            'identifier': 'category_id',
            'root': root,
            'lft': lft,
            'rgt': rgt
          }
        }
      }),
      "columnDefs": [{
        "orderable": false,
        "className": 'select-checkbox',
        "targets": -1,
        "defaultContent": ""
      }, {
        "targets": 0,
        "data": null,
        "visible": false
      }, {
        'targets': 1,
        'render': function (data, type, row) {
          return '<span class="tool-send" data-id="' + row[0] + '"><strong>' + row[1] + '</strong></span>';
        }
      }],
      select: {
        style: 'os',
        selector: 'td:last-child'
      },
      language: {
        url: "/lib/ru.json"
      }
    });
  });

  // Работа таблицы -> событие выделения и снятия выделения

  $(document).ready(function () {
    var table = $('#main-table').DataTable();
    table.on('select', function (e, dt, type) {
      if (type === 'row') {
        $('.task-it').show();
        $('.sendbtn').show();
      }
    });
    table.on('deselect', function (e, dt, type) {
      var i = table.rows({selected: true}).indexes();
      if (type === 'row' && i.count() == 0) {
        $('.task-it').hide();
        $('.sendbtn').hide();
      }
    });
  });

  ///////////// -============================ tree ======================================

  jQuery(function ($) {
    var main_url = '/equipment/control/category/categories';

    $("#fancytree_categories_show").fancytree({
      source: {
        url: main_url
      },
      extensions: ['filter'],
      quicksearch: true,
      minExpandLevel: 2,
      filter: {
        autoApply: true,                                    // Re-apply last filter if lazy data is loaded
        autoExpand: true,                                   // Expand all branches that contain matches while filtered
        counter: true,                                      // Show a badge with number of matching child nodes near parent icons
        fuzzy: false,                                       // Match single characters in order, e.g. 'fb' will match 'FooBar'
        hideExpandedCounter: true,                          // Hide counter badge if parent is expanded
        hideExpanders: true,                                // Hide expanders if all child nodes are hidden by filter
        highlight: true,                                    // Highlight matches by wrapping inside <mark> tags
        leavesOnly: true,                                   // Match end nodes only
        nodata: true,                                       // Display a 'no data' status node if result is empty
        mode: 'hide'                                        // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
      },
      activate: function (node, data) {
        $(".task-it").hide();
        $(".sendbtn").hide();
        var node = data.node;
        if (node.key == -999) {
          $(".add-subcategory").hide();
          return;
        } else {
          $(".add-subcategory").show();
        }
        var title = node.title;
        var id = node.data.id;
        window.nodeId = id;
        $(".root").text(node.data.root);
        $(".lft").text(node.data.lft);
        $(".rgt").text(node.data.rgt);
        $("#main-table").DataTable().clearPipeline().draw();
      },
      renderNode: function (node, data) {
      }
    });
  })

</script>