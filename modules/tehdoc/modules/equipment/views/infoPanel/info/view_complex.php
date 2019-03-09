<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div id="complex-info" style="padding-top: 10px">
  <span>В составе:</span>

  <?php

  $attr = [];

  foreach ($children as $child) {

    $attr = [
      [
        'label' => 'Категория:',
        'value' => $child->categoryTitle,
      ],
      'eq_manufact',
      'eq_model',
      'eq_serial',
      [
        'label' => 'Место размещения:',
        'value' => $child->placementTitle,
      ],
    ];

    if (false) {
      $attr[] = [
        'label' => 'Место размещения:',
        'value' => $child->placementTitle,
      ];
    }

    echo '<h3>' . $child->name . '</h3>';
    echo DetailView::widget([
      'model' => $child,
      'attributes' => $attr
    ]);
  }

  ?>
</div>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


