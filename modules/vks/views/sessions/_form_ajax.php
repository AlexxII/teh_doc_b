<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\vks\assets\VksFormAsset;
use app\assets\BootstrapDatepickerAsset;

VksFormAsset::register($this);
BootstrapDatepickerAsset::register($this);

$vks_date_hint = 'Обязательное поле! Укажите дату проведения сеанса ВКС';
$vks_type_hint = 'Обязательное поле! Укажите ТИП сеанса ВКС. Сеанс ВКС из п.403 => ЗВС-ОГВ, ГФИ => КВС-ГФИ, Приемная Президента => КВС Приемной';
$vks_type_add_hint = 'Добавить Тип сеанса ВКС';
$vks_place_hint = 'Укажите место проведения сеанса видеосвязи';
$vks_subscrof_hint = 'Ведомство определится автоматически после выбора фамилии абонента';
$vks_subscr_hint = 'Вводите фамилию абонента, при совпадении предложенного варианты выберите его. Ведомство определится автоматически';
$vks_order_hint = 'Обязательное поле! Укажите распоряжение на организацию видеосвязи';
$vks_recmsg_date_hint = 'Обязательное поле! Укажите дату получения сообщения о предстоящем сеансе ВКС';
$vks_employee_send_hint = 'Обязательное поле! Укажите источник сообщения о предстоящем сеансе ВКС';
$vks_employee_hint = 'Обязательное поле! Укажите ';
$vks_add_combined = "Добавить совмещенный сеанс";
?>

