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
  <div class="dynamic-content">
    <div class="col-md-12 col-lg-12"
         style="border: dashed 1px #0c0c0c; border-radius: 4px; padding: 20px 0px 10px 0px; margin-bottom: 10px; position: relative">
      <span class="text-muted dynamic-control" style="position: absolute;top:5px;right:10px;font-size: 10px">
        <i class="fa fa-plus-square-o add-combined-session"
           aria-hidden="true"
           style="cursor: pointer; font-size: 25px; color: #4eb305"
           data-toggle="tooltip"
           data-placement="top"
           title="Добавить чать отпуска">
        </i></span>
      <span class="text-muted dynamic-title" style="position: absolute;top:5px;left:10px;font-size: 10px"></span>

      <div class="dynamic-wrap">
        <div class="form-group col-md-11 col-lg-11" style="margin-top: 10px">
          <input id="holiday-1" class="form-control datepicker-here" type="text" style="background-color: #fff"
                 readonly>
        </div>
      </div>
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