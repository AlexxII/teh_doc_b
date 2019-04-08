<?php

namespace app\modules\tehdoc\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;
use Ramsey\Uuid\Uuid;

class Oth extends \yii\db\ActiveRecord
{

  public function __construct()
  {
//    $this->id = Uuid::uuid4();
    $this->id = '2222134afafafa2';
  }

  public static function tableName()
  {
    return 'teh_oth_tbl';
  }

}