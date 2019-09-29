<?php

use yii\helpers\Html;

?>
<style>
  .app-settings {
    font-weight: 400 !important;
    margin: 12px 0px 0px 30px !important;
  }
  #main-wrap {
    margin-top: 0px !important;
  }
  #main-wrap h3 {
    margin-top: 10px;
  }
</style>


<div class="row">
  <?php foreach ($models as $model): ?>
    <div class="col-sm-6 col-md-4 col-lg-4 task-wrap">
      <div class="thumbnail">
        <div class="caption">
          <span><small><?= $model->toolParents(0) ?></small></span>
          <h4><?= $model->eq_title ?>
            <span class="counter" id="<?= $model->id ?>" title="Кол-во изображений" data-toggle="tooltip" data-placement="top">
                <?= $model->countImages ?>
              </span>
          </h4>
          <p><a href="" data-tool-id="<?= $model->id ?>" class="btn btn-sm btn-default update-task-tool" role="button">Обновить</a></p>
          <li class="list-group-item" style="margin-bottom: 15px">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">
                <input class="ch" id="consolidated-feature" type="checkbox" data-check='consolidated-check'
                       data-id="<?= $model->id ?>" <?php if ($model->settings->eq_task) echo 'checked' ?> > В задании на
                обновление
              </label>
              <span class="status-indicator"></span>
            </div>
          </li>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>


<script>

  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    var successCheck = '<i class="fa fa-check" id="consolidated-check" aria-hidden="true" style="color: #4eb305"></i>';
    var warningCheck = '<i class="fa fa-times" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';
    var waiting = '<i class="fa fa-cog fa-spin" aria-hidden="true"></i>';

    $('.update-task-tool').on('click', function (e) {
      e.preventDefault();
      var toolId = $(this).data('toolId');
      var taskDiv = $(this).closest('.task-wrap');
      var url = '/equipment/task/update-task-tool?id=' + toolId;
      c = $.confirm({
        content: function () {
          var self = this;
          return $.ajax({
            url: url,
            method: 'get'
          }).fail(function () {
            self.setContentAppend('<div>Что-то пошло не так</div>');
          });
        },
        contentLoaded: function (response, status, xhr) {
          this.setContentAppend('<div>' + response.data.data + '</div>');
        },
        type: 'blue',
        columnClass: 'large',
        title: 'Редактровать данные',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Обновить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function () {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
                return false;
              } else {
                //преобразование дат перед отправкой
                var d = $('.fact-date').data('datepicker').getFormattedDate('yyyy-mm-dd');
                $('.fact-date').val(d);
                $.ajax({
                  type: 'POST',
                  url: url,
                  dataType: 'json',
                  data: $form.serialize(),
                  success: function (response) {
                    var tText = '<span style="font-weight: 600">Успех!</span><br>Данные обновлены';
                    initNoty(tText, 'success');
                    $('#tool-info-view').html(response.data.data);
                    taskDiv.fadeOut();
                  },
                  error: function (response) {
                    console.log(response.data.data);
                    var tText = '<span style="font-weight: 600">Что-то пошло не так</span><br>Обновить не удалось';
                    initNoty(tText, 'error');
                  }
                });
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });

    });
  })

</script>