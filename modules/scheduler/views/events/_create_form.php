<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\AirDatepickerAsset;

AirDatepickerAsset::register($this);

?>

<style>
  .datepicker {
    z-index: 999999999;
  }
  .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
  }
</style>


<div>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>

  <div class="form-group">
    <?= $form->field($model, 'title')->textInput(['class' => 'date form-control'])->hint(' ', ['class' => ' w3-label-under']); ?>
  </div>
  <div class="form-group">
    <div class="col-lg-6 col-md-6 row">
      <?= $form->field($model, 'start_date')->textInput(['class' => 'date form-control'])->hint(' ', ['class' => ' w3-label-under']); ?>
    </div>
    <div class="col-lg-6 col-md-6">
      <?= $form->field($model, 'end_date')->textInput(['class' => 'date form-control'])->hint(' ', ['class' => ' w3-label-under']); ?>
    </div>
  </div>
  <div class="form-group">
    <?= $form->field($model, 'description')->textArea(array('style' => 'resize:vertical', 'rows' => '2')) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>


<script>

</script>