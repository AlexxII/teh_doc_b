<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  td {
    text-align: center;
  }
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
</style>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active"><a href="/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li><a href="../wiki/index" style="cursor: pointer">Wiki</a></li>
</ul>

<div class="complex-info-view">
  <div class="head">
    <h3><?= Html::encode($model->name) ?></h3>
  </div>

  <?= $this->render('view', [
    'model' => $model
  ]) ?>

</div>
