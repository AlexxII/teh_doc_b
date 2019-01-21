<?php

use yii\helpers\Html;

$this->title = 'Обновить предстоящий сеанс';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = ['label' => 'Журнал', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="session-update">

  <div class="col-lg-12 col-md-12" style="border-radius: 2px">
    <h3><?= Html::encode($this->title) ?></h3>
  </div>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
