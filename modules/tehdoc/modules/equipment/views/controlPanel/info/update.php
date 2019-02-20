<?php

use yii\helpers\Html;

$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  td {
    text-align: center;
  }
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
  .d-flex {
    display: flex !important;
  }
  .flex-items-center {
    align-items: center !important;
  }
  .Counter {
    background-color: rgba(27, 31, 35, .08);
    border-radius: 20px;
    color: #586069;
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    padding: 2px 5px;
    font-family: BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif,
    Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
  }
</style>


<ul class="nav nav-tabs" id="main-teh-tab">
  <li class="active">
    <a href="../info/index">
      Инфо
    </a>
  </li>
  <li>
    <a href="../docs/index">
      Docs
      <span class="Counter"><?= $wiki ?></span>
    </a>
  </li>
  <li>
    <a href="../foto/index">
      Foto
      <span class="Counter"><?= $wiki ?></span>
    </a>
  </li>
  <li>
    <a href="../settings/index" style="cursor: pointer">
      Настройки
    </a>
  </li>
</ul>


<div class="tool-update">

  <div class="row d-flex flex-items-center">
    <div class="col-lg-11 col-md-11 col-xs-11">
      <h3><?= Html::encode($model->name) ?></h3>
    </div>
    <div class="text-right" style="padding: 7px 15px 0 0">
      <a type="button" href="/tehdoc/equipment/tool/<?= $model->ref?>/info/index"
         class="btn-primary btn-sm">View</a>
    </div>
  </div>

  <?= $this->render('_form', [
    'model' => $model
  ]) ?>

</div>
