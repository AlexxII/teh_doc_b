<?php

namespace app\modules\scheduler\models;


class Event extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'scheduler_events_tbl';
  }

  public function attributeLabels()
  {
    return [
      'id' => 'ID',
      'start_date' => 'Дата начала:',
      'end_date' => 'Дата окончания:',
      'title' => 'Наименование:',
      'description' => 'Подробности:'
    ];
  }

}