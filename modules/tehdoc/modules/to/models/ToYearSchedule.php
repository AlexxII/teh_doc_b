<?php

namespace app\modules\tehdoc\modules\to\models;

use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

use app\modules\admin\models\User;
use app\base\MHelper;

class ToYearSchedule extends \yii\db\ActiveRecord
{

  public static function tableName()
  {
    return 'teh_to_year_schedule_tbl';
  }

  public function __construct()
  {
    parent::__construct();
  }


  /*
  public function rules()
    {
    }
  */

  public static function findModel($year)
  {
    if (($model = ToYearSchedule::find()->where(['schedule_year' => $year])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрошенная страница не существует.');
  }

}
