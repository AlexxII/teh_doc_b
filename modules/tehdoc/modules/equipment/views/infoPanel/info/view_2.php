<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div id="complex-info" style="padding-top: 10px">
  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      [
        'label' => 'Категория:',
        'value' => $model->categoryTitle,
      ],
      'eq_title',
      [
        'label' => 'Место размещения:',
        'value' => $model->placementTitle,
      ],
    ],
  ]) ?>
</div>
<hr>
<span>В составе:</span>

<?php
foreach ($children as $child) {
  echo '<h4>' . $child->name . '</h4>';
  echo DetailView::widget([
    'model' => $child,
    'attributes' => [
      [
        'label' => 'Категория:',
        'value' => $model->categoryTitle,
      ],
      'eq_manufact',
      'eq_model',
      'eq_serial',
      [
        'label' => 'Место размещения:',
        'value' => $model->placementTitle,
      ],
    ],
  ]);
  echo '<hr>';
}
?>

<br>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


