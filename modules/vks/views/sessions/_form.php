<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\vks\assets\VksFormAsset;
use app\modules\tehdoc\modules\equipment\asset\EquipmentAsset;

?>

<style>
  .fa {
    font-size: 15px;
    color: #FF0000;
  }
  .nonreq {
    color: #1e6887;
  }
  .select-selected {
    padding-left: 40px;
  }
  .form-group {
    margin-bottom: 5px;
  }
  .control-label {
    font-size: 14px;
  }
</style>

<?php

VksFormAsset::register($this);
EquipmentAsset::register($this);

$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС. Сеанс ВКС из п.403 => ЗВС-ОГВ, ГФИ => КВС-ГФИ, Приемная Президента => КВС Приемной';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';
$vks_subscrof_hint = 'Ведомство определится автоматически после выбора фамилии абонента';
$vks_subscr_hint = 'Вводите фамилию абонента, при совпадении предложенного варианты выберите его. Ведомство определится автоматически';
$vks_order_hint = 'Обязательное поле! Укажите ';
$vks_recmsg_subscr_hint = 'Обязательное поле! Укажите ФИО сотрудника, принявшего сообщение о предстоящем сеансе ВКС';
$vks_recmsg_date_hint = 'Обязательное поле! Укажите дату получения сообщения о предстоящем сеансе ВКС';
$vks_employee_send_hint = 'Обязательное поле! Укажите ФИО сотрудника, передавшего сообщение о предстоящем сеансе ВКС';
$vks_employee_hint = 'Обязательное поле! Укажите ';
?>

