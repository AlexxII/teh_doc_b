<?php

use yii\helpers\Html;

$this->title = 'Обновить';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = ['label' => 'Перечень оборудования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tool-update">

  <div class="col-lg-7 col-md-7" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?></h1>
  </div>

  <?= $this->render('_form', [
      'model' => $model,
      'fUpload' => $fupload,
  ]) ?>

</div>
