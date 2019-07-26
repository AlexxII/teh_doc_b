<?php

use yii\helpers\Markdown;
use yii\helpers\Html;

?>

<style>
  .panel-body {
    padding: 5px;
  }
  .d-block {
    text-decoration: #0b3e6f;
  }
</style>

<div class="complex-wiki-update" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px"><?= Html::encode($model->wiki_title) ?></h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <a href="update?page=<?= $model->id ?>" id="update-wikipage" class="btn btn-sm btn-primary">Edit</a>
        <a href="" id="create-wikipage" class="btn btn-sm btn-success">New</a>
      </p>
    </div>
  </div>

  <div class="complex-wiki">
    <div class="wiki-content">
      <div id="wiki-body" class="col-lg-9 col-md-9" style="padding-left:0px">
        <?= Markdown::process($model->wiki_text, 'extra') ?>
      </div>
      <div id="wiki-rightbar" class="col-lg-3 col-md-3 text-right" style="padding: 0px">
        <div class="panel panel-default">
          <div class="panel-heading" style="text-align: left">
            Страницы
          </div>
          <ul class="list-group">
            <?php
            foreach ($list as $item) {
              echo '<li class="list-group-item"><a href="view?page=' . $item["id"] . '">' . $item["wiki_title"] . '</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>