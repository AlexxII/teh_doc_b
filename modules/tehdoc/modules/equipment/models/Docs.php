<?php

namespace app\modules\tehdoc\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;

class Docs extends \yii\db\ActiveRecord
{
  const PLACEMENT_TABLE = '{{%teh_placement_tbl}}';
  const CATEGORY_TABLE = '{{%teh_category_tbl}}';

  public static function tableName()
  {
    return 'teh_files_tbl';
  }

}