<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use app\modules\tehdoc\models\Equipment;
use app\modules\tehdoc\asset\TehFormAsset;

// TODO Добавить checkbox - возвращаться в данную форму после сохранения.

?>


<?php
TehFormAsset::register($this);

// текст к подсказкам
$cat_hint = 'Обязательное! Необходима для классификации оборудования.';
$title_hint = 'Обязательное! Необходимо для отображения в таблице.';
$serial_hint = 'Укажите серийный номер (s/n), на некоторых моделях оборудования указывается только производственный номер (p/n), 
                  тогда укажите его.';
$place_hint = 'Обязательное! Укажите точное размещение оборудования.';
$date_hint = 'Если не известен месяц, выберите январь известного года.';
$quantity_hint = 'Внимание! Указывайте отличную от 1.php цифру 
ТОЛЬКО для идентичного оборудования и расходных материалов. Например: офисная бумага, батарейки. 
Будьте ВНИМАТЕЛЬНЫ, не вводите себя в заблуждение.';

?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>
<div class="row">
  <div class="form-group">
    <div class="form-group col-md-6 col-lg-6">
      <?php
      echo $form->field($model, 'category_id', [
        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $cat_hint . '"></sup>{input}{hint}'])
        ->dropDownList($model->toolCategoryList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
          'options' => [
            'value' => 'none',
            'disabled' => 'true',
            'selected' => 'true'
          ]]])->hint('Выберите категорию', ['class' => ' w3-label-under']);
      ?>
      <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
    </div>
    <div class="form-group col-md-6 col-lg-6">
      <?= $form->field($model, 'eq_title', [
        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $title_hint . '"></sup>{input}{hint}'])
        ->textInput()->hint('Например: Коммутатор с автоопределителем', ['class' => ' w3-label-under']); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="form-group col-md-6 col-lg-6">
      <?= $form->field($model, 'eq_manufact')->textInput(['id' => 'manufact'])
        ->hint('Например: HP, ACER', ['class' => ' w3-label-under']); ?>
    </div>
    <div class="form-group col-md-6 col-lg-6">
      <?= $form->field($model, 'eq_model')->textInput(['id' => 'models'])
        ->hint('Например: LJ 1022', ['class' => ' w3-label-under']); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="form-group col-md-6 col-lg-6">
      <?= $form->field($model, 'eq_serial', [
        'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $serial_hint . '"></sup>{input}{hint}'
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
  <div class="form-group">
    <div class="form-group col-md-8">
      <?php
      echo $form->field($model, 'place_id', [
        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $place_hint . '"></sup>{input}{hint}'
      ])->dropDownList($model->toolPlacesList, ['data-name' => 'vks_type', 'prompt' => ['text' => 'Выберите',
        'options' => [
          'value' => 'none',
          'disabled' => 'true',
          'selected' => 'true'
        ]]])->hint('Выберите место нахождения оборудования', ['class' => ' w3-label-under']);
      ?>
      <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
    </div>
    <div class="form-group col-md-4">
      <?= $form->field($model, 'quantity', [
        'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $quantity_hint . '"></sup>{input}{hint}'])
        ->textInput()->hint('Введите количество', ['class' => ' w3-label-under']); ?>
    </div>
  </div>

  <?php
  if (!empty($model->photos)) {
    foreach ($model->photos as $k => $photo) {
      $allImages[] = "<img src='" . $photo->getImageUrl() . "' class='file-preview-image' 
                          style='max-width:100%;max-height:100%'>";
      $previewImagesConfig[] = [
        'url' => Url::toRoute(ArrayHelper::merge(['/tehdoc/kernel/tools/remove-image'], [
          'id' => $photo->id,
          '_csrf' => Html::csrfMetaTags()
        ])),
        'key' => $photo->id
      ];
    }
  } else {
    $previewImagesConfig = false;
    $allImages = false;
  }
  ?>
  <div class="form-group">
    <div class="form-group col-md-12 col-lg-12">
      <?= $form->field($file, "imageFiles[]")->widget(FileInput::class, [
        'language' => 'ru',
        'options' => ['multiple' => true],
        'pluginOptions' => [
          'previewFileType' => 'any',
          'initialPreview' => $allImages,
          'initialPreviewConfig' => $previewImagesConfig,
          'overwriteInitial' => false,
          'showUpload' => false
        ],
      ]); ?>
    </div>
  </div>
  <div class="form-group">
    <div class="form-group col-md-12 col-lg-12">
      <?= $form->field($model, 'eq_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '2')) ?>
    </div>
  </div>

  <div class="form-group">
    <div class="form-group col-md-12 col-lg-12">

      <label style="font-size:18px"><input type="checkbox" name="stay" style="width:20px;height:20px">
        Остаться в форме</label>
    </div>
  </div>
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
  </div>
</div>
</div>

<?php ActiveForm::end(); ?>

<script>
  $(document).ready(function () {
    s$('[data-toggle="tooltip"]').tooltip();
  })
</script>