<?php

use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$title_hint = 'Укажите точное наименование документа';
$date_hint = 'Дата документа';

?>
<style>
  .w3-label-under {
    font-size: 10px;
    padding-left: 5px;
  }
</style>

<div id="complex-docs">

  <div style="padding-top: 15px">
    <?php $form = ActiveForm::begin([
      'options' => [
        'enctype' => 'multipart/form-data']
    ]); ?>
    <div class="">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'doc_title', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-container="body" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'])
          ->textInput()->hint('Например: Акт готовности объекта', ['class' => 'w3-label-under']); ?>
      </div>
    </div>
    <div class="">
      <div class="col-md-6ы col-lg-6">
        <?= $form->field($model, 'doc_date', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-container="body" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
        ])->textInput([
          'class' => 'doc-date form-control'
        ])->hint('Веберите или введите дату документа (формат: дд.мм.гггг)', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="col-md-6 col-lg-6">
        <?= $form->field($model, "docFiles")->widget(FileInput::class, [
          'language' => 'ru',
          'options' => ['multiple' => false, 'id' => 'doc-file'],
          'pluginOptions' => [
            'showPreview' => false,
            'showUpload' => false,
            'showCaption' => true,
            'showRemove' => true,
            'browseLabel' => '',
            'removeLabel' => '',
          ],
          'pluginEvents' => [
            'filebatchselected' => 'function() {
                 $(this).fileinput("upload");
                 }',
          ],
        ]); ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>

</div>

<script>

  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();


    $('.doc-date').datepicker({
      format: 'dd MM yyyy г.',
      autoclose: true,
      language: "ru",
      clearBtn: true
    });

    if ($('.doc-date').val()) {
      var date = new Date($('.doc-date').val());
      moment.locale('ru');
      $('.doc-date').datepicker('update', moment(date).format('MMMM YYYY'))
    }

  });
</script>