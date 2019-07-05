<?php

$this->title = 'ВКС';
$this->params['breadcrumbs'][] = $this->title;

$about = "ВКС";

?>

<div class="col-lg-1 col-md-1 about" data-url="/vks/sessions/index" style="text-align:center; cursor: pointer">
  <div class="">
    <i class="fa fa-television" aria-hidden="true" style="font-size: 50px"></i>
  </div>
  <div class="row" id="footer">
    <h5>Журнал предстоящий сеансов ВКС</h5>
  </div>
</div>


<div class="col-lg-4 col-md-6 about" data-url="/vks/sessions/create-up-session"
     style="text-align: center; cursor: pointer">
  <div class="">
    <h2>Добавить сеанс</h2>
  </div>
  <div class="">
    <i class="fa fa-calendar-plus-o" aria-hidden="true" style="font-size: 150px"></i>
  </div>
  <div class="row" id="footer">
    <h4>Добавить предстоящий сеанс ВКС</h4>
  </div>
</div>


<div class="col-lg-4 col-md-6 about" data-url="/vks/sessions/create-session"
     style="text-align: center; cursor: pointer">
  <div class="">
    <h2>Подтвердить сеанс</h2>
  </div>
  <div class="">
    <i class="fa fa-calendar-check-o" aria-hidden="true" style="font-size: 150px"></i>
  </div>
  <div class="row" id="footer">
    <h4>Добавить прошедший сеанс ВКС</h4>
  </div>
</div>


<div class="col-lg-4 col-md-6 about" data-url="/vks/sessions/archive" style="text-align: center; cursor: pointer">
  <div class="">
    <h2>Архив</h2>
  </div>
  <div class="">
    <i class="fa fa-calendar" aria-hidden="true" style="font-size: 150px"></i>
  </div>
  <div class="row" id="footer">
    <h4>Архив сеансов ВКС</h4>
  </div>
</div>


<div class="col-lg-4 col-md-6 about" data-url="/vks/analytics/index" style="text-align: center; cursor: pointer">
  <div class="">
    <h2>Статистика</h2>
  </div>
  <div class="">
    <i class="fa fa-bar-chart" aria-hidden="true" style="font-size: 150px"></i>
  </div>
  <div class="row" id="footer">
    <h4>Анализ сеансов ВКС</h4>
  </div>
</div>


<script>
  $(".about").on('click', function (e) {
    var url = $(this).data('url');
    location.href = url;
  })
</script>