<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

use app\modules\scheduler\models\Event;

class FullYearController extends Controller
{
  public function actionIndex()
  {

    return $this->render('index');
  }

  public function actionProductionCalendar()
  {
    return $this->render('production_calendar');
  }

  public function actionVacationCalendar()
  {
    return $this->render('vacation_calendar');
  }

  public function actionYearEvents()
  {
    $models = Event::find()
      ->all();
    $userId = Yii::$app->user->identity->id;
    foreach ($models as $key => $model) {
      $yearData[$key]['id'] = $model->id;
      $yearData[$key]['name'] = $model->title;
      $yearData[$key]['color'] = $model->color;
      $yearData[$key]['location'] = $model->description;
      $yearData[$key]['duration'] = '';
      $yearData[$key]['sYear'] = Date('Y', strtotime($model->start_date));
      $yearData[$key]['sMonth'] = Date('n', strtotime($model->start_date)) - 1;
      $yearData[$key]['sDay'] = Date('j', strtotime($model->start_date));
      $yearData[$key]['eYear'] = Date('Y', strtotime($model->end_date));
      $yearData[$key]['eMonth'] = Date('n', strtotime($model->end_date)) - 1;
      $yearData[$key]['eDay'] = Date('j', strtotime($model->end_date));
    }
    return json_encode(array_values($yearData));
  }


  public function actionTest()
  {
    return $this->renderAjax('test');
  }

}