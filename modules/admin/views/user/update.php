<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\User;


$this->title = $model->username;

$userUrl = '/admin/user';

$this->params['breadcrumbs'][] = ['label' => 'Админ панель', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => [$userUrl]];
$this->params['breadcrumbs'][] = $this->title;

$password_hint = 'Сменить пароль пользователя';

?>

<div class="user-update">

  <div class="col-lg-7 col-md-7" style="border-radius: 2px">
    <h1><?= Html::encode($this->title) ?><sup>

      <?= Html::a('PASS',
          ['password-change?id=' . $model->id], [
              'class' => 'btn btn-primary btn-sm',
              'style' => [
                      'font-size' => '10px'
              ],
              'data-toggle' => "tooltip",
              'data-placement' => "top",
              'title' => $password_hint,
          ]) ?>
      </sup>
    </h1>
  </div>

  <div class="col-lg-6 col-md-6" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->hint('Например: Сидоров В.В.', ['class' => ' w3-label-under']); ?>
    <?= $form->field($model, 'login')->textInput()->hint('Например: Sidorov', ['class' => ' w3-label-under']) ?>
    <?= $form->field($model, 'social_group')->dropDownList(User::getGroupList(), ['prompt' => ['text' => 'Выберите', 'options' => ['value' => 'none', 'disabled' => 'true', 'selected' => 'true']]])->hint('Выберите из списка', ['class' => ' w3-label-under']) ?>
    <div class="form-group">
      <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Отмена', [$userUrl], ['class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>

  </div>

</div>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
