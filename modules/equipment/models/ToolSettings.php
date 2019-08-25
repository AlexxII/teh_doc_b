<?php

namespace app\modules\equipment\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\base\MHelper;

class ToolSettings extends \yii\db\ActiveRecord
{
  public static function tableName()
  {
    return 'equipment_settings_tbl';
  }

  public static function findModel($id)
  {
    if (($model = ToolSettings::find()->where(['eq_id' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

  public function __construct()
  {
    $this->id = MHelper::generateId();
  }


}