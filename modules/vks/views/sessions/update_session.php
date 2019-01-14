<?php

use yii\helpers\Html;

$this->title = 'Обновить прошедший сеанс';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = ['label' => 'Архив', 'url' => ['archive']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tool-create">

  <div class="col-lg-12 col-md-12" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?></h1>
  </div>

  <?= $this->render('_form_conf', [
    'model' => $model,
  ]) ?>

</div>
