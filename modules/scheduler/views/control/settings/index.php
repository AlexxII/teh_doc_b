<style>
  #main-content {
    width: 100% !important;
  }
  #settings-leftside {
    width: 256px;
    height: 100%;
    padding: 0 10px 0 10px;
  }
  #settings-rightside {
    height: 100%;
    width: 100%
  }
  #settings-leftside h4 {
    font-size: 13px;
    font-weight: 600;
  }
  #settings-leftside h4 a{
    text-decoration: none ;
  }
  .panel-body p {
    font-size: 12px;
  }
  .panel-body a {
    text-decoration: none;
    cursor: pointer;
  }

</style>

<div style="display: flex">
  <div id="settings-leftside">
    <div class="panel-group" id="accordion">
      <!-- 1 панель -->
      <div class="panel panel-default">
        <!-- Заголовок 1 панели -->
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Добавить календарь</a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <!-- Содержимое 1 панели -->
          <div class="panel-body">
            <p><a class="ext" data-url="/control/settings/calendars-for-subscribe">Подписаться на календарь</a></p>
            <p><a class="ext" data-url="/control/settings/create-calendar">Создать новый календарь</a></p>
          </div>
        </div>
      </div>
      <!-- 2 панель -->
      <div class="panel panel-default">
        <!-- Заголовок 2 панели -->
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Настройка моих календарей</a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
          <!-- Содержимое 2 панели -->
          <div class="panel-body">
            <p>Игнатенко А.М.</p>
          </div>
        </div>
      </div>
      <!-- 3 панель -->
      <div class="panel panel-default" style="display: none">
        <!-- Заголовок 3 панели -->
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Настройки других календарей</a>
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
          <!-- Содержимое 3 панели -->
          <div class="panel-body">
            <p></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="settings-rightside">
    <div id="setting-content-wrap">
      <div id="setting-content"></div>
    </div>
  </div>
</div>

<script>
  $('.ext').on('click', function () {
    var url = 'scheduler' + $(this).data('url');
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      $('#setting-content').html(response.data.data);
    }).fail(function () {
      console.log('Что-то пошло не так');
    });
  });

  $(document).ready(function () {
    var url = 'scheduler/control/settings/user-calendars';
    $.ajax({
      url: url,
      method: 'get'
    }).done(function (response) {
      // $('#setting-content').html(response.data.data);
    }).fail(function () {
      console.log('Что-то пошло не так');
    });
  });

</script>
