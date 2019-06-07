<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

use app\modules\scheduler\models\Holiday;

class HolidaysController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionHolidays($year)
  {
    if (isset($year)) {
      $sDate = $year . '-01-01';
      $eDate = $year . '-12-31';
      $models = Holiday::find()
        ->where(['>=', 'start_date', $sDate])
        ->andWhere(['<=', 'end_date', $eDate])
        ->all();
      $yearData = [];
      foreach ($models as $key => $model) {
        $yearData[$key]['id'] = $model->id;
        $yearData[$key]['name'] = $model->title;
        $yearData[$key]['location'] = $model->description;
        $type = $model->holiday_type;
        if ($type == 0) {
          $yearData[$key]['duration'] = 'Рабочий день';
          $yearData[$key]['color'] = 'grey';
        } else if ($type == 1) {
          $yearData[$key]['duration'] = 'Предпраздничный';
          $yearData[$key]['color'] = '#ff8f8f';
        } else if ($type == 2) {
          $yearData[$key]['duration'] = 'Сокращенный';
          $yearData[$key]['color'] = '#ff8f8f';
        } else {
          $yearData[$key]['duration'] = 'Выходной';
          $yearData[$key]['color'] = 'red';
        }
        $yearData[$key]['sYear'] = Date('Y', strtotime($model->start_date));
        $yearData[$key]['sMonth'] = Date('n', strtotime($model->start_date)) - 1;
        $yearData[$key]['sDay'] = Date('j', strtotime($model->start_date));
        $yearData[$key]['eYear'] = Date('Y', strtotime($model->end_date));
        $yearData[$key]['eMonth'] = Date('n', strtotime($model->end_date)) - 1;
        $yearData[$key]['eDay'] = Date('j', strtotime($model->end_date));
      }
      return json_encode($yearData);
    }
    return false;

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
      $model->title = $msg['title'];
      $model->start_date = date('Y-m-d', strtotime($msg['start']));
      $model->end_date = date('Y-m-d', strtotime($msg['end']));
      $model->created_user = Yii::$app->user->identity->id;
      $model->duration = $msg['duration'];
      $model->description = $msg['description'];
      $model->holiday_type = $msg['hType'];
      $model->year_repeat = $msg['repeat'];
      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;

  }


}