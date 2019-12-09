<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\vks\assets\VksFormAsset;
use app\assets\BootstrapDatepickerAsset;

BootstrapDatepickerAsset::register($this);

$poll_title_hint = "Укажите наименование опроса без кода.";
$poll_sample_hint = "Укажите выборку цифрами.";
$poll_code_hint = "Укажите код данного опроса";
$poll_election_hint = "Является ли данный опрос - выборный";

$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС (Напрмер: ЗВС-ОГВ, КВС и т.д.)';
$vks_place_hint = 'Обязательное поле! Укажите место проведения сеанса видеосвязи';
$vks_subscr_hint = 'Вводите фамилию абонента, при совпадении предложенного варианты выберите его. Ведомство определится автоматически';
$vks_subscrof_hint = 'Обязательное поле! Укажите  должность старшего абонента';
$vks_order_hint = 'Обязательное поле! Укажите распоряжение на проведение сеанса ВКС';
$vks_employee_hint = 'Обязательное поле! Укажите сотрудника СпецСвязи, обеспечивающего сеанс ВКС';
$vks_subscr_reg_hint = 'Вводите фамилию абонента, при совпадении предложенного варианты выберите его. Ведомство определится автоматически';
$vks_subscr_regof_hint = 'Обязательное поле! Укажите должность абонента в регионе';
$vks_tools_hint = 'Обязательное поле! Укажите оборудование ВКС'

?>
<style>
  .form-group {
    margin-bottom: 5px;
  }
</style>


<div class="form-confirm-session">
  <div class="col-lg-12 col-md-12" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>

    <div class="row" style="padding-bottom: 10px">
      <div class="form-group col-md-12 col-lg-12">
        <div class="formField">
          <label for="fileToUpload">Загрузить XML файл</label><br/>
          <input type="file" name="oprosxml" id="xmlupload"/>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'title')->textInput([
          'class' => 'poll-title form-control'
        ])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
    </div>

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin: 10px 0px 10px 0px;position: relative">
      <span class="text-muted"
            style="position: absolute;top:5px;right:10px;font-size: 10px">Время проведения опроса</span>
      <div class="col-md-6 col-lg-6">
        <?= $form->field($model, 'start_date')->textInput([
          'class' => 'fact-date form-control',
          'readonly' => true
        ])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="col-md-6 col-lg-6">
        <?= $form->field($model, 'end_date')->textInput([
          'class' => 'fact-date form-control',
          'readonly' => true
        ])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
    </div>

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin: 10px 0px 10px 0px;position: relative">
      <span class="text-muted" style="position: absolute;top:5px;right:10px;font-size: 10px">Особенности</span>
      <div class="form-group col-md-5 col-lg-5">
        <?= $form->field($model, 'code', [
          'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $poll_code_hint . '"></sup>{input}{hint}'])
          ->textInput(['id' => 'poll-code'])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="form-group col-md-7 col-lg-7">
        <?= $form->field($model, 'sample', [
          'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $poll_sample_hint . '"></sup>{input}{hint}'])
          ->textInput(['id' => 'poll-sample'])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
    </div>

    <div class="row" style="padding-top: 10px">
      <div class="form-group col-md-12 col-lg-12">
        <?php
        $template = [
          'labelOptions' => ['font-size' => '28px'],
          'template' => '{label}{input} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $poll_election_hint . '"></sup>',
        ];
        echo $form->field($model, 'elections', $template)->checkbox(); ?>
      </div>
    </div>

    <div class="row" >
      <div class="form-group col-md-12 col-lg-12">
        <?= $form->field($model, 'poll_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '2')) ?>
      </div>
    </div>

  </div>
</div>

<?php ActiveForm::end(); ?>

<script>
  $(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();


    $('.fact-date').datepicker({
      format: 'd MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "days",
      minViewMode: "days",
      clearBtn: true,
      todayHighlight: true,
      daysOfWeekHighlighted: [0, 6]
    });

    $('#xmlupload').on('change', function (e) {
      e.preventDefault();
      var txt = '';
      var selectedFile = document.getElementById('xmlupload').files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        readXml = e.target.result;
        moment.locale('ru');
        var parser = new DOMParser();
        var doc = parser.parseFromString(readXml, "application/xml");
        var opros = doc.getElementsByTagName("opros")[0].attributes;
        $('#polls-title').val(opros.name.nodeValue);
        $('#poll-code').val(opros.cod.nodeValue);
        var startDate = opros.start_date.nodeValue;
        var endDate = opros.end_date.nodeValue;
        var pattern = /(\d{2})\.(\d{2})\.(\d{4})/;
        console.log(new Date(startDate.replace(pattern, '$3-$2-$1')));
        $('#polls-start_date').datepicker('update', new Date(startDate.replace(pattern, '$3-$2-$1')));
        $('#polls-end_date').datepicker('update', new Date(endDate.replace(pattern, '$3-$2-$1')));
      };
      reader.readAsText(selectedFile);
    })


  });


</script>

