<div>
  <div id="complex-settings" style="margin: 10px">
    <div class="settings">
      <div class="subhead">
        <h3 class="setting-header">Отображение</h3>
      </div>
      <ul class="list-group">
        <li class="list-group-item">
          <div class="form-checkbox js-complex-option">
            <label>
              <input class="check-it" type="checkbox"
                     data-id="<?= $model->id ?>"
                     data-check='complex-check' data-url='complex' <?php if ($model->complex) echo 'checked' ?>>
              Комплект
            </label>
            <span class="status-indicator" id="complex-check"></span>
            <p class="note">Отображать как комплект.</p>
          </div>
        </li>
      </ul>

      <div class="subhead">
        <h3 class="setting-header">Специальные работы
          <i class="fa fa-shield" aria-hidden="true" title=" Проведены Специальные работы"></i>
        </h3>
      </div>
      <ul class="list-group">
        <li class="list-group-item">
          <div class="form-checkbox js-complex-option">
            <label>
              <input class="check-it" type="checkbox" id="special_works_feature"
                     data-id="<?= $model->id ?>"
                     data-check='special-check'
                     data-url='special-works' <?php if ($model->specialStatus) echo 'checked' ?>>
              Специальные работы</label>
            <span class="status-indicator" id="special-check"></span>
            <p class="note">Над данным оборудованием были проведены специальные работы.</p>
            <div class="d-blue border">
              <div class="form-checkbox js-complex-option">
                <label>Номера наклеек</label>
                <p class="note pr-6">Укажите номера галограмм. Например: Л 727 7806339 или только партию 727 (если
                  указана
                  только она)</p>
              </div>
              <div class="form-checkbox">
                <div class="input-group" style="position: relative">
                <span class="input-group-btn">
                  <button class="btn btn-default save-title" type="button"
                          data-url="special-sticker-number"
                          data-id="<?= $model->id ?>" data-input="special-sticker"
                          data-result="special-result">Save</button>
                </span>
                  <input class="form-control title-input" type="text"
                         id="special-sticker" data-check="special-checkbox"
                         value="<?= $model->specialStickerNumber ?>">
                  <span class="result-check" id="special-result">
                  </span>
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
            <label>
              <input class="check-it" type="checkbox" data-check='maintenance-check'
                     data-id="<?= $model->id ?>"
                     data-url='maintenance' <?php if ($model->toStatus) echo 'checked' ?>>
              В графике ТО</label>
            <span class="status-indicator" id="maintenance-check"></span>
            <p class="note">Отображать в графике ТО.</p>
          </div>
        </li>
        <li class="list-group-item">
          <div class="form-checkbox js-complex-option">
            <input class="check-it" id="maintenance-work-feature" type="checkbox" data-check='work-count-check'
                   data-url='work-count'>
            <label for="maintenance-work-feature">Наработка</label>
            <span class="status-indicator" id="work-count-check"></span>
            <p class="note">Вести учет наработанного времени.</p>
            <div class="d-blue border">
              <div class="form-checkbox js-complex-option">
                <label>Шаблон учета времени</label>
                <p class="note pr-6">Учет наработанного времени будет вычислятся по указанному шаблону (по умолчанию -
                  8ми
                  часовой рабочий день).</p>
              </div>
              <div class="form-checkbox">
                <div class="input-group">
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
    </div>
  </div>
</div>