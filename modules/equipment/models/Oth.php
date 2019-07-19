<?php

namespace app\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\base\MHelper;

class Oth extends \yii\db\ActiveRecord
{

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }

  public static function tableName()
  {
    return 'teh_oth_tbl';
  }

}