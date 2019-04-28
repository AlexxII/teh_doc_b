<?php

use yii\helpers\Html;
use app\assets\FancytreeAsset;

FancytreeAsset::register($this);

$this->title = 'График ТО на год';

$about = "Панель формирования графика ТО на год.";
$add_hint = 'Добавить группу';
$del_hint = 'Удалить обертку';
$refresh_hint = 'Перезапустить форму';
$serial_hint = 'Внимание! Серийный номер, присвоенный в данной форме отображается только в пределах раздела ТО';
$ref_hint = 'К оборудованию в основном перечне';

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
  .fancytree-custom-icon {
    color: #1e6887;
    font-size: 18px;
  }
  .t {
    font-size: 14px;
  }
  .ui-fancytree {
    overflow: auto;
  }
  td.alignRight {
    text-align: right;
  }
  td.alignCenter {
    text-align: center;
  }
  td input[type=input] {
    width: 40px;
  }
  #tree tr {
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
  }
  .save-it {
    color: #0b58a2;
    font-size: 18px;
    cursor: pointer;
  }
  .main {
    font-size: 24px;
  }

</style>

<div class="admin-category-pannel">

  <h3><?= Html::encode($this->title) ?>
    <sup class="h-title fa fa-question-circle-o" aria-hidden="true"
         data-toggle="tooltip" data-placement="right" title="<?php echo $about ?>"></sup>
  </h3>
</div>
<div class="row">
  <div class="">
    <div class="container-fluid" style="margin-bottom: 10px">
      <?= Html::a('<i class="fa fa-refresh" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-success btn-sm',
        'style' => ['margin-top' => '5px'],
        'title' => $refresh_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'refresh'
      ]) ?>
      <?= Html::a('<i class="fa fa-level-up" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-info btn-sm',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $ref_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'tool-ref'
      ]) ?>
      <?= Html::a('<i class="fa fa-level-up" aria-hidden="true"></i>', ['#'], ['class' => 'btn btn-info btn-sm',
        'style' => ['margin-top' => '5px', 'display' => 'none'],
        'title' => $ref_hint,
        'data-toggle' => 'tooltip',
        'data-placement' => 'top',
        'id' => 'tool-ref'
      ]) ?>
    </div>

  </div>

  <div class="col-lg-5 col-md-5" style="padding-bottom: 10px">
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
  </div>

</div>

<table id="tree">
  <colgroup>
    <col width="30px">
    <col width="50px">
    <col width="750px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
    <col width="50px">
  </colgroup>
  <thead>
  <tr>
    <th></th>
    <th>№</th>
    <th>Оборудование</th>
    <th>Янв.</th>
    <th>Фев.</th>
    <th>Мар.</th>
    <th>Апр.</th>
    <th>Май</th>
    <th>Июн.</th>
    <th>Июл.</th>
    <th>Авг.</th>
    <th>Сен.</th>
    <th>Окт.</th>
    <th>Ноя.</th>
    <th>Дек.</th>
    <th></th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <!-- Define a row template for all invariant markup: -->
  <tr>
    <td class="alignCenter"></td>
    <td></td>
    <td></td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'jan']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'feb']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'march']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'apr']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'may']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'jun']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'jul']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'aug']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'sep']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'oct']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'nov']) ?>
    </td>
    <td>
      <?= Html::dropDownList('name', 0, $list, ['class' => 'dec']) ?>
    </td>
    <td class="save">
    </td>
    <td class="status">
    </td>
  </tr>
  </tbody>
</table>

