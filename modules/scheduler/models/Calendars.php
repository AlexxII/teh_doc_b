<?php

namespace app\modules\scheduler\models;

use app\base\MHelper;


class Calendars extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'calendar_pull_tbl';
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'title' => 'Наименование:',
      'description' => 'Описание:',
      'color' => 'Цвет:'
    ];
  }

  public function rules()
  {
    return [
      [['title'], 'required'],
      [['description'], 'string'],
    ];
  }

}