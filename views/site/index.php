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

<!--  <div class="col-lg-4 col-md-4 about" data-url="/equipment" style="text-align:center; cursor: pointer">
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
-->
  <div class="body-content">

  </div>
</div>


<script>
    $(".about").on('click', function (e) {
        var url = $(this).data('url');
        location.href = url;
    })
</script>