<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\tehdoc\models\Equipment;
use app\modules\tehdoc\asset\TehFormAsset;

?>


<style>
  #tool-edit-form .fa {
    font-size: 15px;
  }
  .nonreq {
    color: #1e6887;
  }
  .select-selected {
    padding-left: 40px;
  }
  .w3-label-under {
    font-size: 10px;
    padding-left: 5px;
  }

</style>

<?php
TehFormAsset::register($this);

// текст к подсказкам
$serial_hint = 'Укажите серийный номер (s/n), на некоторых моделях оборудования указывается только производственный номер (p/n), 
                  тогда укажите его.';
$place_hint = 'Укажите точное размещение оборудования.';
$date_hint = 'Если не известен месяц, выберите январь известного года.';
$quantity_hint = 'Внимание! Указывайте отличную от 1 цифру 
ТОЛЬКО для идентичного оборудования и расходных материалов. Например: офисная бумага, батарейки. 
Будьте ВНИМАТЕЛЬНЫ, не вводите себя в заблуждение.';

?>

<div id="tool-edit-form">
  <div class="col-lg-12 col-md-12" style="border-radius:2px;padding-top:10px">
    <div class="customer-form">
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?php
          echo $form->field($model, 'category_id', [
            'template' => '{label}{input}{hint}'])
            ->dropDownList($model->toolCategoryList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
              'options' => [
                'value' => 'none',
                'disabled' => 'true',
                'selected' => 'true'
              ]]])->hint('Выберите категорию', ['class' => ' w3-label-under']);
          ?>
        </div>
        <div class="col-md-6 col-lg-6">
          <?= $form->field($model, 'eq_title', [
            'template' => '{label}{input}{hint}'])
            ->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?= $form->field($model, 'eq_manufact')->textInput(['id' => 'manufact'])
            ->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="col-md-6 col-lg-6">
          <?= $form->field($model, 'eq_model')->textInput(['id' => 'models'])
            ->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <?= $form->field($model, 'eq_serial', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="right" title="' . $serial_hint . '"></sup>{input}{hint}'
          ])->textInput()->hint('Например: HRUEO139UI92', ['class' => ' w3-label-under']); ?>

        </div>
        <div class="form-group col-md-6 col-lg-6">
          <?= $form->field($model, 'eq_factdate', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $date_hint . '"></sup>{input}{hint}'
          ])->textInput([
            'class' => 'fact-date form-control'
          ])->hint('Выберите дату', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <?php
          echo $form->field($model, 'place_id', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $place_hint . '"></sup>{input}{hint}'
          ])->dropDownList($model->toolPlacesList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('Выберите место нахождения оборудования', ['class' => ' w3-label-under']);
          ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'quantity', [
            'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'])
            ->textInput()->hint('Введите количество', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <?= $form->field($model, 'eq_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '2')) ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php ActiveForm::end(); ?>

<script>

  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $('.fact-date').datepicker({
      format: 'MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "months",
      minViewMode: "months",
      clearBtn: true
    });

    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('MMMM YYYY'))
    }

  });

  loadManufacturers();
  loadModels();

</script>