<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

use app\modules\vks\models\VksSessions;
use app\modules\tehdoc\modules\to\models\ToSchedule;
use app\modules\scheduler\models\Holiday;
use app\modules\scheduler\models\Event;

class DutyController extends Controller
{

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

    $holidays = Holiday::find()
      ->where('start_date' > $startDate)
      ->andWhere(['<=', 'end_date', $endDate])
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
      $count++;
    }
    foreach ($tos as $key => $to) {
      $result[$key + $count]['title'] = "Проведение ТО";
      $result[$key + $count]['start'] = $to->plan_date;
      $result[$key + $count]['exUrl'] = 'to/' . $to->plan_date;
      $result[$key + $count]['url'] = 'tehdoc/to/month-schedule/view?id=' . $to->schedule_id;
      $count++;
    }
    $count++;

    foreach ($holidays as $key => $holiday) {
      $result[$key + $count]['title'] = $holiday->title;
      $result[$key + $count]['start'] = $holiday->start_date;
      $result[$key + $count]['end'] = $holiday->end_date;
      $result[$key + $count]['rendering'] = 'background';
      $result[$key + $count]['holiday_type'] = $holiday->holiday_type;
      $count++;
    }

    return json_encode(array_values($result));
  }

  public function actionIndex(){

    return $this->render('index');
  }

}