<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Перечень оборудования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li><a href="../info/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li class="active"><a href="../wiki/index" style="cursor: pointer">Wiki</a></li>
  <li><a href="../settings/index">Настройки</a></li>
</ul>

<div class="complex-wiki-create">
  <h3><?= Html::encode('Создать новую страницу') ?></h3>
  <?= $this->render('_form', [
    'model' => $model
  ]) ?>

</div>
