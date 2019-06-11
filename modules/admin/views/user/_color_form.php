<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\ColorPickerAsset;

ColorPickerAsset::register($this);

?>

<div>
  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <?php $disParams = [
    '#dbadff' => ['disabled' => true]
  ] ?>

  <div class="form-group">
    <?= $form->field($model, 'color_scheme', [
      'template' => '{label} {input}{hint}'
    ])->dropDownList($model->colorList, [
      'id' => 'colorpicker',
      'options' => $disParams
    ])->hint('', ['class' => ' w3-label-under']);
    ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

<script>
  $(document).ready(function () {

    $('#colorpicker').simplecolorpicker();

  });
</script>