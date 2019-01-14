<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\people\models\PasswordChangeForm */

$this->title = 'Смена пароля';
$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['/admin/user']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-password-change">

  <div class="col-lg-7 col-md-7" style="border-radius: 2px">
    <h1><?= Html::encode($this->title . ' ' . $model->userName) ?></h1>
  </div>

  <div class="col-lg-6 col-md-6" style="border-radius:2px;padding-top:10px">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Сохранить'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>

</div>