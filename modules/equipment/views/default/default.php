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
      <div id="refresh-tree-wrap" style="position: absolute; top: 0px; left:-55px">
        <a id="refresh-tree" class="fab-button" title="Обновить"
           style="cursor: pointer; background-color: green">
          <svg width="37" height="37" viewBox="0 0 24 24">
            <path d="M9 12l-4.463 4.969-4.537-4.969h3c0-4.97 4.03-9 9-9 2.395 0 4.565.942 6.179
        2.468l-2.004 2.231c-1.081-1.05-2.553-1.699-4.175-1.699-3.309 0-6 2.691-6 6h3zm10.463-4.969l-4.463 4.969h3c0
        3.309-2.691 6-6 6-1.623 0-3.094-.65-4.175-1.699l-2.004 2.231c1.613 1.526 3.784 2.468 6.179 2.468 4.97 0 9-4.03
        9-9h3l-4.537-4.969z"/>
          </svg>
        </a>
      </div>
      <div id="add-equipment-wrap" style="position: absolute; top: 50px; left:-60px">
        <a id="add-equipment" data-tree="tools-main-tree" data-root="Необработанное" class="fab-button"
           title="Добавить оборудование" style="cursor: pointer">
          <div class="plus"></div>
        </a>
      </div>

      <!-- Deleting!!!! !-->
      <div id="delete-tool-wrap" style="position: absolute; top: 115px; left:-60px;display: none">
        <a id="delete-tool" class="fab-button" title="Удалить"
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
          <a href="" class="btnResetSearch" data-tree="tools-main-tree">
            <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color:#9d9d9d"></i>
          </a>
        </div>
      </div>

      <!-- дерево оборудования -->
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

  var tId, toolInfo;

  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    // отображение и логика работа дерева
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
          if (node.data.lvl === '0') {
            return false;
          }
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
            returnCallback();
          });
          node.folder = true;
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
          if (node.data.lvl === '0') {
            return false;
          }
          // node.icon = 't fa fa-file-o';
          return true;
        },
        edit: function (event, data) {
          return true;
        },
        beforeClose: function (event, data) {
          return true;
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
                parent.renderTitle();
                result = JSON.parse(result);
                node.data.id = result.acceptedId;
                node.key = result.acceptedId;
                node.setTitle(result.acceptedTitle);
                returnCallback();
              } else {
                node.setTitle(data.orgTitle);
              }
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
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
                //=========================

                // node.folder = true;
                // node.renderTitle();

                //=========================
                returnCallback();
              } else {
                node.setTitle(data.orgTitle);
              }
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
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
          // $('#tool-info').fadeIn(500);
          data.tree.activateKey(tId);
          tId = undefined;
        }
      },
      activate: function (event, data) {
        // var target = $.ui.fancytree.getEventTargetType(event.originalEvent);
        // if (target === 'title' || target === 'icon') {
        var node = data.node;
          // console.log(node);
        if (node.data.lvl !== '0') {
          $('#delete-tool-wrap').show();
        } else {
          $('#delete-tool-wrap').hide();
        }
        var toolId = node.data.id;
        if (node.data.lvl !== '0') {
          $('#tool-info').fadeIn(500);
          var ref = $('ul#main-teh-tab').find('li.active').data('tabName');
          getCounters(toolId);
          loadTabsData(ref, toolId);
        } else {
          $('#tool-info').fadeOut(10);
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
    var ref = $("#main-teh-tab li.active").data('tabName');
    if (node != null) {
      var toolId = node.data.id;
      loadTabsData(ref, toolId);
      getCounters(toolId);
    }
  }

  var toolsTreeIdAttr = 'tools-main-tree';

  $(document).on('click', '#add-equipment', function (e) {
    e.preventDefault();
    var tree = $('#' + toolsTreeIdAttr).fancytree('getTree');
    var node = $('#' + toolsTreeIdAttr).fancytree('getActiveNode');
    var rootTitle = $(e.currentTarget).data('root');
    if (!e.ctrlKey) {
      createWindow(tree, node, rootTitle);
    } else {
      simpleEquipmentAdd(tree, node, rootTitle);
    }
  });


  $(document).on('click', '#delete-tool', function (e) {
    e.preventDefault();
    var tree = $('#' + toolsTreeIdAttr).fancytree('getTree');
    var node = $('#' + toolsTreeIdAttr).fancytree('getActiveNode');
    var url = '/equipment/tool/info/delete';
    var dArray = {};
    var children = node.children;
    if (children && e.ctrlKey) {
      var index = 0;
      children.forEach(function (val, i, ar) {
        dArray[i] = val.key;
        index++;
      });
      dArray[index] = node.data.id;
    } else {
      dArray['0'] = node.data.id;
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
            deleteTool(url, dArray, tree);
          }
        },
        cancel: {
          text: 'Отмена'
        }
      }
    });
  });

  function deleteTool(url, data, tree) {
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
      data: {
        _csrf: csrf,
        data: data
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
                tree.reload();
                $('#tool-info').fadeOut(10);
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


  function createWindow(tree, node, rootTitle) {
    if (node) {
      var url = '/equipment/tool/info/create?root=' + node.data.id;
    } else {
      var url = '/equipment/tool/info/create';
    }
    c = $.confirm({
      content: function () {
        var self = this;
        return $.ajax({
          url: url,
          method: 'get'
        }).fail(function () {
          self.setContentAppend('<div>Что-то пошло не так</div>');
        });
      },
      contentLoaded: function (response, status, xhr) {
        this.setContentAppend('<div>' + response.data.data + '</div>');
      },
      type: 'blue',
      columnClass: 'large',
      title: 'Редактровать данные',
      buttons: {
        ok: {
          btnClass: 'btn-blue',
          text: 'Сохранить',
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
              //преобразование дат перед отправкой
              var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
              $('.fact-date').val(d);
              $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: $form.serialize(),
                success: function (response) {
                  var tText = '<span style="font-weight: 600">Успех!</span><br>Оборудование добавлено';
                  initNoty(tText, 'success');
                  // var root = tree.findFirst(rootTitle);
                  // root.addChildren({
                  //   titile: response.data.message
                  // });
                  // $('#tool-info-view').html(response.data.data);
                  tId = response.data.data;
                  tree.reload();
                  // tree.getNodeByKey(toolId.toString()).setActive();
                  // node.setTitle(response.data.message);
                },
                error: function (response) {
                  console.log(response.data.data);
                  var tText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Добавить оборудование не удалось';
                  initNoty(tText, 'error');
                }
              });
            }
          }
        },
        cancel: {
          text: 'НАЗАД',
        }
      }
    });
  }


</script>
