<?php

use yii\helpers\Html;
use app\modules\equipment\asset\MasonryAsset;

MasonryAsset::register($this);

?>

<div class="complex-fotos">

  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3>
        <?= Html::encode('Изображения') ?>
      </h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <a href="" class="btn btn-sm btn-danger" id="delete-foto" disabled="true">Удалить</a>
        <a href="" class="btn btn-sm btn-success" id="add-foto">Добавить</a>
      </p>
    </div>
  </div>

  <div>
    <div class="dw foto-panel">
      <?php foreach ($photoModels as $photoModel): ?>
        <div class="dw-panel">
          <div class="thumbnail dw-panel__content">
            <div>
              <input class="foto-select" type="checkbox" data-docid="<?= $photoModel->id ?>">
            </div>
            <a href="<?= $photoModel->imageUrl ?>" target="_blank">
              <img src="<?= $photoModel->imageUrl ?>">
            </a>
            <span class="date">Добавлено: <?= $photoModel->uploadDate ?> </span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    $('.foto-select').change(function (e) {
      if ($('input:checkbox:checked').length) {
        $('#delete-foto').attr('disabled', false);
      } else {
        $('#delete-foto').attr('disabled', true);
      }
    });

    var jc;

    $('.fact-date').datepicker({
      format: 'dd MM yyyy г.',
      autoclose: true,
      language: "ru",
      clearBtn: true
    });

    if ($('.fact-date').val()) {
      var date = new Date($('.fact-date').val());
      moment.locale('ru');
      $('.fact-date').datepicker('update', moment(date).format('MMMM YYYY'))
    }

    $('.foto-select').change(function (e) {
      if ($('input:checkbox:checked').length) {
        $('#delete-foto').attr('disabled', false);
      } else {
        $('#delete-foto').attr('disabled', true);
      }
    });

    $('#add-foto').click(function (e) {
      e.preventDefault();
      var node = $("#fancyree_w0").fancytree("getActiveNode");
      var toolId = node.data.id;
      var url = '/equipment/infoPanel/foto/create-ajax?id=' + toolId;
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
        type: 'blue',
        columnClass: 'large',
        title: 'Добавить фото',
        buttons: {
          ok: {
            btnClass: 'btn-blue',
            text: 'Добавить',
            action: function () {
              var $form = $("#w0"),
                data = $form.data("yiiActiveForm");
              $.each(data.attributes, function() {
                this.status = 3;
              });
              $form.yiiActiveForm("validate");
              if ($("#w0").find(".has-error").length) {
                return false;
              } else {
                var form = $('form')[0];
                var formData = new FormData(form);
                $.ajax({
                  type: 'POST',
                  url: url,
                  processData: false,
                  contentType: false,
                  data: formData,
                  success: function (response) {
                    var tText = '<span style="font-weight: 600">Отлично!</span><br>Фотографии добавлены';
                    initNoty(tText, 'success');
                    getCounters(toolId);
                    $('#tool-info-view').html(response.data.data);

                  },
                  error: function (response) {
                    var tText = '<span style="font-weight: 600">Что-то пошло не так!</span><br>Фотографии не добавлены';
                    initNoty(tText, 'warning');
                    console.log(response.data.data);
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

    $('#delete-foto').on('click', function (event) {
      event.preventDefault();
      if ($(this).attr('disabled')) {
        return;
      }
      jc = $.confirm({
        icon: 'fa fa-question',
        title: 'Вы уверены?',
        content: 'Вы действительно хотите удалить выделенное?',
        type: 'red',
        closeIcon: false,
        autoClose: 'cancel|9000',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
              jc.close();
              deleteProcess();
            }
          },
          cancel: {
            action: function () {
              return;
            }
          }
        }
      });
    });
  });

  function deleteProcess() {
    var node = $("#fancyree_w0").fancytree("getActiveNode");
    var toolId = node.data.id;
    var csrf = $('meta[name=csrf-token]').attr("content");
    var selected = [];
    $('.foto-select:checked').each(function () {
      selected.push($(this).data('docid'));
    });
    jc = $.confirm({
      icon: 'fa fa-cog fa-spin',
      title: 'Подождите!',
      content: 'Ваш запрос выполняется!',
      buttons: false,
      closeIcon: false,
      confirmButtonClass: 'hide'
    });
    $.ajax({
      url: '/equipment/infoPanel/foto/delete-photos',
      method: 'post',
      data: {
        toolId: toolId,
        photosArray: selected,
        _csrf: csrf
      }
    }).done(function (response) {
      if (response != false) {
        jc.close();
        var count = $('li.active span.Counter').text();
        $('li.active span.Counter').text(count - response);
        jc = $.confirm({
          icon: 'fa fa-thumbs-up',
          title: 'Успех!',
          content: 'Ваш запрос выполнен.',
          type: 'green',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-success',
              action: function () {
                getCounters(toolId);
                $('#tool-info-view').html(response.data.data);
              }
            }
          }
        });
      } else {
        jc.close();
        jc = $.confirm({
          icon: 'fa fa-exclamation-triangle',
          title: 'Неудача!',
          content: 'Запрос не выполнен. Что-то пошло не так.',
          type: 'red',
          buttons: false,
          closeIcon: false,
          autoClose: 'ok|8000',
          confirmButtonClass: 'hide',
          buttons: {
            ok: {
              btnClass: 'btn-danger',
              action: function () {
              }
            }
          }
        });
      }
    }).fail(function () {
      jc.close();
      jc = $.confirm({
        icon: 'fa fa-exclamation-triangle',
        title: 'Неудача!',
        content: 'Запрос не выполнен. Что-то пошло не так.',
        type: 'red',
        buttons: false,
        closeIcon: false,
        autoClose: 'ok|4000',
        confirmButtonClass: 'hide',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
            }
          }
        }
      });
    });
  }

</script>
