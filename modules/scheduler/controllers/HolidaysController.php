<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

use app\modules\scheduler\models\Holiday;

class HolidaysController extends Controller
{
  public function actionIndex(){
    return $this->render('index');
  }

  public function actionHolidays()
  {

  }

  public function actionForm($startDate, $endDate, $diff)
  {
    $model = new Holiday();
    $sDate = date('d.m.Y', strtotime($startDate));
    $eDate = date('d.m.Y', strtotime($endDate));
    $model->start_date = $sDate;
    $model->end_date = $eDate;
    $model->duration = $diff;
    return $this->renderAjax('_form', [
      'model' => $model
    ]);
  }

  public function actionSaveHoliday()
  {
    if (isset($_POST['msg'])) {
      $msg = $_POST['msg'];
      $model = new Holiday();
      $model->start_date = date('Y-m-d', strtotime($msg['start']));
      $model->end_date = date('Y-m-d', strtotime($msg['end']));
      $model->created_user = Yii::$app->user->identity->id;
      $model->duration = $msg['duration'];
      $model->description = $msg['description'];
      $model->holiday_type = $msg['hType'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;

  }


}