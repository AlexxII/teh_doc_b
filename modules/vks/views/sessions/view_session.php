<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

?>

<style>
  #w0 td {
    text-align: center;
  }
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
  table.detail-view th {
    width: 40%;
  }
</style>

<div class="">
  <div class="container-fluid col-lg-7 col-md-7">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        [
          'label' => 'Дата проведения ВКС:',
          'value' => date('d.m.Y', strtotime($model->vks_date)) . ' г.'
        ],
        [
          'label' => 'Время:',
          'value' => function ($data) {
            $duration = $data->vks_duration_teh ? ' (' . $data->vks_duration_teh . ' мин.)' : '';
            return $data->vks_teh_time_start . ' - ' . $data->vks_teh_time_end . $duration;
          },
        ],
        [
          'label' => 'Время:',
          'value' => function ($data) {
            $duration = $data->vks_duration_work ? ' (' . $data->vks_duration_work . ' мин.)' : '';
            return $data->vks_work_time_start . ' - ' . $data->vks_work_time_end . $duration;
          },
        ],
        [
          'label' => 'Тип сеанса ВКС:',
          'value' => $model->type
        ],
        [
          'label' => 'Студия проведения ВКС:',
          'value' => $model->place
        ],
        [
          'label' => 'Старший Абонент:',
          'value' => $model->subscriber
        ],
        [
          'label' => 'Абонент в регионе:',
          'value' => $model->subscriberReg
        ],
        [
          'label' => 'Сотрудник СпецСвязи:',
          'value' => $model->employee
        ],
        [
          'label' => 'Распоряжение:',
          'value' => $model->order
        ],
        [
          'label' => 'Принявший сообщение:',
          'value' => $model->vks_employee_receive_msg
        ],
        [
          'label' => 'Дата сообщения:',
          'value' => date('d.m.Y', strtotime($model->vks_receive_msg_datetime))
        ],
        [
          'label' => 'Источник сообщения:',
          'value' => $model->sendMsg
        ],
        'vks_comments',
        'vks_record_create',
        'vks_record_update'
      ]
    ]) ?>
  </div>

  <div class="vks-log col-lg-5 col-md-5">
    <?php
    foreach ($logs as $log) {

      if ($log->status == 'danger') {
        $info = 'alert-danger';
      } else {
        $info = 'alert-info';
      }
      echo '<div class="alert ' . $info . '" role="alert" style="margin-bottom: 10px">';
      echo '<div class="clock" style="font-size: 12px">';
      echo '<i class="fa fa-clock-o" aria-hidden="true"></i>';
      echo ' ';
      echo date('d.m.Y', strtotime($log->log_time)) . ' ' . date('H:i.s', strtotime($log->log_time));
      echo '</div>';
      echo " Пользователь: " . '<strong>' . $log->userName . '</strong>';
      echo '<br>';
      echo $log->log_text;
      echo '</div>';
    }
    ?>
  </div>

</div>
<br>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('#delete').click(function (event) {
      event.preventDefault();
      var url = "/vks/sessions/delete-single";
      var id = $(this).data('id');
      jc = $.confirm({
        icon: 'fa fa-question',
        title: 'Вы уверены?',
        content: 'Вы действительно хотите удалить запись?',
        type: 'red',
        closeIcon: false,
        autoClose: 'cancel|9000',
        buttons: {
          ok: {
            btnClass: 'btn-danger',
            action: function () {
              jc.close();
              remoteProcess(url, id);
            }
          },
          cancel: {
            action: function () {
              return;
            }
          }
        }
      })
    });

    function remoteProcess(url, id) {
      var csrf = $('meta[name=csrf-token]').attr("content");
      jc = $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Подождите!',
        content: 'Ваш запрос выполняется!',
        buttons: false,
        closeIcon: false,
        confirmButtonClass: 'hide'
      });
      $.ajax({
        url: url,
        method: 'post',
        data: {id: id, _csrf: csrf},
      }).done(function (response) {
        if (response != false) {
          jc.close();
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
                  location.href = '/vks/sessions/archive';
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

  });
</script>


