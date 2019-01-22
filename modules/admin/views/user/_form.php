<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;


// TODO Добавить checkbox - возвращаться в данную форму после сохранения.

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/admin/user']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .fa {
    font-size: 15px;
    /*color: #1e6887;*/
    color: #FF0000;
  }

  .nonreq {
    color: #1e6887;
  }
</style>


<div class="user-create">

  <div class="col-lg-7 col-md-7" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?></h1>
  </div>


  <div class="col-lg-6 col-md-6" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->hint('Например: Сидоров В.В.', ['class' => ' w3-label-under']); ?>
    <?= $form->field($model, 'login')->textInput()->hint('Например: Sidorov', ['class' => ' w3-label-under']) ?>
    <?= $form->field($model, 'password')->passwordInput()->hint('Длина пароля не менее 6 символов', ['class' => ' w3-label-under']) ?>
    <?= $form->field($model, 'social_group')->dropDownList($model->groupList, ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('Выберите из списка', ['class' => ' w3-label-under']) ?>
    <div class="form-group">
      <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

  </div>
</div>

  <script>
      $(document).ready(function () {
          $('[data-toggle="tooltip"]').tooltip();
      });
  </script>

