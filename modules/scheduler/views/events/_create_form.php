<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\AirDatepickerAsset;
use app\assets\ColorPickerAsset;

AirDatepickerAsset::register($this);
ColorPickerAsset::register($this);

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
    <?= $form->field($model, 'title')->textInput([
      'class' => 'date form-control',
      'id' => 'event-title'
    ])->hint(' ', ['class' => ' w3-label-under']); ?>
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
  <div class="form-group">
    <?= $form->field($model, 'description')->textArea([
      'style' => 'resize:vertical',
      'rows' => '2',
      'id' => 'event-description'
    ]) ?>
  </div>
  <div class="form-group">
    <?= $form->field($model, 'color', [
      'template' => "{label}{input}"
    ])->input('color', ['id' => "event-color"]) ?>

    <?= $form->field($model, 'color', [
      'template' => '{label}{input}{hint}'
    ])->dropDownList($model->colorList, [
      'data-name' => 'vks_order',
      'id' => 'colorpicker'
    ])->hint('', ['class' => ' w3-label-under']);
    ?>

  </div>
  <div>
    <select name="colorpicker">
      <option value="#7bd148">Green</option>
      <option value="#5484ed">Bold blue</option>
      <option value="#a4bdfc">Blue</option>
      <option value="#46d6db">Turquoise</option>
      <option value="#7ae7bf">Light green</option>
      <option value="#51b749">Bold green</option>
      <option value="#fbd75b">Yellow</option>
      <option value="#ffb878">Orange</option>
      <option value="#ff887c">Red</option>
      <option value="#dc2127">Bold red</option>
      <option value="#dbadff">Purple</option>
      <option value="#e1e1e1">Gray</option>
    </select>
  </div>

  <?php ActiveForm::end(); ?>
</div>


<script>
  $(document).ready(function () {
    $('#start-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true,
      weekends: [6, 0],
      timepicker: true,
    });

    $('#end-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true,
      weekends: [6, 0],
      timepicker: true,
    });

    $('#colorpicker').simplecolorpicker();
  });

</script>