<div class="row">
  <div class="col-lg-7 col-md-8" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>
    <div class="row">
      <div class="form-group col-md-12 col-lg-9" style="padding: 0px">
        <div class="form-group col-md-6 col-lg-6">
          <?= $form->field($model, 'vks_date', [
            'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_date_hint . '"></sup>{input}{hint}'
          ])->textInput([
            'class' => 'vks-date form-control fact-date'
          ])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-lg-9" style="padding: 0px">
        <div class="form-group col-md-6 col-lg-6">
          <?= $form->field($model, 'vks_teh_time_start')->textInput(['class' => 'time-mask form-control'])
            ->hint('', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-group col-md-12 col-lg-9" style="padding: 0px">
        <div class="form-group col-md-6 col-lg-6">
          <?= $form->field($model, 'vks_work_time_start')->textInput(['class' => 'time-mask form-control'])
            ->hint(' ', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
    </div>

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin-bottom: 10px;position: relative">
      <span class="text-muted " style="position: absolute;top:5px;right:10px;font-size: 10px">Студия </span>
      <div class="form-group col-md-5 col-lg-5">
        <?php
        echo $form->field($model, 'vks_type', [
          'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_type_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksTypesList, ['data-name' => 'vks_type',
          'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
      </div>

      <div class="form-group col-md-7 col-lg-7">
        <?= $form->field($model, 'vks_place', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_place_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksPlacesList, ['data-name' => 'vks_place',
          'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_place_text]" id="vks_place_text" style="display: none">
      </div>
    </div>

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin-bottom: 10px;position: relative">
      <span class="text-muted" style="position: absolute;top:5px;right:10px;font-size: 10px">Старший абонент</span>
      <div class="form-group col-md-5 col-lg-5">
        <?= $form->field($model, 'vks_subscriber_name', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscr_hint . '"></sup>{input}'
        ])->textInput(['id' => 'subscriber-name'])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="form-group col-md-7 col-lg-7">
        <?= $form->field($model, 'vks_subscriber_office', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscrof_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksMskSubscribesList, ['id' => 'subscriber-office', 'data-name' => 'vks_subscriber_office',
          'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_subscriber_office_text]" id="vks_subscriber_office_text"
               style="display: none">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_order', [
          'template' => '{label} <sup class="h-title fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_order_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksOrdersList, ['data-name' => 'vks_order',
          'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('', ['class' => ' w3-label-under']);
        ?>
        <input name="VksSessions[vks_order_text]" id="vks_order_text" style="display: none">
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '3')) ?>
      </div>
    </div>
  </div>

  <div class="col-lg-5 col-md-4"
       style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin-bottom: 10px;position: relative">
    <span class="text-muted" style="position: absolute;top:5px;right:10px;font-size: 15px">Служебное</span>
    <div class="form-group col-md-12 col-lg-12">
      <?php
      echo $form->field($model, 'vks_employee_receive_msg')->textInput(['readonly' => true,
        'value' => $model->isNewRecord ? Yii::$app->user->identity->username : null])
        ->hint('', ['class' => ' w3-label-under']);
      ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
      <?= $form->field($model, 'vks_receive_msg_datetime', [
        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_recmsg_date_hint . '"></sup>{input}{hint}'
      ])->textInput([
        'class' => 'vks_receive-date form-control'
      ])->hint('', ['class' => ' w3-label-under']); ?>
    </div>

    <div class="form-group col-md-12 col-lg-12">
      <?= $form->field($model, 'vks_employee_send_msg', [
        'template' => '{label} <sup class="h-title fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_send_hint . '"></sup>{input}{hint}'
      ])->dropDownList($model->vksEmployeesList, ['data-name' => 'vks_employee_send_msg',
        'prompt' => ['text' => 'Выберите',
          'options' => [
            'value' => 'none',
            'disabled' => 'true',
            'selected' => 'true'
          ]]])->hint('', ['class' => ' w3-label-under']);
      ?>
      <input name="VksSessions[vks_employee_send_msg_text]" id="vks_employee_send_msg_text" style="display: none">
    </div>
  </div>

</div>
<div class="row">
  <div class="col-md-12 col-lg-12">
    <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
  </div>
</div>


<?php ActiveForm::end(); ?>

<script>
  $(document).ready(function () {
    $(function () {
      $.mask.definitions['H'] = '[012]';
      $.mask.definitions['M'] = '[012345]';
      $('.time-mask').mask('H9:M9', {
          placeholder: "_",
          completed: function () {
            var val = $(this).val().split(':');
            if (val[0] * 1 > 23) val[0] = '23';
            if (val[1] * 1 > 59) val[1] = '59';
            $(this).val(val.join(':'));
            $('.time-mask').focus();
          }
        }
      );
    })
  });

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#w1-tree-input-menu').on('change', function (e) {
      var text = $('#w1-tree-input').text();
      $('#equipment-eq_title').val(text);
    });
  });

  $(document).ready(function () {
    $('.vks-date').datepicker({
      format: 'd MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "days",
      minViewMode: "days",
      clearBtn: true,
      todayHighlight: true,
      daysOfWeekHighlighted: [0, 6]
    })
  });

  $(document).ready(function () {
    $('.vks_receive-date').datepicker({
      format: 'd MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "days",
      minViewMode: "days",
      clearBtn: true,
      todayHighlight: true,
      daysOfWeekHighlighted: [0, 6]
    })
  });

  $(document).ready(function () {
    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('D MM YYYY'));
    }
  });

  $(document).ready(function () {
    $('.vks_receive-date').datepicker("update", new Date());
  });

  //преобразование дат перед отправкой
  $(document).ready(function () {
    $('#w0').submit(function () {
      var d = $('.vks-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
      $('.vks-date').val(d);
      var d = $('.vks_receive-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
      $('.vks_receive-date').val(d);
    });
  });

  $(document).ready(function () {
    $.ajax({
      type: 'get',
      url: '/vks/sessions/subscribers-msk',
      autoFocus: true,
      success: function (data) {
        var mskNames = $.parseJSON(data);
        $(function () {
          $("#subscriber-name").autocomplete({
            source: mskNames,
            focus: function (event, ui) {
              // prevent autocomplete from updating the textbox
              event.preventDefault();
              // manually update the textbox
              $(this).val(ui.item.label);
            },
            select: function (event, ui) {
              // prevent autocomplete from updating the textbox
              event.preventDefault();
              // manually update the textbox and hidden field
              $(this).val(ui.item.label);
              $('#subscriber-office').val(ui.item.value);
              var text = $('#subscriber-office').find("option:selected").text();
              $('#vks_subscriber_office_text').val(text);              // т.к. событие всавки, а не изменения
            }
          });
        });
      },
      error: function (data) {
        console.log('error occure');
      }
    });
  });

  $(document).ready(function () {
    $('select').each(function () {
      var val = $(this).find("option:selected").text();
      if (val != 'Выберите') {
        var text = '_text';
        var id = '#' + $(this).data("name") + text;
        $(id).val(val);
      }
    });
    $('select').on('change', function (e) {
      var val = $(this).find("option:selected").text();
      var text = '_text';
      var id = '#' + $(this).data("name") + text;
      $(id).val(val);
    });
  });

</script>

