<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\tehdoc\asset;
use yii\widgets\DetailView;


$this->title = 'Просмотр';

$this->params['breadcrumbs'][] = ['label' => 'ВКС', 'url' => ['/vks']];
$this->params['breadcrumbs'][] = ['label' => 'Журнал', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="to-schedule-archive">

  <h1><?= Html::encode($this->title) ?></h1>

</div>

<style>
  td {
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

<div class="row">
  <div class="">
    <div class="container-fluid " style="margin-bottom: 20px">
      <?= Html::a('Изменить', ['update-up-session', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
      <?= Html::a('Удалить', ['delete-single', 'id' => $model->id], [
        'class' => 'btn btn-danger btn-sm',
        'data' => [
          'confirm' => 'Вы уверены, что хотите удалить объект?',
          'method' => 'post',
        ],
      ]) ?>
    </div>
  </div>

  <div class="container-fluid col-lg-6 col-md-6">
    <?= DetailView::widget([
      'model' => $model,
      'attributes' => [
        [
          'label' => 'Дата проведения ВКС:',
          'value' => date('d.m.Y', strtotime($model->vks_date)) . ' г.'
        ],
        'vks_teh_time_start',
        'vks_work_time_start',
        [
          'label' => 'Тип сеанса ВКС:',
          'value' => $model->type
        ],
        [
          'label' => 'Студия проведения ВКС:',
          'value' => $model->place
        ],
        [
          'label' => 'Абонент:',
          'value' => $model->subscriber
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
          'value' => date('d.m.Y', strtotime($model->vks_receive_msg_datetime)) . ' г.'
        ],
        [
          'label' => 'Передавший сообщение:',
          'value' => $model->sendMsg
        ],
        'vks_comments',
        'vks_record_create',
        'vks_record_update'
      ]
    ]) ?>
  </div>


  <div class="fotorama col-lg-6 col-md-6" data-allowfullscreen="native">
  </div>

</div>
<br>

<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>


