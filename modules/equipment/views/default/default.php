<?php

use yii\helpers\Html;

use app\assets\AppAsset;
use app\modules\equipment\asset\EquipmentAsset;

use yii\bootstrap\BootstrapPluginAsset;

use app\assets\MdeAsset;
use app\assets\FancytreeAsset;
use app\assets\PhotoswipeAsset;
use app\assets\JConfirmAsset;
use app\assets\BootstrapDatepickerAsset;
use app\assets\SlidebarsAsset;
use app\assets\NotyAsset;
use app\assets\TableBaseAsset;

AppAsset::register($this);            // регистрация ресурсов всего приложения
EquipmentAsset::register($this);      // регистрация ресурсов модуля

NotyAsset::register($this);
PhotoswipeAsset::register($this);
FancytreeAsset::register($this);
MdeAsset::register($this);
JConfirmAsset::register($this);
BootstrapDatepickerAsset::register($this);
SlidebarsAsset::register($this);
TableBaseAsset::register($this);
BootstrapPluginAsset::register($this);

$about = "Перечень оборудования";
?>
<style>
  #tools-tree {
    position: relative;
  }

</style>

<div id="main-content" class="container">
  <div class="row">
    <div id="tools-tree" class="col-lg-4 col-md-4" style="padding-bottom: 10px">
      <div id="add-equipment-wrap" style="position: absolute; top: 10px; left:-60px">
        <a id="add-equipment" data-tree="tools-main-tree" class="fab-button" title="Добавить оборудование"
           style="cursor: pointer">
          <div class="plus"></div>
        </a>
      </div>

      <!-- Deleting!!!! !-->
      <div id="delete-equipment-wrap" style="position: absolute; top: 70px; left:-60px;display: none">
        <a id="delete-equipment" class="fab-button" title="Удалить"
           style="cursor: pointer; background-color: red">
          <svg width="50" height="50" viewBox="0 0 24 24">
            <path d="M15 4V3H9v1H4v2h1v13c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6h1V4h-5zm2 15H7V6h10v13z"></path>
            <path d="M9 8h2v9H9zm4 0h2v9h-2z"></path>
          </svg>
        </a>
      </div>

      <div style="position: relative">
        <div class="container-fuid" style="float:left; width: 100%">
          <input class="form-control form-control-sm" autocomplete="off" name="search"
                 placeholder="Поиск по названию...">
        </div>
        <div style="padding-top: 8px; right: 10px; position: absolute">
          <a href="" id="btnResetSearch">
            <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color:#9d9d9d"></i>
          </a>
        </div>
      </div>

      <div class="row" style="padding: 0 15px">
        <div style="border-radius:2px;padding-top:40px">
          <div id="tools-main-tree" class="ui-draggable-handle"></div>
        </div>
      </div>
    </div>

    <div id="tool-info" class="col-lg-8 col-md-8" style="height: 100%;display: none">
      <ul class="nav nav-tabs" id="main-teh-tab">
        <li id="info-tab" data-tab-name="info" class="active">
          <a href="">
            Инфо
          </a>
        </li>
        <li id="docs-tab" data-tab-name="docs">
          <a href="">
            Docs
            <span class="counter">0</span>
          </a>
        </li>
        <li id="images-tab" data-tab-name="images">
          <a href="">
            Photo
            <span class="counter">0</span>
          </a>
        </li>
        <li id="wiki-tab" data-tab-name="wiki">
          <a href="">
            Wiki
            <span class="counter">0</span>
          </a>
        </li>
      </ul>
      <div id="tool-info-view">
      </div>
    </div>

  </div>
</div>

