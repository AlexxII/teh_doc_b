<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

\wbraganca\fancytree\FancytreeAsset::register($this);

$about = "Панель управления. При сбое, перезапустите форму, воспользовавшись соответствующей клавишей.";
$add_hint = 'Добавить новый узел';
$add_tree_hint = 'Добавить дерево';
$refresh_hint = 'Перезапустить форму';
$del_hint = 'Удалить выбранную категорию БЕЗ вложений';
$del_root_hint = 'Удалить ветку полностью';
$del_multi_nodes = 'Удвлить выбранную категорию С вложениями';

?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
  .fa {
    font-size: 15px;
  }
  ul.fancytree-container {
    font-size: 14px;
  }
  input {
    color: black;
  }
</style>

<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm add-subcategory',
        'style' => ['margin-top' => '5px'],
        'title' => $add_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm refresh',
        'style' => ['margin-top' => '5px'],
        'title' => $refresh_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-node',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top'
      ]) ?>
      <?= Html::a('<i class="fa fa-object-group" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-multi-nodes',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_multi_nodes,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-4 col-md-4" style="padding-bottom: 10px">
    <div style="position: relative">
      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 10px; position: absolute">
        <a href="" id="btnResetSearch">
          <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
        </a>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">
        <div id="fancyree_w0" class="ui-draggable-handle"></div>
      </div>
    </div>
  </div>


  <div class="col-lg-8 col-md-8">
    <ul class="nav nav-tabs" id="myTab">
      <li class="active"><a href="#home" data-toggle="tab" data-url="main">Главная</a></li>
      <li><a href="#messages" data-toggle="tab" data-url="files">Файлы</a></li>
      <li><a href="#profile" data-toggle="tab" data-url="wiki">Wiki</a></li>
      <li><a href="#messages" data-toggle="tab" data-url="log">Лог</a></li>
    </ul>
    <div class="about-content" style="margin-top: 15px">

    </div>
  </div>

</div>


<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function () {
    $('.add-subcategory').click(function (event) {
        event.preventDefault();
        var node = $(".ui-draggable-handle").fancytree("getActiveNode");
        if (!node) {
          alert("Выберите родительскую категорию");
          return;
        }
        node.editCreateNode("child", " ");
        return;
      }
    )
  });

  $(document).ready(function () {
    $('.add-category').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree("getTree");
      $.ajax({
        url: "/vks/control/vks-employee/create-root",
        data: {title: 'Новое Ведомство'}
      })
        .done(function () {
          tree.reload();
        })
        .fail(function () {
          alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
        });
    });
  });

  $(document).ready(function () {
    $('.refresh').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree("getTree");
      tree.reload();
      $(".del-root").hide();
      $(".del-node").hide();
      $(".del-multi-nodes").hide();
    })
  });

  $(document).ready(function () {
    $('.del-root').click(function (event) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      if (confirm('Вы уверены, что хотите удалить выбранный классификатор вместе с вложениями?')) {
        event.preventDefault();
        var node = $(".ui-draggable-handle").fancytree("getActiveNode");
        if (!node) {
          alert('Выберите родительский классификатор');
          return;
        }
        $.ajax({
          url: "/vks/control/vks-employee/delete-root",
          type: "post",
          data: {id: node.data.id, _csrf: csrf}
        })
          .done(function () {
            node.remove();
            restoreInputs(false, false);
            $('.about-info').html('');
            $('.del-root').hide();
          })
          .fail(function () {
            alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
          });
      }
    });
    $('.del-node').click(function (event) {
      if (confirm('Вы уверены, что хотите удалить выбранный классификатор?')) {
        event.preventDefault();
        var csrf = $('meta[name=csrf-token]').attr("content");
        var node = $(".ui-draggable-handle").fancytree("getActiveNode");
        $.ajax({
          url: "/vks/control/vks-employee/delete",
          type: "post",
          data: {id: node.data.id, _csrf: csrf}
        })
          .done(function () {
            node.remove();
            $('.about-info').html('');
            $('.del-node').hide();
          })
          .fail(function () {
            alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
          });
      }
    });

    $('.del-multi-nodes').click(function (event) {
      if (confirm('Вы уверены, что хотите удалить выбранный классификатор вместе с вложениями?')) {
        event.preventDefault();
        var csrf = $('meta[name=csrf-token]').attr("content");
        var node = $(".ui-draggable-handle").fancytree("getActiveNode");
        if (!node) {
          alert('Выберите узел');
          return;
        }
        $.ajax({
          url: "/vks/control/vks-employee/delete-root",
          type: "post",
          data: {id: node.data.id, _csrf: csrf}
        })
          .done(function () {
            node.remove();
            $('.about-info').html('');
            $('.del-multi-nodes').hide();
            $('.del-node').hide();

          })
          .fail(function () {
            alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
          });
      }
    })
  });


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

  $(document).ready(function () {
    $("input[name=search]").keyup(function (e) {
      if ($(this).val() == '') {
        var tree = $(".ui-draggable-handle").fancytree("getTree");
        tree.clearFilter();
      }
    })
  });


  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/tehdoc/equipment/complex/complex-ex';
    var move_url = "/tehdoc/equipment/complex/move";
    var create_url = '/tehdoc/equipment/complex/complex-ex-create';
    var update_url = '/tehdoc/equipment/complex/update-node';

    $("#fancyree_w0").fancytree({
      source: {
        url: main_url,
      },
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
          $.get(move_url, {
            item: data.otherNode.data.id,
            action: data.hitMode,
            second: node.data.id,
            parent: data.node.parent.title
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
          data.save
        },
        save: function (event, data) {
          var node = data.node;
          if (data.isNew) {
            $.ajax({
              url: create_url,
              data: {
                parentTitle: node.parent.title,
                title: data.input.val()
              }
            }).done(function (result) {
//            node.setTitle(result.acceptedTitle);
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
            }).always(function () {
              // data.input.removeClass("pending")
            });
          } else {
            $.ajax({
              url: update_url,
              data: {
                id: node.data.id,
                title: data.input.val()
              }
            }).done(function (result) {
//                node.setTitle(result.acceptedTitle);
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
            }).always(function () {
//                data.input.removeClass("pending")
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
      renderNode: function (node, data) {
        if (data.node.key == -999) {
          $(".add-category").show();
          $(".add-subcategory").hide();
        }
      }
    });
  });

  $('#myTab a').click(function (e) {
    e.preventDefault();
    var mainUrl = "/tehdoc/equipment/complex/";
    var u = $(this).data('url');
    $.ajax({
      url: mainUrl + u,
    })
      .done(function (result) {
        $('.about-content').html(result);
        $(this).tab('show');
      })
      .fail(function () {
        alert("Что-то пошло не так. Перезагрузите форму с помошью клавиши.");
      });
  });


</script>