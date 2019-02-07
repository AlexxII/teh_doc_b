<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;

?>

<style>
  .head {
    border-bottom: 1px solid #e1e4e8;
    margin-bottom: 16px;
  }
  .subhead {
    margin-top: 40px;
    margin-bottom: 16px;
  }
  ::placeholder {
    color: #6a737d;
  }
  label {
    font-weight: 600;
  }
  .note {
    color: #586069;
    display: block;
    font-size: 12px;
    font-weight: 400;
    margin: 0;
  }

  .note-2 {
    color: #586069;
    display: block;
    font-size: 12px;
    font-weight: 400;
  }

  .form-checkbox {
    margin: 15px 0px;
    padding-left: 20px;
    vertical-align: middle;
  }
  .form-checkbox input[type="checkbox"], .form-checkbox input[type="radio"] {
    float: left;
    margin: 5px 0 0 -20px;
    vertical-align: middle;
  }
  .d-flex {
    display: flex !important;
  }
  .flex-items-center {
    align-items: center !important;
  }
  .pr-6 {
    padding-right: 40px !important;
  }
</style>


<div class="tool-view">

  <div class="settings">
    <div class="head">
      <h3 class="setting-header">Информация</h3>
    </div>

    <div class="row">
      <div class="col-lg-6 col-md-6">
        <label>Выберите класс:</label>
        <select class="form-control">
          <option value="" disabled selected>Веберите</option>
          <option>ПАК</option>
          <option>Комплект</option>
          <option>Отдельные средства</option>
        </select>
      </div>
      <div class="col-lg-6 col-md-6" style="text-align: right">
        <label>Редактирование данных:</label>
        <br>
        <button class=" btn btn-success btn-sm" disabled>ИНФО</button>
      </div>
    </div>
    <p></p>
    <div class="subhead">
      <h3 class="subsetting-header">Опции</h3>
    </div>
    <ul class="list-group">
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input id="to_feature" type="checkbox" name="has_to" value="">
          <label for="to_feature" style="font-weight: 500">В графике ТО</label>
          <p class="note">Отображать данное оборудование в графике ТО.</p>
        </div>
      </li>
      <li class="list-group-item">
        <div class="form-checkbox js-complex-option">
          <input id="finance_feature" type="checkbox" name="has_to" value="">
          <label for="finance_feature" style="font-weight: 500">Инвентаризация</label>
          <p class="note">Отображаить в таблице бухгалтерского учета.</p>
        </div>
      </li>
    </ul>

    <div class="head subhead">
      <h3 class="setting-header">Логирование</h3>
    </div>
    <p class="note-2">
      <a href="#" >Просмотреть ЛОГ</a>
    </p>
  </div>
  <ul class="list-group">
    <li class="list-group-item">
      <div class="form-checkbox js-complex-option">
        <input id="log_feature" type="checkbox" name="has_to" value="">
        <label for="log_feature" style="font-weight: 500">Вести лог</label>
        <p class="note">Позволяет системе отслеживать и записывать производимые действия над оборудованием.</p>
      </div>
    </li>
  </ul>


  <div class="subhead">
    <h3 class="subsetting-header">Удаление</h3>
  </div>
  <ul class="list-group">
    <li class="list-group-item" style="border-color: #ed1d1a">
      <div class="d-flex flex-items-center">
        <div class="form-checkbox js-complex-option">
          <label for="to_feature" style="font-weight: 500">Удалить</label>
          <p class="note pr-6">Удалив данное оборудование востановить его не удастся.</p>
        </div>
        <div style="text-align: right">
          <a class="btn btn-sm btn-danger mr-5">Удалить</a>
        </div>
      </div>
    </li>
  </ul>

</div>

</div>