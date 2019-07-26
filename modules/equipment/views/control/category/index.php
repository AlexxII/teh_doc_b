<?php

use yii\helpers\Html;

$this->title = 'Категории';

$about = "Панель управления категориями. При сбое, перезапустите форму, воспользовавшись соответствующей клавишей.";
$add_hint = 'Добавить новый узел';
$refresh_hint = 'Перезапустить форму';
$del_hint = 'Удалить БЕЗ вложений';
$del_multi_nodes = 'Удвлить С вложениями';

?>

<div class="admin-category-pannel">
  <div class="fancytree-control-panel">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm add-subcategory',
        'style' => ['margin-top' => '5px'],
        'title' => $add_hint,
        'data-toggle' => 'tooltip',
        'data-container' => 'body',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm refresh',
        'style' => ['margin-top' => '5px'],
        'title' => $refresh_hint,
        'data-toggle' => 'tooltip',
        'data-container' => 'body',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-node',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_hint,
        'data-toggle' => 'tooltip',
        'data-container' => 'body',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-object-group" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-multi-nodes',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_multi_nodes,
        'data-toggle' => 'tooltip',
        'data-container' => 'body',
        'data-placement' => 'top'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-12 col-md-12 search">
    <div style="position: relative">
      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 10px; position: absolute">
        <a href="" class="btnResetSearch">
          <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
        </a>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">
        <div id="fancyree_category" class="ui-draggable-handle"></div>
      </div>
    </div>
  </div>

</div>


<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.add-subcategory').click(function (event) {
      event.preventDefault();
      var node = $("#fancyree_category").fancytree("getActiveNode");
      if (!node) {
        alert("Выберите родительскую категорию");
        return;
      }
      if (node.data.lvl <= 1) {                                       // ограничение на вложенность
        node.editCreateNode("child", " ");
      } else {
        alert("Нельзя создавать вложенность более 3х");
        return;
      }
    });

    $('.refresh').click(function (event) {
      event.preventDefault();
      var tree = $("#fancyree_category").fancytree("getTree");
      var node = $("#fancyree_category").fancytree("getActiveNode");
      if (node) {
        var nodeId = node.key;
        tree.reload();
        tree = $("#fancyree_category").fancytree("getTree");
        tree.getNodeByKey(nodeId).setActive();
      }
      tree.reload();
      $(".del-node").hide();
      $(".del-multi-nodes").hide();
    });

    $('.del-node').click(function (event) {
      var url = '/equipment/control/category/delete';
      event.preventDefault();
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
              var node = $("#fancyree_category").fancytree("getActiveNode");
              jc.close();
              deleteProcess(url, node);
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

    $('.del-multi-nodes').click(function (event) {
      var url = '/equipment/control/category/delete-root';
      event.preventDefault();
      jc = $.confirm({
        icon: 'fa fa-question',
        title: 'Вы уверены?',
        content: 'Вы действительно хотите удалить выделенное С вложениями?',
        type: 'red',
        closeIcon: false,
        autoClose: 'cancel|9000',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
              var node = $("#fancyree_category").fancytree("getActiveNode");
              jc.close();
              deleteProcess(url, node);
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

    function deleteProcess(url, node) {
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
        type: "post",
        data: {id: node.data.id, _csrf: csrf}
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
                  node.remove();
                  $('.del-node').hide();
                  $(".del-multi-nodes").hide();
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
  });


  $("input[name=search]").keyup(function (e) {
    var n,
      tree = $("#fancyree_category").fancytree("getTree"),
      args = "autoApply autoExpand fuzzy hideExpanders highlight leavesOnly nodata".split(" "),
      opts = {},
      filterFunc = $("#branchMode").is(":checked") ? tree.filterBranches : tree.filterNodes,
      match = $(this).val();

    $.each(args, function (i, o) {
      opts[o] = $("#" + o).is(":checked");
    });
    opts.mode = $("#hideMode").is(":checked") ? "hide" : "dimm";

    if (e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === "") {
      $("button.btnResetSearch").click();
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
    $(".btnResetSearch").attr("disabled", false);
  }).focus();


  $(".btnResetSearch").click(function (e) {
    e.preventDefault();
    $(this).closest('.search').find('input').val('');
    $("span#matches").text("");
    var tree = $("#fancyree_category").fancytree("getTree");
    tree.clearFilter();
  }).attr("disabled", true);


  $(document).ready(function () {
    $("input[name=search]").keyup(function (e) {
      if ($(this).val() == '') {
        var tree = $("#fancyree_category").fancytree("getTree");
        tree.clearFilter();
      }
    })
  });

  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/equipment/control/category/categories';
    var move_url = '/equipment/control/category/move';
    var create_url = '/equipment/control/category/create';
    var update_url = '/equipment/control/category/update';

    $("#fancyree_category").fancytree({
      source: {
        url: main_url
      },
      expandParents: true,
      noAnimation: false,
      scrollIntoView: true,
      topNode: null,
      extensions: ['dnd', 'edit', 'filter'],
      quicksearch: true,
      minExpandLevel: 2,
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
            if (data.node.data.lvl >= 2 || data.otherNode.isFolder()) {             // Ограничение на вложенность
              jc = $.confirm({
                icon: 'fa fa-exclamation-triangle',
                title: 'Запрещено!',
                content: 'Суммарная глубина вложенности данного дерева не должна превышать 3х уровней!',
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
              return false;
            }
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
                result = JSON.parse(result);
                node.data.id = result.acceptedId;
                node.setTitle(result.acceptedTitle);
                node.data.lvl = result.lvl;
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
                id: node.data.id,
                title: data.input.val()
              }
            }).done(function (result) {
              if (result) {
                result = JSON.parse(result);
                node.setTitle(result.acceptedTitle);
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
      activate: function (node, data) {
        var node = data.node;
        var lvl = node.data.lvl;
        if (node.key == -999) {
          $(".add-subcategory").hide();
          return;
        } else {
          $(".add-subcategory").show();
        }
        if (lvl > 1) {                            // ограничение на вложенность
          $(".add-subcategory").hide();
        }
        if (lvl == 0) {
          $(".del-node").hide();
          $(".del-multi-nodes").hide();
        } else {
          if (node.hasChildren()) {
            $(".del-multi-nodes").show();
          } else {
            $(".del-multi-nodes").hide();
          }
          $(".del-node").show();
        }
      },
      icon: function (event, data) {
        var icon = data.node.data.icon;
        if (icon) {
          return icon;
        }
      },
      renderNode: function (node, data) {
        if (data.node.key == -999) {
          $(".add-category").show();
          $(".add-subcategory").hide();
        }
      }
    });
  })

</script>