<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li><a href="../info/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li class="active"><a href="/index" style="cursor: pointer">Wiki</a></li>
</ul>

<div class="complex-wiki-update" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px"><?= Html::encode($model->wiki_title) ?></h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <a href="update?page=<?= $model->id ?>" class="btn btn-sm btn-primary">Edit</a>
        <a href="create" class="btn btn-sm btn-success">New</a>
      </p>
    </div>
  </div>
  <?= $this->render('index', [
    'model' => $model,
    'list' => $list
  ]) ?>

</div>