<div class="form-up-session">
  <div class="col-lg-12 col-md-12" style="border-radius:2px;padding-top:10px">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'class' => '']]); ?>
    <div>
      <div class="row col-md-6 col-lg-6">
        <div class="form-group">
          <?= $form->field($model, 'vks_date', [
            'template' => '{label} <sup class="fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" data-container="body" title="' . $vks_date_hint . '"></sup>{input}{hint}'
          ])->textInput([
            'class' => 'vks-date form-control fact-date',
            'readonly' => true
          ])->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group">
          <?= $form->field($model, 'vks_teh_time_start')->textInput(['class' => 'time-mask form-control'])
            ->hint('', ['class' => ' w3-label-under']); ?>
        </div>
        <div class="form-group">
          <?= $form->field($model, 'vks_work_time_start')->textInput(['class' => 'time-mask form-control'])
            ->hint(' ', ['class' => ' w3-label-under']); ?>
        </div>
      </div>
      <div class="row col-md-6 col-lg-6" style="margin: 0px 0px 10px 10px">
        <div class="form-group">
          <div class="alert alert-info">
            <?php
            $template = [
              'labelOptions' => ['font-size' => '28px'],
              'template' => '{label}{input}   ',
            ];
            echo $form->field($model, 'important', $template)->checkbox(); ?>
            <span style="font-size: 12px">Сеансы ВКС, которые имеют особое значение</span>
          </div>
        </div>
      </div>
    </div>

    <!-- ****************************************************************** -->

    <div class="dynamic-content">
      <div class="col-md-12 col-lg-12"
           style="border: dashed 1px #0c0c0c; border-radius: 4px; padding: 20px 0px 10px 0px; margin-bottom: 10px; position: relative">
      <span class="text-muted dynamic-control" style="position: absolute;top:5px;right:10px;font-size: 10px">
        <i class="fa fa-plus-square-o add-combined-session"
           aria-hidden="true"
           style="cursor: pointer; font-size: 25px; color: #4eb305"
           data-toggle="tooltip"
           data-placement="top"
           data-container="body"
           title="Добавить совмещенный сеанс">
        </i></span>
        <span class="text-muted dynamic-title" style="position: absolute;top:5px;left:10px;font-size: 10px"></span>

        <div class="dynamic-wrap">
          <div class="form-group col-md-5 col-lg-5" style="margin-top: 10px">
            <?php
            echo $form->field($model, 'vks_type', [
              'template' => '{label} 
              <sup class="fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" data-container="body" title="' . $vks_type_hint . '"></sup>
                {input}{hint}'
            ])->dropDownList($model->vksTypesList, ['data-name' => 'vks_type', 'class' => 'vks-type form-control',
              'prompt' => ['text' => 'Выберите',
                'options' => [
                  'value' => 'none',
                  'disabled' => 'true',
                  'selected' => 'true'
                ]]])->hint('', ['class' => ' w3-label-under']);
            ?>
            <input name="VksSessions[vks_type_text]" id="vks_type_text" style="display: none">
          </div>

          <div class="form-group col-md-7 col-lg-7" style="margin-top: 10px">
            <?= $form->field($model, 'vks_place', [
              'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" data-container="body" title="' . $vks_place_hint . '"></sup>{input}{hint}'
            ])->dropDownList($model->vksPlacesList, ['data-name' => 'vks_place', 'class' => 'vks-place form-control',
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
      </div>
    </div>

    <!-- ****************************************************************** -->

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin-bottom: 10px;position: relative">
      <span class="text-muted" style="position: absolute;top:5px;right:10px;font-size: 10px">
      Старший абонент</span>
      <div class="form-group col-md-5 col-lg-5">
        <?= $form->field($model, 'vks_subscriber_name', [
          'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_subscr_hint . '"></sup>{input}'
        ])->textInput(['id' => 'subscriber-name'])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
      <div class="form-group col-md-7 col-lg-7">
        <?= $form->field($model, 'vks_subscriber_office', [
          'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
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

    <div class="row" style="margin-bottom: 10px">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_order', [
          'template' => '{label} <sup class="fa fa-info-circle nonreq" aria-hidden="true"
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

    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c;border-radius: 4px;padding: 20px 0px 10px 0px;margin-bottom: 10px;position: relative">
      <span class="text-muted" style="position: absolute;top:5px;right:10px;font-size: 10px">Служебное</span>
      <div class="form-group col-md-5 col-lg-5">
        <?= $form->field($model, 'vks_employee_send_msg', [
          'template' => '{label} <sup class="fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_employee_send_hint . '"></sup>{input}{hint}'
        ])->dropDownList($model->vksEmployeesList, ['data-name' => 'vks_employee_send_msg',
          'prompt' => ['text' => 'Выберите',
            'options' => [
              'value' => 'none',
              'disabled' => 'true',
              'selected' => 'true'
            ]]])->hint('', ['class' => ' w3-label-under']);
        ?>
      </div>
      <div class="form-group col-md-7 col-lg-7">
        <?= $form->field($model, 'vks_receive_msg_datetime', [
          'template' => '{label} <sup class="fa fa-info-circle" aria-hidden="true"
                data-toggle="tooltip" data-placement="top" title="' . $vks_recmsg_date_hint . '"></sup>{input}{hint}'
        ])->textInput([
          'class' => 'vks_receive-date form-control',
          'readonly' => true
        ])->hint('', ['class' => ' w3-label-under']); ?>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12 col-lg-12">
        <?= $form->field($model, 'vks_comments')->textArea(array('style' => 'resize:vertical', 'rows' => '2')) ?>
      </div>
    </div>
  </div>


</div>

<?php ActiveForm::end(); ?>

<script>

  var mines = '' +
    '      <span class="text-muted " style="position: absolute;top:5px;right:10px;font-size: 10px">\n' +
    '        <i class="fa fa-minus-square-o del-combined-session"\n' +
    '           aria-hidden="true"\n' +
    '           style="cursor: pointer; font-size: 25px; color: #c72e26"\n' +
    '           data-toggle="tooltip"\n' +
    '           data-placement="top"\n' +
    '           title="Удалить совмещенный сеанс">\n' +
    '        </i></span>\n';

  var newDiv = '' +
    '        <div class="form-group col-md-5 col-lg-5 dynamic" style="margin-top: 10px">' +
    '          <label class="control-label">Тип ВКС:</label>' +
    '        </div>' +
    '        <div class="form-group col-md-7 col-lg-7" style="margin-top: 10px">' +
    '          <label class="place-label">Место проведения ВКС:</label>' +
    '        </div>';


  var mainCounter = 1;
  var parentSpanTitle;
  var lastInsert;
  var maxInput = 4;

  $(document).ready(function () {

    $('.adddd').on('click', function (e) {
      e.preventDefault();
      var uri = 'vks-subscribes';
      var url = '/vks/control/' + uri + '/index';
      var size = 'xlarge';
      var title = 'Тип ВКС';
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get'
          }).done(function (response) {
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так!</div>');
          });
        },
        contentLoaded: function (data, status, xhr) {
          this.setContentAppend('<div>' + data + '</div>');
        },
        columnClass: size,
        title: title,
        buttons: {
          cancel: {
            text: 'НАЗАД',
            action: function () {
              $.ajax({
                type: 'get',
                url: '/vks/sessions/subscribers-msk',
                autoFocus: true,
                success: function (data) {
                  var mskNames = $.parseJSON(data);
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
                },
                error: function (data) {
                  console.log('error occure');
                }
              });
            }

          }
        }
      });
    });


    $('.dynamic-content').on('click', '.del-combined-session', function () {
      var div = $(this).closest("div");
      mainCounter--;
      if (mainCounter == 1) {
        $(parentSpanTitle).text('');
      }
      div.remove();
    });

    $('.add-combined-session').on('click', function () {
      if (mainCounter >= maxInput) {
        return;
      }
      var div = $(this).closest("div");
      parentSpanTitle = $(div).find('.dynamic-title').text('Студия');

      var insert = $(div).clone();
      insert.find('.dynamic-wrap').html(newDiv);
      var spanControl = $(insert).find('.dynamic-title').text('Студия');
      var spanTitle = $(insert).find('.dynamic-control').replaceWith(mines);
      // переименовать контейнер
      $(insert).find('.dynamic').addClass("dynamic-container-" + mainCounter);
      insert.find('.control-label').attr('for', 'new-type-' + mainCounter);
      // клонировать selectы, переименовать их id, name  и всавить в клонированный div после label
      div.find('.vks-type').clone().attr('name', 'test-type[' + mainCounter + ']').attr('id', 'new-type-' + mainCounter).insertAfter(insert.find('.control-label'));
      div.find('.vks-place').clone().attr('name', 'test-place[' + mainCounter + ']').insertAfter(insert.find('.place-label'));

      if (mainCounter == 1) {
        insert.insertAfter(div);
      } else {
        insert.insertAfter(lastInsert);
      }
      lastInsert = insert;
      $('#w0').yiiActiveForm('add', {
        id: 'new-type-' + mainCounter,
        name: 'test-type[' + mainCounter + ']',
        container: '.dynamic-container-' + mainCounter,
        input: '#new-type-' + mainCounter,
        validate: function (attribute, value, messages, deferred, $form) {
          yii.validation.required(value, messages, {message: "Validation Message Here"});
        }
      });
      mainCounter++;
    });

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

    $('[data-toggle="tooltip"]').tooltip();

    /*
        $('#w1-tree-input-menu').on('change', function (e) {
          var text = $('#w1-tree-input').text();
          $('#equipment-eq_title').val(text);
        });
    */



    $('.vks-date').datepicker({
      format: 'd MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "days",
      minViewMode: "days",
      clearBtn: true,
      todayHighlight: true,
      daysOfWeekHighlighted: [0, 6]
    });

    $('.vks_receive-date').datepicker({
      format: 'd MM yyyy г.',
      autoclose: true,
      language: "ru",
      startView: "days",
      minViewMode: "days",
      clearBtn: true,
      todayHighlight: true,
      daysOfWeekHighlighted: [0, 6]
    });

    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('D MM YYYY'));
    }

    $('.vks_receive-date').datepicker("update", new Date());


    $.ajax({
      type: 'get',
      url: '/vks/sessions/subscribers-msk',
      autoFocus: true,
      success: function (data) {
        var mskNames = $.parseJSON(data);
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
      },
      error: function (data) {
        console.log('error occure');
      }
    });

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


    var select = '<select>' +
      '<option>10:00</option>' +
      '<option>11:00</option>' +
      '<option>12:00</option>' +
      '<option>13:00</option>' +
      '</select>';

    $('#vkssessions-vks_teh_time_start').on('click', function () {
      $(this).html(select);
    })


  });

</script>

