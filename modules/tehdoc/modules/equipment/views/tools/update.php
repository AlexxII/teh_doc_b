<?php

use yii\helpers\Html;

$this->title = 'Добавить';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Перечень оборудования', 'url' => ['/tehdoc/equipment/tools']];
$this->params['breadcrumbs'][] = ['label' => 'Задание на добавление', 'url' => ['/tehdoc/equipment/tools/task']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tool-create">

  <h3><?= Html::encode($this->title) ?></h3>
  <?= $this->render('_form', [
    'model' => $model,
    'fUpload' => $fupload
  ]) ?>

</div>
