<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use app\assets\FancytreeAsset;

FancytreeAsset::register($this);

$this->title = 'Сотрудники, участвующие в ТО';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'ТО', 'url' => ['/tehdoc/to']];
$this->params['breadcrumbs'][] = $this->title;

$about = "Панель управления списком сотрудников, участвующих в ТО.";
$add_hint = 'Добавить запись';
$refresh_hint = 'Перезапустить форму';
$del_hint = 'Удалить';

$user_hint = 'Выберите пользователя системы с которым вы хотите сопоставить узел в дереве';
$role_hint = 'Выберите роль пользователя при проведении ТО';

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
  .ui-fancytree {
    overflow: auto;
  }
  input {
    color: black;
  }
  .fancytree-custom-icon {
    color: #1e6887;
    font-size: 18px;
  }
  .t {
    font-size: 14px;
  }
  .result {
    /*font-size: 18px;*/
  }

</style>

<div class="admin-category-pannel">

  <h3><?= Html::encode('Сотрудники ТО') ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h3>
</div>
<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', [''], ['class' => 'btn btn-success btn-sm',
        'style' => ['margin-top' => '5px'],
        'title' => $add_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'add-subcategory'

      ]) ?>
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', [''], ['class' => 'btn btn-success btn-sm',
        'style' => ['margin-top' => '5px'],
        'title' => $refresh_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'refresh'
      ]) ?>
      <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', [''], ['class' => 'btn btn-danger btn-sm',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'del-node'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-7 col-md-7" style="padding-bottom: 10px">
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


  <div class="col-lg-5 col-md-5">
    <div id="result-info" style="margin-bottom: 10px"></div>
    <div id="admin-settings">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'user-form']]); ?>
      <label> Пользователь системы:
        <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
             data-toggle="tooltip" data-placement="top" title="<?= $user_hint ?>"></sup>
      </label>
      <?= $form->field($model, 'name', [
        'template' => '{input}{hint}'])
        ->dropDownList($model->usersList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
          'options' => [
            'value' => 'none',
            'disabled' => 'true',
            'selected' => 'true'
          ]], 'id' => 'user-control', 'class' => 'form-control c-select'])->hint('', ['class' => ' w3-label-under']);
      ?>
      <label> Роль:
        <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
             data-toggle="tooltip" data-placement="top" title="<?= $role_hint ?>"></sup>
      </label>
      <?= $form->field($model, 'name', [
        'template' => '{input}{hint}'])
        ->dropDownList($model->rolesList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
          'options' => [
            'value' => 'none',
            'disabled' => 'true',
            'selected' => 'true'
          ]], 'id' => 'role-control', 'class' => 'form-control c-select'])->hint('', ['class' => ' w3-label-under']);
      ?>
      <div class="form-group">
        <?= Html::button('Сохранить', ['class' => 'btn btn-primary', 'id' => 'submit']) ?>
        <span id="result"></span>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>

</div>


<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();


  });

  var successCheck = '<i class="fa fa-check result" id="consolidated-check" aria-hidden="true" style="color: #4eb305"></i>';
  var waiting = '<i class="fa fa-cog fa-spin result" aria-hidden="true"></i>';
  var warningCheck = '<i class="fa fa-times result" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';


  function goodAlert(text) {
    var div = '' +
      '<div id="w3-success-0" class="alert-success alert fade in">' +
      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
      text +
      '</div>';
    return div;
  }

  function badAlert(text) {
    var div = '' +
      '<div id="w3-success-0" class="alert-danger alert fade in">' +
      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
      text +
      '</div>';
    return div;
  }

  $(document).ready(function () {
    $('#add-subcategory').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree('getTree');
      var root = tree.findFirst('Сотрудники, участвующие в ТО');
      root.editCreateNode("child", " ");
    });


    $('#refresh').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree("getTree");
      tree.reload();
      $("#del-node").hide();
      $('.c-select').prop('disabled', true);
      $('.c-select').val('none');
      $('#submit').prop('disabled', true);
      $('#result').html('');
      $('#result-info').html('');
    })
  });

  $(document).ready(function () {
    $('#del-node').click(function (event) {
      var url = 'delete';
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
              var node = $(".ui-draggable-handle").fancytree("getActiveNode");
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
                  $('#del-node').hide();
                  $('.c-select').prop('disabled', true);
                  $('.c-select').val('none');
                  $('#submit').prop('disabled', true);
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

    $('#submit').prop("disabled", true);
    $('.c-select').prop('disabled', true);

    $('.c-select').change(function (e) {
      $('#submit').prop("disabled", false);
    });

    $('#submit').click(function (e) {
      var url = '/tehdoc/to/control/to-admins/save-settings';
      var csrf = $('meta[name=csrf-token]').attr("content");
      var node = $(".ui-draggable-handle").fancytree("getActiveNode");
      $('#result').html(waiting);
      var userVal = $('#user-control').val();
      var roleVal = $('#role-control').val();
      $.ajax({
        url: url,
        type: "post",
        data: {
          _csrf: csrf,
          id: node.data.id,
          userVal: userVal,
          roleVal: roleVal
        }
      }).done(function (response) {
        $('#result').html(successCheck);
        node.data.admin = roleVal;
        node.data.user_id = userVal;
      }).fail(function (response) {
        $('#result').html(warningCheck);
      })
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

  var parent;
  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/tehdoc/to/control/to-admins/all-admins';
    var move_url = '/tehdoc/to/control/to-admins/move-node';
    var create_url = '/tehdoc/to/control/to-admins/create-node';
    var update_url = '/tehdoc/to/control/to-admins/update-node';

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
          if (data.hitMode == 'over') {
            return false;
          } else {
            var pId = data.node.parent.data.id;
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
          parent = data.node.parent;
          parent.folder = true;
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
                result = JSON.parse(result);
                node.data.id = result.acceptedId;
                node.setTitle(result.acceptedTitle);
                parent.renderTitle();
                $('#result-info').hide().html(goodAlert('Запись успешно сохранена в БД.')).fadeIn('slow');
              } else {
                node.setTitle(data.orgTitle);
                $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                  ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
              }
            }).fail(function (result) {
              node.setTitle(data.orgTitle);
              $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
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
              if (result) {
                result = JSON.parse(result);
                node.setTitle(result.acceptedTitle);
                $('#result-info').hide().html(goodAlert('Запись успешно изменена в БД.')).fadeIn('slow');
              } else {
                node.setTitle(data.orgTitle);
                $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
                  ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
              }
            }).fail(function (result) {
              $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
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
      activate: function (node, data) {
        var node = data.node;
        var lvl = node.data.lvl;
        if (node.key == -999) {
          $("#add-subcategory").hide();
          return;
        }
        if (lvl == 0) {
          $("#del-node").hide();
        } else {
          $("#del-node").show();
        }
        var userId = node.data.user_id;
        var roleId = node.data.admin;
        $('#result').html('');
        $('#result-info').html('');
        if (lvl == 0) {
          $('.c-select').prop('disabled', true);
          $('.c-select').val('none');
          $('#submit').prop('disabled', true);
        } else {
          $('.c-select').prop('disabled', false);
          $('#submit').prop('disabled', true);
          $('.c-select').val('none');
        }
        if (userId) {
          $('#user-control').val(userId);
        }
        if (roleId != null) {
          $('#role-control').val(roleId);
        }
      },
      click: function (event, data) {
      },
      renderNode: function (node, data) {
        if (data.node.key == -999) {
          $("#add-subcategory").hide();
        }
      }
    });
  })


</script>