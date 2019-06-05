<?php

namespace app\modules\scheduler\models;

use app\base\MHelper;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\User;

class Vacation extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'scheduler_vacations_tbl';
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
      'duration' => 'Продолжительность:',
      'user_id' => 'Пользователь:'
    ];
  }

  public function rules()
  {
    return [
      [['start_date', 'end_date', 'user_id'], 'required'],
      [['duration'], 'string'],
    ];
  }

  public function getUserList()
  {
    return ArrayHelper::map(User::find()->where(['!=', 'login', 'sAdmin'])->asArray()->all(), 'id', 'username');
  }

  public function getUser()
  {
    return $this->hasOne(User::class, ['id' => 'user_id']);

  }

  public function getUsername()
  {
    if ($this->user) {
      return $this->user->username;
    } else {
      return '-';
    }
  }
}