<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active"><a href="../info/index" data-url="">Инфо</a></li>
  <li><a href="../files/index" data-url="complex/files">Файлы</a></li>
  <li><a href="../wiki/index" data-url="wiki/index">Wiki</a></li>
  <li><a href="../settings/index" data-url="settings">Настройки</a></li>
</ul>

<div id="complex-info" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
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
