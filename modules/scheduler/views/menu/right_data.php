<style>
  button {
    margin: 10px 20px 0 20px;
  }
</style>
<div class="dropdown" id="view-selector" title="Месяц">
  <button class="btn btn-default dropdown-toggle" type="button" id="view-menu-btn"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
          style="max-width: 110px; text-overflow: ellipsis;overflow: hidden;padding: 5px; white-space: nowrap; ">
    <span id="title"> Месяц</span>
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="view-menu-btn">
    <li value="dayGridDay"><a href="">День</a></li>
    <li value="dayGridWeek"><a href="">Неделя</a></li>
    <li value="dayGridMonth"><a href="">Месяц</a></li>
    <li value="year"><a href="">Год</a></li>
    <li value="list"><a href="">Расписание</a></li>
    <li role="separator" class="divider"></li>
    <li value="production"><a href="">Производственный календарь</a></li>
  </ul>
</div>