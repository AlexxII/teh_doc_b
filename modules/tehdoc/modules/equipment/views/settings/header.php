<?php

use yii\helpers\Html;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .head {
    border-bottom: 1px solid #e1e4e8;
    margin-bottom: 16px;
  }
  .subhead {
    margin-top: 40px;
    margin-bottom: 16px;
  }
  ::placeholder {
    color: #6a737d;
  }
  label {
    font-weight: 600;
  }
  .note {
    color: #586069;
    display: block;
    font-size: 12px;
    font-weight: 400;
    margin: 0;
  }
  .note-2 {
    color: #586069;
    display: block;
    font-size: 12px;
    font-weight: 400;
  }
  .form-checkbox {
    margin: 15px 0px;
    padding-left: 20px;
    vertical-align: middle;
  }
  .form-checkbox input[type="checkbox"], .form-checkbox input[type="radio"] {
    float: left;
    margin: 5px 0 0 -20px;
    vertical-align: middle;
  }
  .d-flex {
    display: flex !important;
  }
  .flex-items-center {
    align-items: center !important;
  }
  .pr-6 {
    padding-right: 40px !important;
  }
  .d-blue {
    background-color: #f1f8ff;
  }
  .border {
    border-radius: 3px !important;
    border: 1px solid #e1e4e8 !important;
    border-color: #c8e1ff !important;
  }
  .mr-5 {
    margin-right: 32px !important;
  }
  .mr-10 {
    margin-right: 64px !important;
  }
</style>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li><a href="../info/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li><a href="../wiki/index" style="cursor: pointer">Wiki</a></li>
  <li class="active"><a href="../settings/index">Настройки</a></li>
</ul>

<div class="complex-settings-index">
  <div class="head">
    <h3 class="setting-header">Общая информация</h3>
  </div>

  <?= $this->render('index', [
    'model' => $model
  ]) ?>

</div>
