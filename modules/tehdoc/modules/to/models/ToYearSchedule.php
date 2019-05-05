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

/*  public function rules()
  {
    [['eq_id', 'schedule_year', 'm1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7', 'm8', 'm9', 'm10', 'm11', 'm12'], 'safe'];
  }*/

  public static function findModel($year)
  {
    if (($model = ToYearSchedule::find()->where(['schedule_year' => $year])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Запрошенная страница не существует.');
  }

}
