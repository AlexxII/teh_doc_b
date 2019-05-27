<?php

namespace app\modules\scheduler\controllers;

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
//      $result[$key]['url'] = 'vks/sessions/view-up-session?id=' . $session['id'];
      $result[$key]['url'] = 'vks/' . $session['id'];
      $result[$key]['durationEditable'] = 'true';
      $count++;
    }
    foreach ($tos as $key => $to) {
      $result[$key + $count]['title'] = "Проведение ТО";
      $result[$key + $count]['start'] = $to->plan_date;
      $result[$key + $count]['url'] = 'to/' . $to->plan_date;
    }

    return json_encode($result);
  }

  public function actionVks($i)
  {
    $vksId = $i;
    $session = VksSessions::findOne($vksId);
    return var_dump($session->vks_type_text);
  }

  public function actionTo($i)
  {
    $toPlanDate = $i;
    $req = ToSchedule::find()
      ->where(['plan_date' => $toPlanDate])
      ->asArray()->all();
    return var_dump($req);
  }

}