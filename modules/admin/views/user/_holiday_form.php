<?php

use yii\helpers\Html;
use app\assets\AirDatepickerAsset;

AirDatepickerAsset::register($this);

$this->title = 'График отпусков';
$this->params['breadcrumbs'][] = ['label' => 'Профиль пользователя', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
  .datepicker {
    z-index: 999999999;
  }
</style>

<div id="main-wrap">
  <div class="dynamic-wrap">
    <div class="form-group" style="margin-top: 0px">
      <label>Часть отпуска:</label>
      <input id="holiday-1" class="form-control datepicker-here" type="text" style="background-color: #fff"
             readonly>
    </div>
  </div>
</div>


<script>
  $(document).ready(function () {

    $('.datepicker-here').datepicker({
      toggleSelected: false,
      multipleDatesSeparator: ' - ',
      range: true,
      clearButton: true
    });

    $('#add').on('click', function () {
      var d = $('.holiday-wrap');
      var clone = d.clone();
      console.log(clone);
      $('#main-wrap').append(clone);
    })

  });
</script>
