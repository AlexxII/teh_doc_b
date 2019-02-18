<?php

use yii\helpers\Html;

$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;
?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active"><a href="../info/index">Инфо</a></li>
  <li><a href="../settings/index">Настройки</a></li>
</ul>

<div class="tool-update">
  <div class="head col-lg-9">
    <h3><?= Html::encode($model->eq_title) ?></h3>
  </div>
  <div class="col-lg-2">
    <a type="button" href="/tehdoc/equipment/tool/<?= $model->ref?>/info/index" class="btn-primary btn-sm">НАЗАД</a>
  </div>

  <?= $this->render('_form', [
    'model' => $model
  ]) ?>

</div>
