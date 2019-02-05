<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;

?>
<div class="tool-view">

  <div class="row">

    <div class="col-lg-10 col-md-10">
      <h3 style="margin-top: 0px"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="col-lg-2 col-md-2 text-right">
      <p>
        <?= Html::a('Изменить', ['update-c', 'id' => $model->ref], ['class' => 'btn btn-sm btn-primary ']) ?>
      </p>
    </div>
  </div>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'name'
    ],
  ]) ?>

</div>