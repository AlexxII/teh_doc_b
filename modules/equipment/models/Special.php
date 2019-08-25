<?php

namespace app\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\base\MHelper;

class Special extends \yii\db\ActiveRecord
{
  // Описывает Спец работы
  public static function tableName()
  {
    return 'equipment_special_works_tbl';
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }


}