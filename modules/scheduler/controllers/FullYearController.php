<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class FullYearController extends Controller
{
  public function actionIndex(){

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
}