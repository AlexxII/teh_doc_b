<?php

namespace app\modules\scheduler\models;

use app\base\MHelper;


class Event extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'scheduler_events_tbl';
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'start_date' => 'Дата начала:',
      'end_date' => 'Дата окончания:',
      'title' => 'Наименование:',
      'description' => 'Подробности:',
      'color' => 'Цвет события:'
    ];
  }

  public function rules()
  {
    return [
      [['start_date', 'end_date', 'title'], 'required'],
      [['description'], 'string'],
    ];
  }

  public function getColorList()
  {
    return [
      '#7bd148' => 'Зеленый',
      "#5484ed" => 'Темно-синий',
      "#a4bdfc" => 'Синий',
      "#46d6db" => 'Бирюзовый',
      "#7ae7bf" => 'Светло-зеленый',
      "#51b749" => 'Темно-зеленый',
      "#fbd75b" => 'Желтый',
      "#ffb878" => 'Оранжевый',
      "#ff887c" => 'Красный',
      "#dc2127" => 'Темно-красный',
      "#dbadff" => 'Фиолетовый',
      "#9b9820" => 'ИАД'

    ];

  }

}