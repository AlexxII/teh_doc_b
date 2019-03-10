<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

$title_hint = 'Укажите точное наименование документа.';
$date_hint = 'Дата документа.';

?>

<div id="complex-docs">
  <div class="">
    <h3 style="padding-bottom: 15px">Документы</h3>
    <div class="calendar">
      <ul class="list-inline" style="border-top: 1px solid #cbcbcb;">
        <li><a href="#">2017</a></li>
        <li><a href="#">2018</a></li>
        <li><a href="#">2019</a></li>
      </ul>
      <ul class="calendar-month list-inline" style="display: block;">
        <li><a href="#">Январь</a></li>
        <li><a href="#">Февраль</a></li>
        <li><a href="#">Март</a></li>
        <li><a href="#">Апрель</a></li>
        <li><a href="#">Май</a></li>
        <li><a href="#">Июнь</a></li>
        <li><a href="#">Июль</a></li>
        <li><a href="#">Август</a></li>
        <li><a href="#">Сентябрь</a></li>
        <li><a href="#">Ноябрь</a></li>
        <li><a href="#">Декабрь</a></li>
      </ul>
    </div>
  </div>

  <div style="padding-top: 15px">
    <?php $form = ActiveForm::begin([
      'options' => [
        'enctype' => 'multipart/form-data'],
      'action' => 'add-new'
    ]); ?>
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'doc_title', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'])
          ->textInput()->hint('Например: Акт готовности объекта', ['class' => ' w3-label-under']); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-lg-6">
        <?= $form->field($model, 'doc_date', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
        ])->textInput([
          'class' => 'fact-date form-control'
        ])->hint('Введите или выберите дату документа', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="col-md-6 col-lg-6">
        <div class="row">
          <div class="col-md-12 col-lg-12">
            <?= $form->field($model, "docFiles")->widget(FileInput::class, [
              'language' => 'ru',
              'options' => ['multiple' => false],
              'pluginOptions' => [
                'showPreview' => false,
                'showUpload' => false,
                'showCaption' => true,
                'showRemove' => true,
                'browseLabel' => '',
                'removeLabel' => '',
              ]

            ]); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>

</div>

<script>
  $(document).ready(function () {
    $('.fact-date').datepicker({
      format: 'dd MM yyyy г.',
      autoclose: true,
      language: "ru",
      clearBtn: true
    })

    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('MMMM YYYY'))
    }
  });
</script>