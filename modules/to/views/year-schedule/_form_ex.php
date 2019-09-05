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

    <div class="row" style="padding: 0 15px">
      <div style="border-radius:2px;padding-top:40px">
        <div id="fancyree_w0" class="ui-draggable-handle"></div>
      </div>
    </div>
  </div>


  <div class="col-lg-7 col-md-7">
    <div class="alert alert-warning" style="margin-bottom: 10px">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <strong>Внимание!</strong>
    </div>
    <div id="result-info" style="margin-bottom: 10px"></div>
    <div id="content-info" style="margin-bottom: 10px">
    </div>
  </div>
</div>


<script>

  var nodeId;
  var node$;

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

  function warningAlert(text) {
    var div = '' +
      '<div id="w3-success-0" class="alert-warning alert fade in">' +
      '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
      text +
      '</div>';
    return div;
  }

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#add-subcategory').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree('getTree');
      var root = tree.findFirst('Оборудование');
      root.editCreateNode("child", " ");
    });

    $('#refresh').click(function (event) {
      event.preventDefault();
      var tree = $(".ui-draggable-handle").fancytree("getTree");
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
      var node = $(".ui-draggable-handle").fancytree("getActiveNode");
      var toolId = node.data.eq_id;
      var prefix = '/tehdoc/equipment/tool/';
      var href = prefix + toolId + '/info/index';
      if (event.ctrlKey) {
        window.open(href);
      } else {
        location.href = href;
      }
    })
  });

  $(document).ready(function () {
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
  });


  // отображение и логика работа дерева
  jQuery(function ($) {
    var main_url = '/to/control/to-equipment/all-tools';

    $("#fancyree_w0").fancytree({
      source: {
        url: main_url
      },
      extensions: ['filter', 'multi'],
      quicksearch: true,
      checkbox: false,
      selectMode: 3,
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
        var node = data.node;
        if (node.data.eq_id != 0) {
          $('#tool-ref').show();
        } else {
          $('#tool-ref').hide();
        }

      },
      click: function (event, data) {
      },
      renderNode: function (node, data) {
      }
    })
    ;
  });


</script>