<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

?>

<div class="complex-doc+" style="margin-top: 15px">
  <div class="row">
    <div class="col-lg-9 col-md-6">
      <h3 style="margin-top: 0px">
        <?= Html::encode('Документы') ?>
        <a href="index">
          <i class="fa fa-refresh reboot" aria-hidden="true" style="color: #db4865;font-size: 20px"></i>
        </a>
      </h3>
    </div>
    <div class="col-lg-3 col-md-6 text-right">
      <p>
        <a href="" class="btn btn-sm btn-danger" id="delete-doc" disabled="true">Удалить</a>
        <a href="" class="btn btn-sm btn-info" id="add-doc">Добавить</a>
      </p>
    </div>
  </div>


  <div id="complex-docs">
    <?php if ($years): ?>
      <div class="calendar">
        <ul class="list-inline" style="border-top: 1px solid #cbcbcb;">
          <?php foreach ($years as $year): ?>
            <li>
              <a href=""><?= $year ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php foreach ($docModels as $docModel): ?>
      <div style="margin-left: 20px" id="">
        <div>
          <input class="doc-select" type="checkbox" style="float: left; margin: 7px 0px 0px -20px"
                 data-docid="<?= $docModel->id ?>">
        </div>
        <div class="news-item">
          <a href="<?= $docModel->docUrl ?>" style="text-align: justify">
            <div>
              <div class="news-info__name">
                <?= $docModel->doc_title ?>
              </div>
              <span class="info-file">
          <span class="format-file doc-format">
            <?= $docModel->doc_extention ?>
            <i class="fa fa-download down" aria-hidden="true"></i>
          </span>
          <span class="weight-file"></span>
        </span>
            </div>
          </a>
          <div>
            <span class="date"><?= $docModel->uploadDate . ' (' . $docModel->docDate . ')' ?> </span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<script>

  var jc;

  $(document).ready(function () {

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

    $('.doc-select').change(function (e) {
      if ($('input:checkbox:checked').length) {
        $('#delete-doc').attr('disabled', false);
      } else {
        $('#delete-doc').attr('disabled', true);
      }
    });

    $('#add-doc').click(function (e) {
      e.preventDefault();
      var node = $("#fancyree_w0").fancytree("getActiveNode");
      var toolId = node.data.id;
      var url = '/equipment/infoPanel/docs/create-ajax?id=' + toolId;
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
        title: 'Добавить документ',
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
                $("#w0").submit();
              }
            }
          },
          cancel: {
            text: 'НАЗАД'
          }
        }
      });
    });

    $('#delete-doc').click(function (e) {
      e.preventDefault();
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
    var csrf = $('meta[name=csrf-token]').attr("content");
    var uri = window.location.href;
    var selected = [];
    $('.doc-select:checked').each(function () {
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
      url: 'delete-docs',
      method: 'post',
      data: {
        docsArray: selected,
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
                window.location.href = uri;
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