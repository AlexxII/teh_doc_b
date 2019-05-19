<?php

use yii\helpers\Html;

Yii::$app->cache->flush();

$about = 'Профиль пользователя';

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="admin-category-pannel row">
  <div class="col-md-3 col-lg-3">
    <a href="#" class="thumbnail">
      <img src="/lib/no_avatar.svg" style="width: 250px;height: 250px">
    </a>
  </div>

  <div class="col-md-9 col-lg-9">
    <h3>
      <span style="font-weight:100; font-size: 16px">
      <?= Html::encode('Пользователь:') ?>
      </span>
      <?php echo Yii::$app->user->identity->username; ?>
    </h3>
    <h3 style="padding-bottom: 10px">
      <span style="font-weight:100; font-size: 16px">
      <?= Html::encode('Логин:') ?>
      </span>
      <?php echo Yii::$app->user->identity->login; ?>
    </h3>
    <a class="btn btn-primary btn-sm" role="button" disabled="true">Сменить пароль</a>
    <a class="btn btn-primary btn-sm" role="button">График</a>
  </div>
</div>


<script>

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

</script>