<script>
  //    initLeftCustomData('/equipment/menu/left-side-data');
  //    initRightCustomData('/equipment/menu/right-side-data');
  initLeftMenu('/equipment/menu/left-side');
  initAppConfig('/equipment/menu/app-config');

  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $("input[name=search]").keyup(function (e) {
      var n,
        tree = $.ui.fancytree.getTree(),
        args = "autoApply autoExpand fuzzy hideExpanders highlight leavesOnly nodata".split(" "),
        opts = {},
        filterFunc = $("#branchMode").is(":checked") ? tree.filterBranches : tree.filterNodes,
        match = $(this).val();

      $.each(args, function (i, o) {
        opts[o] = $("#" + o).is(":checked");
      });
      opts.mode = $("#hideMode").is(":checked") ? "hide" : "dimm";

      if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
        $("button#btnResetSearch").click();
        return;
      }
      if ($("#regex").is(":checked")) {
        // Pass function to perform match
        n = filterFunc.call(tree, function (node) {
          return new RegExp(match, "i").test(node.title);
        }, opts);
      } else {
        // Pass a string to perform case insensitive matching
        n = filterFunc.call(tree, match, opts);
      }
      $("#btnResetSearch").attr("disabled", false);
    }).focus();

    $("#btnResetSearch").click(function (e) {
      e.preventDefault();
      $("input[name=search]").val("");
      $("span#matches").text("");
      var tree = $(".ui-draggable-handle").fancytree("getTree");
      tree.clearFilter();
    }).attr("disabled", true);

    $("input[name=search]").keyup(function (e) {
      if ($(this).val() == '') {
        var tree = $(".ui-draggable-handle").fancytree("getTree");
        tree.clearFilter();
      }
    })
  })
  ;

  var tId, toolInfo;
  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/equipment/default/all-tools';
    var move_url = '/equipment/default/move-node';
    var create_url = '/equipment/default/create-node';
    var update_url = '/equipment/default/update-node';

    $("#tools-main-tree").fancytree({
      source: {
        url: main_url
      },
      expandParents: true,
      noAnimation: false,
      scrollIntoView: true,
      topNode: null,
      extensions: ['dnd', 'edit', 'filter'],
      quicksearch: true,
      minExpandLevel: 3,
      wide: {
        iconWidth: '32px',     // Adjust this if @fancy-icon-width != '16px'
        iconSpacing: '6px', // Adjust this if @fancy-icon-spacing != '3px'
        labelSpacing: '6px',   // Adjust this if padding between icon and label !=  '3px'
        levelOfs: '32px'     // Adjust this if ul padding != '16px'
      },
      dnd: {
        preventVoidMoves: true,
        preventRecursiveMoves: true,
        autoCollapse: true,
        dragStart: function (node, data) {
          return true;
        },
        dragEnter: function (node, data) {
          return true;
        },
        dragDrop: function (node, data) {
          var pId;
          if (data.hitMode == 'over') {
            pId = data.node.data.id;
          } else {
            pId = data.node.parent.data.id;
          }
          $.get(move_url, {
            item: data.otherNode.data.id,
            action: data.hitMode,
            second: node.data.id,
            parentId: pId
          }, function () {
            data.otherNode.moveTo(node, data.hitMode);
          })
        }
      },
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
      edit: {
        inputCss: {
          minWidth: '10em'
        },
        triggerStart: ['clickActive', 'dbclick', 'f2', 'mac+enter', 'shift+click'],
        beforeEdit: function (event, data) {
          var node = data.node;
          if (node.data.lvl == 0) {
            return false;
          }
          node.icon = 't fa fa-file-o';
          return true;
        },
        edit: function (event, data) {
          return true;
        },
        beforeClose: function (event, data) {
          data.save
        },
        save: function (event, data) {
          var node = data.node;
          if (data.isNew) {
            $.ajax({
              url: create_url,
              data: {
                parentId: node.parent.data.id,
                title: data.input.val()
              }
            }).done(function (result) {
              if (result) {
                var parent = node.parent;
                parent.folder = true;
                result = JSON.parse(result);
                node.data.id = result.acceptedId;
                node.key = result.acceptedId;
                node.setTitle(result.acceptedTitle);
                $('#status-info').hide().html(goodAlert('Запись успешно сохранена в БД.')).fadeIn('slow');
              } else {
                node.setTitle(data.orgTitle);
                $('#status-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                  ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
              }
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
              $('#status-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
            }).always(function () {
              // data.input.removeClass("pending")
            });
          } else {
            $.ajax({
              url: update_url,
              data: {
                nodeId: getNodeId(),
                title: data.input.val()
              }
            }).done(function (result) {
              if (result) {
                result = JSON.parse(result);
                node.setTitle(result.acceptedTitle);
                $('#status-info').hide().html(goodAlert('Запись успешно изменена в БД.')).fadeIn('slow');
              } else {
                node.setTitle(data.orgTitle);
                $('#status-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                  ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
              }
            }).fail(function (result) {
              $('#status-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
              node.setTitle(data.orgTitle);
            }).always(function () {
              // data.input.removeClass("pending")
            });
          }
          return true;
        },
        close: function (event, data) {
          if (data.save) {
            // Since we started an async request, mark the node as preliminary
            $(data.node.span).addClass("pending")
          }
        }
      },
      init: function (event, data) {
        if (tId != undefined) {
          // getCounters(tId);
          data.tree.activateKey(tId);
          $('#tool-info').fadeIn(500);
        }
      },
      activate: function (event, data) {
        var target = $.ui.fancytree.getEventTargetType(event.originalEvent);
        if (target === 'title' || target === 'icon') {
          console.log(target);
        }
        $('#tool-info').fadeIn(500);
        var node = data.node;
        var toolId = node.data.id;
        tId = toolId;
        var ref = $('ul#main-teh-tab').find('li.active').data('tabName');
        getCounters(toolId);
        loadTabsData(ref, toolId);
      },
      icon: function (event, data) {
        var icon = data.node.data.icon;
        if (icon) {
          return icon;
        }
      }
    });

    $('#main-teh-tab li').click(function (e) {
      e.preventDefault();
      $('#main-teh-tab li').removeClass();
      $(this).addClass('active');
      var node = $("#tools-main-tree").fancytree("getActiveNode");
      var ref = $(this).data("tabName");
      if (node != null) {
        var toolId = node.data.id;
        loadTabsData(ref, toolId);
      }
    })
  });

  function getCounters(toolId) {
    var url = '/equipment/tool/info/counters?id=' + toolId;
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      var counters = JSON.parse(response);
      if (counters != false) {
        $('#docs-tab .counter').html(counters.docsCount);
        $('#images-tab .counter').html(counters.imagesCount);
        $('#wiki-tab .counter').html(counters.wikiCount);
      }
      return;
    }).fail(function () {
      console.log('Что-то пошло не так');
    });
  }

  function loadTabsData(ref, toolId) {
    if (ref != undefined) {
      url = '/equipment/tool/' + ref + '/index?id=' + toolId;
    } else {
      url = '/equipment/tool/info/index?id=' + toolId;
    }
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      $('#tool-info-view').html(response.data.data);
    }).fail(function () {
      self.setContentAppend('<div>Что-то пошло не так!</div>');
    });
  }

  function getNodeId() {
    var node = $("#tools-main-tree").fancytree("getActiveNode");
    if (node) {
      return node.data.id;
    } else {
      return 1;
    }
  }

  function returnCallback() {
    var node = $("#tools-main-tree").fancytree("getActiveNode");
    var ref = $(this).data("tabName");
    if (node != null) {
      var toolId = node.data.id;
      loadTabsData(ref, toolId);
    }
  }


</script>
