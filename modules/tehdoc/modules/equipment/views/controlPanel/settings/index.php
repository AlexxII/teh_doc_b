<div class="complex-settings" style="margin-top: 15px">
  <div class="settings">

    <div class="subhead">
      <h3 class="setting-header">Отображение</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="consolidated-feature" type="checkbox" data-check='consolidated-check' data-url='consolidate'>
          <label for="consolidated-feature" style="font-weight: 500">В сводной таблице</label>
          <span class="status-indicator" id="consolidated-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать данный узел в сводной таблице.</p>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="oth-feature" type="checkbox" data-check='oth-check' data-url='oth'>
          <label for="oth-feature" style="font-weight: 500">В перечне ОТХ</label>
          <span class="status-indicator" id="oth-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать в таблице ОТХ.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Наименование в перечне</label>
              <p class="note pr-6">При отличии наименования в перечне ОТХ от истинного наименования оборудования,
                укажите необходимое наименование.</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." style="margin: 0">
                  </span>
                <input type="text" class="form-control" aria-label="...">
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="complex_feature" type="checkbox" data-check='complex-check' data-url='complex'>
          <label for="complex_feature" style="font-weight: 500">Комплект</label>
          <span class="status-indicator" id="complex-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать как комплект.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Наименование комплекта</label>
              <p class="note pr-6">При отличии..., вы сами знаете что сделать.</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." style="margin: 0">
                  </span>
                <input type="text" class="form-control" aria-label="...">
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="special_works_feature" type="checkbox" data-check='special-check' data-url='special-works'>
          <label for="special_works_feature" style="font-weight: 500">Таблицы СпецПроверки</label>
          <span class="status-indicator" id="special-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать в таблице спецпроверки, если над данным оборудованием
            были проведены специальные работы.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Номера наклеек</label>
              <p class="note pr-6">Укажите номера галограмм.</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." style="margin: 0">
                  </span>
                <input type="text" class="form-control" aria-label="...">
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>


    <div class="subhead">
      <h3 class="setting-header">Техническое обслуживание</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="maintenance-feature" type="checkbox" data-check='maintenance-check' data-url='maintenance'>
          <label for="maintenance-feature" style="font-weight: 500">В графике ТО</label>
          <span class="status-indicator" id="maintenance-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать в графике ТО.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Наименование в графике</label>
              <p class="note pr-6">При отличии наименования в графике ТО от истинного наименования оборудования,
                укажите необходимое наименование.</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." style="margin: 0">
                  </span>
                <input type="text" class="form-control" aria-label="...">
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="maintenance-work-feature" type="checkbox" data-check='work-count-check' data-url='work-count'>
          <label for="maintenance-work-feature" style="font-weight: 500">Наработка</label>
          <span class="status-indicator" id="work-count-check"></span>
          <p class="note" style="margin-bottom: 10px">Вести учет наработанного времени.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Шаблон подсчета времени</label>
              <p class="note pr-6">Учет наработанного времени будет вычислятся по указанному шаблону (по умолчанию - 8ми
                часовой рабочий день).</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" style="margin: 0">
                  </span>
                <select class="form-control">
                  <option value="0" disabled selected>Выберите</option>
                  <option value="1">Круглосуточное</option>
                  <option value="2">Рабочий день</option>
                  <option value="3">Шаблон 2</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <div class="subhead">
      <h3 class="subsetting-header">Бухгалтерский учет</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="inventory_feature" type="checkbox" data-check='inventory-check' data-url='inventory'>
          <label for="inventory_feature" style="font-weight: 500">Инвентаризация</label>
          <span class="status-indicator" id="inventory-check"></span>
          <p class="note" style="margin-bottom: 10px">Отображать в таблице бухгалтерского учета.</p>
          <div class="d-blue border">
            <div class="form-checkbox js-complex-option">
              <label style="font-weight: 500">Наименование в таблице</label>
              <p class="note pr-6">При отличии наименования в таблице инвентаризации от истинного наименования
                оборудования,
                укажите необходимое наименование.</p>
            </div>
            <div class="form-checkbox">
              <div class="input-group" style="padding-right: 20px">
                  <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." style="margin: 0">
                  </span>
                <input type="text" class="form-control" aria-label="...">
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="metals_feature" type="checkbox" data-check='metals-check' data-url='metals'>
          <label for="metals_feature" style="font-weight: 500">Драгоценные металлы</label>
          <span class="status-indicator" id="metals-check"></span>
          <p class="note">Отображать в таблице учета драгоценных металлов.</p>
        </div>
      </li>
    </ul>

    <div class="head subhead">
      <h3 class="setting-header">Логирование</h3>
    </div>
    <p class="note-2">
      <a href="#">Просмотреть ЛОГ</a>
    </p>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input class="ch" id="log_feature" type="checkbox" data-check='log-check' data-url='logging'>
          <label for="log_feature" style="font-weight: 500">Вести лог</label>
          <span class="status-indicator" id="log-check"></span>
          <p class="note">Позволяет системе отслеживать и записывать производимые действия над оборудованием.</p>
        </div>
      </li>
    </ul>

    <div class="subhead">
      <h3 class="subsetting-header">Danger zone</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item" style="border-color: #ed1d1a">
        <div class="d-flex flex-items-center">
          <div class="form-checkbox js-complex-option">
            <label style="font-weight: 500">Удаление</label>
            <p class="note pr-6">После удаления данные восстановить не удастся.</p>
          </div>
          <div style="text-align: right">
            <a id="delete-object" class="btn btn-sm btn-danger mr-5">Удалить</a>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>

<script>

  $(document).ready(function () {
    var successCheck = '<i class="fa fa-check" id="consolidated-check" aria-hidden="true" style="color: #4eb305"></i>';
    var warningCheck = '<i class="fa fa-times" id="consolidated-check" aria-hidden="true" style="color: #cc0000"></i>';
    var waiting = '<i class="fa fa-cog fa-spin" aria-hidden="true"></i>';
    $('.ch').change(function (e) {
      var checkId = $(this).data('check');
      $('#'+checkId).html(waiting);
      var url = $(this).data('url');
      $.ajax({
        url: url,
        success: function (data) {
          $('#'+checkId).html(successCheck);
        },
        error: function (data) {
          $('#'+checkId).html(warningCheck);
        }
      });
    })
  })
</script>