<script>

  $(document).ready(function () {
    $("#tree").on("change", "select", function (e) {
      var val = $(this).val();
      var cl = $(this).attr('class');
      if (!cl) {
        return;
      }
      var ar = $('#tree').fancytree('getTree').getSelectedNodes();
      ar.forEach(function (item, i, arr) {
        var tr = item.tr;
        $(tr).find('.' + cl).each(function () {
          $(this).val(val);
        })
      });
    });


    $('#refresh').click(function (event) {
      event.preventDefault();
      var tree = $("#tree").fancytree("getTree");
      tree.reload();
      $('.c-input').prop('disabled', true);
      $("#del-node").hide();
      $('#result-info').html('');
      $('#serial-number').val('');
      $("#save-btn").prop('disabled', true);
      $('#tool-ref').hide();
    });

    $('#tool-ref').click(function (event) {
      event.preventDefault();
      var node = $("#tree").fancytree("getActiveNode");
      var toolId = node.data.eq_id;
      var prefix = '/tehdoc/equipment/tool/';
      var href = prefix + toolId + '/info/index';
      if (event.ctrlKey) {
        window.open(href);
      } else {
        location.href = href;
      }
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
      var tree = $("#tree").fancytree("getTree");
      tree.clearFilter();
    }).attr("disabled", true);

    $("input[name=search]").keyup(function (e) {
      if ($(this).val() == '') {
        var tree = $("#tree").fancytree("getTree");
        tree.clearFilter();
      }
    });

    $("#tree").on("click", ".save-it", function (e) {

      jc = $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Подождите!',
        content: 'Ваш запрос выполняется!',
        buttons: false,
        closeIcon: false,
        confirmButtonClass: 'hide'
      });


      var node = $.ui.fancytree.getNode(e);
      var result = [];
      var children = node.children;
      children.forEach(function (item, i, ar) {
        if (item.isFolder()) {
          var children = item.children;
          children.forEach(function (item, i, ar) {
            var o = new Object();
            var temp = [];
            var $tdList = $(item.tr).find(">td");
            if ($tdList.length == 0) {
              return;
            } else {
              for (var c = 0; c < 12; c++) {
                temp.push($tdList.eq(3 + c)[0].children[0].selectedOptions[0].attributes.value.nodeValue);
              }
              var index = item.data.id;
              o[index] = temp;
            }
          });
        } else {
          var $tdList = $(item.tr).find(">td");
          if ($tdList.length == 0) {
            return;
          } else {
            var o = new Object();
            var temp = [];
            for (var c = 0; c < 12; c++) {
              temp.push($tdList.eq(3 + c)[0].children[0].selectedOptions[0].attributes.value.nodeValue);
            }
            var index = item.data.id;
            o[index] = temp;
          }
        }
        result.push(o);
      });

      var url = 'test-url';
      var csrf = $('meta[name=csrf-token]').attr("content");
      $.ajax({
        url: url,
        type: "post",
        data: {id: result, _csrf: csrf}
      }).done(function (response) {
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
                return;
              }
            }
          }
        });
      }).fail(function (response) {
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
      });
    });


    $("#tree").fancytree({
      checkbox: true,
      quicksearch: true,        // Jump to nodes when pressing first character
      source: {url: '/tehdoc/to/control/to-equipment/all-tools'},
      extensions: ["table"],
      minExpandLevel: 2,
      selectMode: 3,
      table: {
        indentation: 20,
        nodeColumnIdx: 2,
        checkboxColumnIdx: 0
      },
      createNode: function (event, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
        if (node.data.lvl == 0) {
          $tdList.eq(2).prop("colspan", 13);
          $tdList.eq(3).html(
            '<span class="fa fa-floppy-o save-it main" onclick="saveMe(this)" data-name="' + node.data.name + '" aria-hidden="true"></span>')
            .nextAll().remove();
        } else if (node.isFolder()) {
          $tdList.eq(2).prop("colspan", 13);
          $tdList.eq(3).html('').nextAll().remove();
        }
      },
      expand: function (node, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
        $tdList.eq(3).html(
          '<span class="fa fa-floppy-o save-it" onclick="saveMe(event)" data-name="' + node.data.name + '" aria-hidden="true"></span>');
        // console.log(data.node);
      },
      collapse: function (node, data) {
        var node = data.node,
          $tdList = $(node.tr).find(">td");
        $tdList.eq(3).html('');
      },
      activate: function (node, data) {
        var node = data.node;
        if (node.data.eq_id != 0) {
          $('#tool-ref').show();
        } else {
          $('#tool-ref').hide();
        }
      },
      renderColumns: function (event, data) {
        // var node = data.node,
        //   $tdList = $(node.tr).find(">td");
        // $tdList.eq(1).text(node.getIndexHier());
      }
    })
  });

  function saveMe(e) {
    // var nodeName = $(ident).data('name');
    // var tree = $("#tree").fancytree("getTree"),
    //   node = tree.findFirst(nodeName);
    //
    // var node = $.ui.fancytree.getNode(e);
    // console.log(node);


  }


</script>


