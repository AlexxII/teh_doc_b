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

  <h3><?= Html::encode($model->eq_title) ?></h3>

  <?= $this->render('_form', [
    'model' => $model
  ]) ?>

</div>
