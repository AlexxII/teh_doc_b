<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>


<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active"><a href="../info/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li><a href="../wiki/index" style="cursor: pointer">Wiki</a></li>
  <li><a href="../settings/index">Настройки</a></li>
</ul>

<div class="complex-wiki-create">
  <div class="head">
    <h3><?= Html::encode($model->name) ?></h3>
  </div>

  <?= $this->render('index', [
    'model' => $model
  ]) ?>

</div>
