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

  <div class="col-lg-4 col-md-4 about" data-url="/vks" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>Журнал ВКС</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-television" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4 class="text-muted">Журнал сеансов видеосвязи</h4>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 about" data-url="/scheduler" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>Календарь</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-calendar" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4 class="text-muted">Календарь - планировщик</h4>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 about" data-url="/equipment" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>Техника</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-microchip" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4 class="text-muted">Перечень оборудования</h4>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 about" data-url="/to" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>ТО</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-microchip" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4 class="text-muted">Техническое обслуживание</h4>
    </div>
  </div>
  <div class="col-lg-4 col-md-4 about" data-url="/maps" style="text-align:center; cursor: pointer">
    <div class="row" id="header">
      <h2>Карты</h2>
    </div>
    <div class="" id="main">
      <i class="fa fa-map" aria-hidden="true" style="font-size: 150px"></i>
    </div>
    <div class="row" id="footer">
      <h4 class="text-muted">Регионы России</h4>
    </div>
  </div>
  <div class="body-content">


  </div>
</div>

<?php
/*      <svg focusable="false" viewBox="0 0 24 24">
        <path d="M0 0h24v24H0V0z" fill="none"></path>
        <path d="M20.08 15.03l-.08.08v3.87c0 .44-.28.8-.67.93L12.41 13l2.2-2.2c-.36-.58-.71-1.18-1.02-1.81L4 18.58V4.99a1
      1 0 0 1 1-1h7.57c.09-.72.29-1.39.58-2H5c-1.64 0-3 1.36-3 3v13.99c0 1.64 1.36 3 3 3h14a3 3 0 0 0 3-2.99v-6.21a27.8
      27.8 0 0 1-1.92 2.25zM12 19.99H5.41l5.58-5.58 5.57 5.57H12v.01zM19 0c-3 0-5 1.99-5 4.99 0 3.82 5 9 5 9s5-5.18
      5-9c0-3-2-4.99-5-4.99zm0 6.74c-.96 0-1.75-.79-1.75-1.75s.79-1.75 1.75-1.75 1.75.79 1.75 1.75-.79 1.75-1.75 1.75z"></path>
      </svg>
*/

?>


<script>
  $(".about").on('click', function (e) {
    var url = $(this).data('url');
    location.href = url;
  })
</script>