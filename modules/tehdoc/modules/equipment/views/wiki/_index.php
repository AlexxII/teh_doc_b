<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Перечень оборудования';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .panel-body {
    padding: 5px;
  }
  .d-block {
    text-decoration: #0b3e6f;
  }
</style>

<ul class="nav nav-tabs" id="main-teh-tab">
  <li><a href="../info/index">Инфо</a></li>
  <li><a href="../files/index">Файлы</a></li>
  <li class="active"><a href="../wiki/index" style="cursor: pointer">Wiki</a></li>
  <li><a href="../settings/index">Настройки</a></li>
</ul>

<div class="complex-wiki-default" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-12 col-md-12" style="text-align: center">
      <i class="fa fa-book" aria-hidden="true" style="font-size: 28px"></i>
      <h3>Добро пожаловать в Wiki</h3>
      <p>Добавляйте любую текстовую информацию о данном оборудовании.</p>
      <p><a href="create" id="new-wiki-page" class="btn btn-sm btn-success">Создать первую страницу</a></p>
    </div>
  </div>
</div>

