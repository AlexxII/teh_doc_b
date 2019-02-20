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
        'eq_manufact',
        'eq_model',
        'eq_serial',
        [
          'label' => 'Место размещения:',
          'value' => '1'//$model->placementTitle,
        ],
        [
          'label' => 'Изображения:',
          'format' => 'raw',
          'value' => $model->photos ? '<a href="#" style="color: #3f51b5">' . count($model->photos) . ' штук(и)' . '</a>' : 'отсутствуют',
        ]
      ],
    ]) ?>
</div>
<br>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


