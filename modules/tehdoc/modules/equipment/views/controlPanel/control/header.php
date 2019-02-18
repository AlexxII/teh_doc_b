<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active"><a href="../info/index">Инфо</a></li>
  <li><a href="../settings/index">Настройки</a></li>
</ul>

<div class="control-panel-index" style="margin-top: 15px">
  <div class="">
    <div class="">
      <h3 style="margin-top: 0px"><?= Html::encode('ИНФО') ?></h3>
    </div>
  </div>
  <?= $this->render('index') ?>

</div>
