<?php

use yii\helpers\Html;

$this->title = 'Панель управления';
$this->params['breadcrumbs'][] = ['label' => 'Тех.документация', 'url' => ['/tehdoc']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .calendar ul {
    border-bottom: 1px solid #cbcbcb;
    display: block;
    margin: 0 !important;
    overflow: hidden;
    padding: 10px 0;
  }
  .calendar li {
    float: left;
    overflow: hidden;
    padding: 3px 4px;
    font-size: 15px;
  }
  .calendar li {
    border: 2px solid transparent;
    cursor: pointer;
  }
  .calendar li:hover {
    border: 2px solid #d1c8a6;;
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
  <li>
    <a href="../info/index">
      Инфо
    </a>
  </li>
  <li class="active">
    <a href="../docs/index">
      Docs
      <span class="Counter"><?= $docsCount ?></span>
    </a>
  </li>
  <li>
    <a href="../foto/index">
      Foto
      <span class="Counter"><?= $imagesCount ?></span>
    </a>
  </li>
  <li>
    <a href="../settings/index" style="cursor: pointer">
      Настройки
    </a>
  </li>
</ul>


<div class="complex-wiki-update" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px"><?= Html::encode('Документы') ?></h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <a href="create" class="btn btn-sm btn-success">Добавить</a>
      </p>
    </div>
  </div>

  <?= $this->render('index', [
    'docModels' => $docModels
  ]) ?>

</div>


<div class="complex-docs-control">

</div>
