<?php

use yii\helpers\Html;

$this->title = 'Добавить комплект';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/tehdoc/equipment/complex']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="complex-create">

  <div class="row" style="border-radius:2px;padding-left:15px">
    <h3><?= Html::encode($this->title) ?></h3>
  </div>

  <?= $this->render('_form', [
    'modelComplex' => $modelComplex,
    'modelsTool' => $modelsTool,
    'fupload' => $fUpload,
  ]) ?>

</div>
