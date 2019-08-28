<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<style>
  h2 {
    font-family: 'Google Sans', Roboto, Arial, sans-serif;
    font-size: 18px;
    font-weight: 400;
    line-height: 24px;
    padding-left: 0;
    margin-top: 0;
    color: #70757a;
  }
  .create-calendar {
    margin: 10px 20px 0 0;
  }
</style>

<div class="col-lg-6 col-md-6">
  <h2>Добавить календарь</h2>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="form-group">
    <?= $form->field($model, 'color', [
      'template' => '{label} {input}{hint}'
    ])->dropDownList($model->colorList, [
      'id' => 'colorpicker'
    ])->hint('', ['class' => ' w3-label-under']);
    ?>
  </div>
  <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary create-calendar']) ?>

  <?php ActiveForm::end(); ?>
</div>


<script>

</script>