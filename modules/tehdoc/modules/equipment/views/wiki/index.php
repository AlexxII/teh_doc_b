<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//$this->title = $model->name;
$this->title = $model->wiki_title;

?>

<style>
  .panel-body {
    padding: 5px;
  }
  .d-block {
    text-decoration: #0b3e6f;
  }
</style>

<div class="info-view">

  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary ']) ?>
        <?= Html::a('New', ['complex/wiki/create', 'id' => $model->id], ['class' => 'btn btn-sm btn-success ']) ?>
      </p>
    </div>
  </div>

  <div class="wiki-content">
    <div id="wiki-body" class="col-lg-9 col-md-9" style="padding-left:0px">
      <?= $model->wiki_text ?>

    </div>
    <div id="wiki-rightbar" class="col-lg-3 col-md-3 text-right" style="padding: 0px">
      <div class="panel panel-default">
        <div class="panel-heading" style="text-align: left">
          Страницы
        </div>
        <ul class="list-group">
          <li class="list-group-item">
            <a class="" href="#">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

</div>