<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);

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
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="form-group">
    <div class="col-lg-6 col-md-6">
      <?= $form->field($model, 'user_id')->dropDownList($model->userList, [
        'id' => 'user'
      ])->hint('', ['class' => ' w3-label-under']);
      ?>
    </div>
    <div class="col-lg-6 col-md-6">
      <?= $form->field($model, 'duration')->textInput([
        'class' => 'form-control',
        'id' => 'duration',
        'readonly' => 'true'
      ])->hint(' ', ['class' => ' w3-label-under']); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-lg-6 col-md-6">
      <?= $form->field($model, 'start_date')->textInput([
        'class' => 'date form-control',
        'id' => 'start-date',
        'readonly' => 'true'
      ])->hint(' ', ['class' => ' w3-label-under']); ?>
    </div>
    <div class="col-lg-6 col-md-6">
      <?= $form->field($model, 'end_date')->textInput([
        'class' => 'date form-control',
        'id' => 'end-date',
        'readonly' => 'true'
      ])->hint(' ', ['class' => ' w3-label-under']); ?>
    </div>
  </div>
  <?php ActiveForm::end(); ?>
</div>


<script>
  $(document).ready(function () {

    $('#start-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true,
      weekends: [6, 0]
    });

    $('#end-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true,
      weekends: [6, 0]
    });

  });

</script>