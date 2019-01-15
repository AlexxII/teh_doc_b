<?php

use yii\helpers\Html;

$this->title = 'Добавить предстоящий сеанс';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = ['label' => 'Журнал', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="session-create">

  <div class="row" style="border-radius:2px;padding-left:15px;margin-top: -10px">
    <h3><?= Html::encode($this->title) ?></h3>
  </div>

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
