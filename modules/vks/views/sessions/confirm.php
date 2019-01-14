<?php

use yii\helpers\Html;

$this->title = 'Подтвердить прошедший сеанс';
$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = ['label' => 'Журнал', 'url' => ['index']];
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
