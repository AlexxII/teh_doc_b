<?php

namespace app\modules\scheduler\controllers;

use app\modules\scheduler\models\Event;
use app\modules\tehdoc\modules\to\models\ToSchedule;
use app\modules\vks\models\VksSessions;
use Yii;
use yii\web\Controller;

class EventsController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionEdit()
  {
    return $this->render('edit');
  }

  public function actionList()
  {
    $startDate = $_POST['start'];
    $endDate = $_POST['end'];
    $result = array();
    $sessions = VksSessions::find()
      ->where('vks_date' > $startDate)
      ->andWhere(['vks_upcoming_session' => 1])
      ->andWhere(['vks_cancel' => 0])
      ->asArray()->all();

    $tos = ToSchedule::find()
      ->where('plan_date' > $startDate)
      ->andWhere(['checkmark' => 0])
      ->andWhere(['valid' => 1])
      ->groupBy('plan_date')
      ->with('toType')
      ->all();

    $now = date("Y-m-d");
    $count = 0;
    foreach ($sessions as $key => $session) {
      $result[$key]['title'] = $session['vks_type_text'];
      if (!$session['vks_teh_time_start']) {
        $time = $session['vks_work_time_start'];
      } else {
        $time = $session['vks_teh_time_start'];
      }
      $result[$key]['start'] = $session['vks_date'] . 'T' . $time;
      if ($session['vks_date'] < $now) {
        $result[$key]['color'] = 'red';
      } else {
        $result[$key]['color'] = '#dd6813';
      }
      $result[$key]['url'] = 'vks/sessions/view-up-session?id=' . $session['id'];
      $result[$key]['exUrl'] = 'vks/' . $session['id'];
      $result[$key]['durationEditable'] = 'true';
      $count++;
    }
    foreach ($tos as $key => $to) {
      $result[$key + $count]['title'] = "Проведение ТО";
      $result[$key + $count]['start'] = $to->plan_date;
      $result[$key + $count]['exUrl'] = 'to/' . $to->plan_date;
      $result[$key + $count]['url'] = 'tehdoc/to/month-schedule/view?id=' . $to->schedule_id;
    }

    return json_encode($result);
  }

  public function actionVks($i)
  {
    $vksId = $i;
    $model = VksSessions::findOne($vksId);

    return $this->renderAjax('_vks_view', [
      'model' => $model, true
    ]);
    return var_dump($session->vks_type_text);
  }

  public function actionTo($i)
  {
    $toPlanDate = $i;
    $models = ToSchedule::find()
      ->with(['admin', 'auditor', 'toType', 'toEq'])
      ->where(['plan_date' => $toPlanDate])
      ->all();

    return $this->renderAjax('_to_view', [
      'models' => $models, true
    ]);
//    return var_dump($req);
  }

  public function actionEventForm($startDate, $endDate)
  {
    $model = new Event();
    $model->start_date = $startDate;
    $model->end_date = $endDate;
    return $this->renderAjax('_create_form', [
      'model' => $model,
      'startDate' => $startDate,
      'endDate' => $endDate
    ]);
  }

}