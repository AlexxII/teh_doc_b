<?php

use yii\helpers\Html;

$this->title = 'Техническая документация';
$about = 'На представленные данные опирается все приложение.
Корректность этих данных - залог успешной работы системы.';

$add_hint = 'Добавить оборудование';
$dell_hint = 'Удалить выделенное оборудование';
$classif_hint = 'Присвоить выделенному оборудованию пользовательский классификатор';
?>

<style>
  .h-title {
    font-size: 18px;
    color: #1e6887;
  }
  .placeholder {
    text-align: center;
  }
</style>


<div class="row">
  <div class="col-lg-3 col-md-4 col-sm-6 placeholder about" style="cursor: pointer" data-url="tehdoc/equipment/tools">
    <h2>Оборудование</h2>
    <i class="fa fa-microchip" aria-hidden="true" style="font-size: 120px"></i>
    <div class="text-muted" style="font-size: 20px">Перечень оборудования</div>
  </div>

  <div class="col-lg-3 col-md-4 col-sm-6 placeholder about" style="cursor: pointer" data-url="tehdoc/to">
  <h2>ТО</h2>
    <i class="fa fa-recycle" aria-hidden="true" style="font-size: 120px;"></i>
    <div class="text-muted" style="font-size: 20px">Техническое обслуживание</div>
  </div>

</div>
<br>


<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(document).ready(function () {
    $('.about').on('click', function (e) {
      var url = $(this).data('url');
      if (url){
        location.href = url;
      }
    })
  });



</script>
