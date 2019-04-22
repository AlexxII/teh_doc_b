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

  <div class="col-lg-12 col-md-12" style="padding-bottom: 10px">
    <div class="col-lg-4 col-md-4" style="position: relative">
      <div class="container-fuid" style="float:left; width: 100%">
        <input class="form-control form-control-sm" autocomplete="off" name="search" placeholder="Поиск...">
      </div>
      <div style="padding-top: 8px; right: 20px; position: absolute">
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
  </tr>
  </thead>
  <tbody>
  <!-- Define a row template for all invariant markup: -->
  <tr>
    <td class="alignCenter"></td>
    <td></td>
    <td></td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
    <td>
      <select name="sel1" id="">
        <option value=0>М</option>
        <option value=1>Г</option>
      </select>
    </td>
  </tr>
  </tbody>
</table>


<script>

    $(document).ready(function () {
        $('#refresh').click(function (event) {
            event.preventDefault();
            var tree = $("#tree").fancytree("getTree");
            tree.reload();
            $("#del-node").hide();
            $('.c-select').prop('disabled', true);
            $('.c-select').val('none');
            $('#submit').prop('disabled', true);
            $('#result').html('');
            $('#result-info').html('');
        })
    });

    $(function () {

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
            lazyLoad: function (event, data) {
                data.result = {url: "../demo/ajax-sub2.json"};
            },
            createNode: function (event, data) {
                var node = data.node,
                    $tdList = $(node.tr).find(">td");
                if (node.isFolder()) {
                    $tdList.eq(2)
                        .prop("colspan", 20)
                        .nextAll().remove();
                }
            },
            renderColumns: function (event, data) {
                var node = data.node,
                    $tdList = $(node.tr).find(">td");
                    $tdList.eq(1).text(node.getIndexHier());
//                $tdList.eq(3).text(node.data.qty);
            }
        })
    });

</script>


