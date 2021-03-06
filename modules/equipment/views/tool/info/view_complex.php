<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$attributes = [
];

?>

<div id="complex-info" style="padding-top: 10px">
  <?php
  if (!empty($attributes)) {
    echo DetailView::widget([
      'id' => 'tool-detail',
      'model' => $model,
      'attributes' => $attributes
    ]);
  }
  ?>
  <span>В составе:</span>

  <?php
  $attr = [];
  foreach ($children as $child) {

    $attr = [
      [
        "label" => "Категория:",
        "value" => $child->categoryTitle,
      ],
      "eq_manufact",
      "eq_model",
      "eq_serial",
      [
        "label" => "Место размещения:",
        "value" => $child->placementTitle,
      ],
      "quantity",
      "eq_comments"
    ];

    if ($child->specialStatus) {
      $attr[] = [
        "label" => "Спецпроверка:",
        "value" => $child->specialStickerNumber,
      ];
    }

    echo '<h3 class="tool-ref" style="cursor: pointer" data-tool-id="' . $child->id . '">
        <span style="position: relative">';
    echo Html::encode($child->name);
    if ($child->specialChildrenStatus || $child->specialStatus) {
      echo '<i class="fa fa-shield" aria-hidden="true" style="font-size: 18px; position: absolute;top:-5px;right:-15px"
             title="Проведены Специальные работы"></i>';
    }
    echo "</span>";
    echo "</h3>";

    echo DetailView::widget([
      "id" => "tool-detail",
      "model" => $child,
      "attributes" => $attr
    ]);
  }

  ?>
</div>

<script>
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();


  });

</script>


