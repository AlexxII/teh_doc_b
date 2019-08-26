<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\ColorPickerAsset;

ColorPickerAsset::register($this);

?>

<div>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <div class="form-group">
    <?= $form->field($model, 'title')->textInput([
      'class' => 'form-control',
      'id' => 'event-title'
    ])->hint(' ', ['class' => ' w3-label-under']); ?>
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
      'template' => '{label} {input}{hint}'
    ])->dropDownList($model->color, [
      'id' => 'colorpicker'
    ])->hint('', ['class' => ' w3-label-under']);
    ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>


<script>
  $(document).ready(function () {

    var stDate = $('#start-date').val();
    var eDate = $('#end-date').val();

    $('#start-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true
    });

    $('#end-date').datepicker({
      autoClose: true,
      language: "ru",
      todayHighlight: true
    });

    $('#colorpicker').simplecolorpicker();
  });

</script>