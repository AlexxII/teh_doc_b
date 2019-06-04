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
      '#7bd148' => 'title'
    ];
  }

}