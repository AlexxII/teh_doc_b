<?php

use yii\helpers\Html;

$this->title = 'Добавить оборудование';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Перечень оборудования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tool-create">

  <div class="row" style="border-radius:2px;padding-left:15px;margin-top: -10px">
    <h3><?= Html::encode($this->title) ?></h3>
  </div>

  <?= $this->render('_form', [
    'model' => $model,
    'fUpload' => $fupload
  ]) ?>

</div>
