<?php

/* @var $this yii\web\View */

$this->title = 'Сайт РИАЦе';
Yii::$app->cache->flush();
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

<div class="site-index">

  <div class="col-lg-4 col-md-6 about" data-url="/vks/sessions/index" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>Предстоящие сеансы</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-television" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4>Журнал предстоящий сеансов ВКС</h4>
    </div>
  </div>

  <div class="col-lg-3 col-md-4 col-sm-6 placeholder about" style="cursor: pointer" data-url="tehdoc/equipment/tools">
    <h2>Оборудование</h2>
    <i class="fa fa-microchip" aria-hidden="true" style="font-size: 120px"></i>
    <div class="text-muted" style="font-size: 20px">Перечень оборудования</div>
  </div>


  <div class="body-content">

  </div>
</div>





<script>
    $(".about").on('click', function (e) {
        var url = $(this).data('url');
        location.href = url;
    })
</script>