<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$placeholder = 'Название страницы';

?>

<div class="row">
  <div class="col-lg-12 col-md-12" style="border-radius:2px;padding-top:10px">
    <div class="customer-form">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <?= $form->field($model, 'wiki_title')->textInput(['placeholder' => $placeholder])->label(false) ?>
        </div>
        <div class="col-md-12 col-lg-12">
          <?= $form->field($model, 'wiki_text')->textArea(array('style' => 'resize:vertical', 'rows' => '10'))->label(false) ?>
        </div>
      </div>
      <div class="form-group" style="text-align: right">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
      </div>

      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    var simplemde = new SimpleMDE({
      showIcons: ["code", "table"],
    });
  })
</script>