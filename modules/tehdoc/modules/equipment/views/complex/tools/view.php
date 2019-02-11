<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<div id="complex-info" style="margin-top: 15px">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        [
          'label' => 'Категория:',
          'value' => $model->categoryTitle,
        ],
        'complex_title',
        'complex_manufact',
        'complex_model',
        'complex_serial',
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


