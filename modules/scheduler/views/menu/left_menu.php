<div id="left-menu">
  <div class="menu-list">
    <div id="datepicker" style="margin-left: 30px"></div>
  </div>
  <div>
    <p style="padding-left: 30px">Добавить календарь</p>
  </div>
  <?php
/*  TODO Таблица с календарями:
  - id календаря
  - title наименование календаря
  - user_id пользователь, который создал
  - created дата создания
  - color цвет календаря


*/

?>
</div>

<script>
    $('#datepicker').datepicker({
        language: 'ru',
        todayHighlight: true
    }).on('changeDate', function (info) {
        console.log(info.date);
        calendar.gotoDate(info.date)
    });
</script>

