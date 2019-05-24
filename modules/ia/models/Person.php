<?php

namespace app\modules\ia\models;

use Yii;

/**
 * This is the model class for table "teh_interface_tbl".
 *
 * @property string $id
 * @property string $name
 * @property string $text
 */
class Person extends \yii\db\ActiveRecord
{

  public static function getDb() {
    return Yii::$app->get('ou_db');
  }


  public static function tableName()
  {
    return 'dbo.Department';
  }


}
