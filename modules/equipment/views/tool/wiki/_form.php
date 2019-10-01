<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$placeholder = 'Название страницы';

?>

<div class="row" id="complex-wiki-form" style="text-align: left">
  <div class="col-lg-12 col-md-12">
    <div class="customer-form">
      <h3><?= Html::encode($title) ?></h3>
      <?php $form = ActiveForm::begin([
        "options" => [
          "enctype" => "multipart/form-data",
          "class" => "main-wiki-form",
          "id" => "wiki-create-form"
        ]
      ]); ?>
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <?= $form->field($model, "wiki_title")
            ->textInput(["placeholder" => $placeholder, "id" => "wiki-title"])
            ->label(false) ?>
        </div>
        <div class="col-md-12 col-lg-12" style="text-align: left">
          <?= $form->field($model, "wiki_text")
            ->textArea(array("style" => "resize:vertical", "rows" => "10", "id" => "wiki-text"))
            ->label(false) ?>
        </div>
      </div>
      <div class="form-group" style="text-align: right">
        <a id="delete-wiki-page" data-wiki-id="<?= $model->id ?>" class="btn btn-sm btn-danger"
           style="<?php echo $model->isNewRecord ? 'display:none' : 'display:' ?>" >Удалить</a>
        <a id="cancel-wiki-form" data-wiki-id="<?= $model->id ?>" class="btn btn-sm btn-primary">Отмена</a>
        <?= Html::submitButton($model->isNewRecord ? "Создать" : "Обновить", [
          "class" => "btn btn-sm btn-success",
          "data-uri" => $model->isNewRecord ? "create" : "update?page=" . $model->id ,
          "id" => 'wiki-submit-btn'
        ]) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>


<script>
  var simplemde;
  $(document).ready(function () {
    simplemde = new SimpleMDE({
      showIcons: ["code", "table"],
      status: false,
      spellChecker: false,
      toolbar: [
        "bold", "italic", "heading", "|",
        "code", "quote", "unordered-list", "ordered-list", "|",
        "link", "image", "table", "|",
        "preview", "fullscreen", "|",
        {
          name: "guide",
          action: function openlink() {
            // var win = window.open('https://google.com', '_blank');
            // win.focus();
          },
          className: "fa fa-question-circle",
          title: "Справка",
        }]
    });




  });

</script>