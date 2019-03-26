<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

$title_hint = 'Укажите точное наименование документа.';
$date_hint = 'Дата документа.';

?>
<style>
  .date {
    color: #8f8f8f;
    font-size: 12px;
  }
  .news-item {
    font-family: "PTF75F-webfont";
    font-size: 18px;
    margin: 20px 0px;
  }
  .news-item > p > span, .news-info__name, .news-info__name * {
    background-image: url("/lib/border-bot.jpg");
    background-position: 0 95%;
    background-repeat: repeat-x;
    background-size: 1px 1px;
    display: inline;
  }
  .news-item > a:hover .news-info__name {
    background-image: none;
    color: #9d4d71;
  }
  .info-file .format-file {
    font-family: "PTF75F-webfont";
    font-size: 14px;
    margin: 5px 0;
    padding: 1px 13px 1px 4px;
    position: relative;
  }
  .news-info > a > div:hover .format-file, .news-info p:hover .format-file {
    background: #676767;
    color: #ffffff !important;
  }
  .doc-format {
    color: #0b58a2
  }
  .doc-format:hover {
    background-color: #468fc7;
    color: #fff;
  }
  .news-info > a > div:hover .doc-format, .news-info p:hover .doc-format {
    background: #468fc7;
  }
  .news-info > a > div:hover .format-file, .news-info p:hover .format-file {
    background: #676767;
    color: #ffffff !important;
  }
  .down {
    color: #fff;
    font-size: 10px;
  }
</style>


<div id="complex-docs">
  <?php if ($years): ?>
    <div class="">
      <div class="calendar">
        <ul class="list-inline" style="border-top: 1px solid #cbcbcb;">
          <?php foreach ($years as $year): ?>
            <li><a href="?year=<?= $year?>"><?= $year?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>

  <?php foreach ($docModels as $docModel): ?>
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
        <div>
          <span class="date"><?= $docModel->uploadDate . ' (' . $docModel->docDate . ')' ?> </span>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
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


    $('a.twitter').confirm({
      icon: 'fa fa-cog fa-spin',
      title: 'Подождите!',
      columnClass: 'col-md-6 col-md-offset-3',
      content: function () {
        var self = this;
        return $.ajax({
          url: 'new-form',
          method: 'get'
        }).done(function (response) {
          self.setContent(response);
        }).fail(function () {
          self.setContent('Что-то пошло не так.');
        });
      },
      buttons: {
        formSubmit: {
          text: 'Submit',
          btnClass: 'btn-blue',
          action: function () {
            $.ajax({
              url: 'werwer',
              method: 'post',
              data: {
                name:
              }
            }).done(function (response) {
              self.setContent(response);
            }).fail(function () {
              self.setContent('Что-то пошло не так.');
            });
            // var name = this.$content.find('.name').val();
            // if (!name) {
            //   $.alert('provide a valid name');
            //   return false;
            // }
            // $.alert('Your name is ' + name);
          }
        },
        cancel: function () {
          //close
        },
      },
      onContentReady: function () {
        // bind to events
        var jc = this;
        this.$content.find('form').on('submit', function (e) {
          // if the user submits the form by pressing enter in the field.
          e.preventDefault();
          jc.$$formSubmit.trigger('click'); // reference the button and click it
        });
      }
    });

    // jc = $.confirm({
    //   icon: 'fa fa-cog fa-spin',
    //   title: 'Подождите!',
    //   content: 'Ваш запрос выполняется!',
    //   buttons: false
    // });

  });
</script>