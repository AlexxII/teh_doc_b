<?php

use yii\helpers\Html;

$about = "Панель управления оборудованием, добавленным в графики проведения ТО.";
$add_hint = 'Добавить обертку';
$del_hint = 'Удалить обертку';
$refresh_hint = 'Перезапустить форму';
$serial_hint = 'Внимание! Серийный номер, присвоенный в данной форме отображается только в пределах раздела ТО';
$ref_hint = 'К оборудованию в основном перечне';

?>

<div class="">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm add-subcategory',
        'style' => ['margin-top' => '5px'],
        'title' => $add_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'data-container' => 'body',
        'data-tree' => 'fancytree_to_equipment',
        'data-root' => 'Оборудование'
      ]) ?>
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm refresh',
        'style' => ['margin-top' => '5px'],
        'title' => $refresh_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'data-container' => 'body',
        'data-tree' => 'fancytree_to_equipment',
      ]) ?>
      <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-danger btn-sm del-node',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $del_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'data-container' => 'body',
        'data-tree' => 'fancytree_to_equipment',
        'data-delete' => '/to/control/to-equipment/delete'
      ]) ?>
      <?= Html::a('<i class="fa fa-level-up" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-info btn-sm',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $ref_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'data-container' => 'body',
        'id' => 'tool-ref'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-7 col-md-7" style="padding-bottom: 10px">
    <div style="position: relative">
      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 10px; position: absolute">
        <a href="" class="btnResetSearch" data-tree="fancytree_to_equipment">
          <i class="fa fa-times-circle" aria-hidden="true" style="font-size:20px; color: #9d9d9d"></i>
        </a>
      </div>
    </div>

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">
        <div id="fancytree_to_equipment" class="ui-draggable-handle"></div>
      </div>
    </div>
  </div>


  <div class="col-lg-5 col-md-5">
    <div class="alert alert-warning" style="margin-bottom: 10px">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Внимание!</strong> Выберите оборудование серийный номер которого будет использоваться в графике ТО. Если
      выпадающий список не активен, значит у объекта отсутствуют дочерние элементы.
    </div>

    <div id="result-info" style="margin-bottom: 10px"></div>
    <form action="create" method="post" class="input-add">
      <div class="about-main">
        <label>Серийный номер:
          <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
               data-toggle="tooltip" data-placement="top" title="<?= $serial_hint ?>"></sup>
        </label>
        <input id="serial-number" class="form-control c-input" disabled>
        <label>Оборудование:</label>
        <select type="text" id="serial-control" class="c-input form-control" name="sn" disabled></select>
        <label style="font-weight:400;font-size: 10px">Выберите оборудование.</label>
      </div>
      <div class="about-footer"></div>
      <button type="submit" id="save-btn" onclick="saveClick(event)" class="btn btn-primary" disabled>Сохранить</button>
    </form>
  </div>


</div>


<script>

  var nodeId;
  var node$;

  // сохрание оборудования, сереийный номер которого будет использоваться в графике ТО
  function saveClick(e) {
    e.preventDefault();
    var csrf = $('meta[name=csrf-token]').attr("content");
    var nodeId = window.nodeId;
    var serial = $('#serial-number').val();
    $.ajax({
      url: "/to/control/to-equipment/tool-serial-save",
      type: "post",
      data: {
        serial: serial,
        _csrf: csrf,
        id: nodeId
      },
      success: function (result) {
        if (result) {
          $('#result-info').hide().html(goodAlert('Запись добавлена в БД.')).fadeIn('slow');
          node$.data.eq_serial = serial;
          $("#save-btn").prop("disabled", true);
        } else {
          $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
            'снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
        }
      },
      error: function () {
        $('#result-info').hide().html(badAlert('Запись не сохранена в БД. Попробуйте перезагрузить страницу и попробовать' +
          'снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
      }
    });
  }

  function serialControl(el) {
    var serial = $(el).find(':selected').data('serial');
    if (serial == '' || serial == null) {
      $("#save-btn").prop("disabled", true);
      $('#serial-number').val('');
    } else {
      $('#serial-number').val(serial);
      $("#save-btn").prop("disabled", false);
    }
    return;
  }

  var serialVal;

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $("#serial-number").on('keyup mouseclick', function () {
      $("#save-btn").prop("disabled", this.value.length == "" ? true : false);
    });

    $('#tool-ref').click(function (event) {
      event.preventDefault();
      var node = $(".ui-draggable-handle").fancytree("getActiveNode");
      var toolId = node.data.eq_id;
      var prefix = '/equipment/tool/';
      var href = prefix + toolId + '/info/index';
      if (event.ctrlKey) {
        window.open(href);
      } else {
        location.href = href;
      }
    });

    // отображение и логика работа дерева
    var main_url = '/to/control/to-equipment/all-tools';
    var move_url = '/to/control/to-equipment/move-node';
    var create_url = '/to/control/to-equipment/create-node';
    var update_url = '/to/control/to-equipment/update-node';

    $("#fancytree_to_equipment").fancytree({
      source: {
        url: main_url
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
            if (data.node.data.eq_id != 0) {             // Ограничение на вложенность
              return false;
            } else if (data.otherNode.data.eq_id == 0) {
              return false;
            }
            var pId = data.node.data.id;
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
                node.data.eq_id = 0;
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
                id: nodeId,
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
            $(data.node.span).addClass("pending")
          }
        }
      },
      activate: function (node, data) {
        $('#serial-number').val('');
        $('#serial-control').val('none');
        var node = data.node;
        var lvl = node.data.lvl;
        var eqId = node.data.eq_id;
        window.node$ = node;
        window.nodeId = node.data.id;
        serialVal = node.data.eq_serial;
        if (eqId != 0) {
          $('#serial-number').prop("disabled", false);
          if (serialVal) {
            $('#serial-number').val(serialVal);
          } else {
            $('#serial-number').val('');
          }
          $.ajax({
            url: '/to/control/to-equipment/tools-serials',
            data: {
              id: node.data.eq_id
            }
          }).done(function (result) {
            if (result != -1) {
              var serial = 0;
              var result = JSON.parse(result, function (key, value) {
                if (key == 'single') serial = 1;
                return value;
              });
              if (serial) {
                if (result.single != '' && result.single != null) {
                  $('#serial-number').val(result.single);
                  if (node.data.eq_serial == null) {
                    $("#save-btn").prop("disabled", false);
                  }
                } else {
                  $('#serial-number').val('');
                  $("#save-btn").prop("disabled", true);
                }
              } else {
                var optionsValues = '<select class="form-control input-sm c-input" id="serial-control" ' +
                  'onchange=serialControl(this) style="margin-top: 5px">';
                optionsValues += '<option selected disabled>Выберите</option>';
                $.each(result, function (index, obj) {
                  if (obj.eq_serial != '' && obj.eq_serial != null) {
                    var serVal = 's/n: ' + obj.eq_serial;
                  } else {
                    serVal = 's/n: -';
                  }
                  optionsValues += '<option value="' + obj.id + '" ' +
                    'data-serial="' + obj.eq_serial + '">' + obj.name + ' ' + serVal + '</option>';
                });
                optionsValues += '</select>';
                var options = $('#serial-control');
                options.replaceWith(optionsValues);
                if (serialVal) {
                  $("#serial-control option[data-serial='" + serialVal + "']").attr("selected", "selected");
                }
              }
            } else if (result == -1) {
              if ($('#serial-number').val() == '') {
                $('#result-info').hide().html(warningAlert('У объекта нет серийного номера, введите его самостоятельно' +
                  ' в поле ввода.')).fadeIn('slow');
              }
            } else {
              $('#result-info').hide().html(badAlert('Что-то пошло не так. Попробуйте перезагрузить страницу и попробовать' +
                ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
            }
          }).fail(function (result) {
            $('#result-info').hide().html(badAlert('Что-то пошло не так. Попробуйте перезагрузить страницу и попробовать' +
              ' снова. При повторных ошибках обратитесь к разработчику.')).fadeIn('slow');
          });
        } else {
          $("#serial-control").prop("disabled", true);
          $('#serial-number').prop("disabled", true);
          $('#serial-number').val('');
        }
      },
      click: function (event, data) {
        $('#result-info').html('');
        $("#serial-control").children().remove();
        $("#serial-control").prop("disabled", true);
        var node = data.node;
        var lvl = node.data.lvl;
        $("#save-btn").prop("disabled", true);
        if (node.key == -999) {
          $("#add-subcategory").hide();
          return;
        }
        if (lvl == 0) {
          $(".del-node").hide();
        } else {
          $(".del-node").show();
        }
        if (node.data.eq_id != 0) {
          $('#tool-ref').show();
          $(".del-node").hide();
        } else {
          $('#tool-ref').hide();
        }
      },
      renderNode: function (node, data) {
        if (data.node.key == -999) {
          $("#add-subcategory").hide();
        }
      }
    })
    ;
  });


</script>