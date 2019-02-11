<?php

use yii\widgets\DetailView;

?>

<div id="complex-info" style="margin-top: 15px">

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'name'
    ],
  ]) ?>
</div>
