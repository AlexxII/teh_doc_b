<?php

use yii\helpers\Html;

$this->title = 'Обновить данные';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/tehdoc/equipment/complex']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="complex-create">

  <div class="col-lg-12 col-md-12" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?></h1>
  </div>

  <?= $this->render('_form', [
    'modelComplex' => $modelComplex,
    'modelsTool' => $modelsTool,
    'fupload' => $fUpload,
  ]) ?>

</div>
