<?php

namespace app\modules\scheduler\controllers;

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
    $case = $_POST['show'];
    $startDate = $_POST['start'];
    $endDate = $_POST['end'];
    $result = array();
    $sessions = VksSessions::find()
      ->where('vks_date' > $startDate)
      ->andWhere(['vks_upcoming_session' => 1])
      ->andWhere(['vks_cancel' => 0])
      ->asArray()->all();
    $now = date("Y-m-d");
    foreach ($sessions as $key => $session) {
      $result[$key]['title'] = $session['vks_type_text'];
      if (!$session['vks_teh_time_start']){
        $time = $session['vks_work_time_start'];
      } else {
        $time = $session['vks_teh_time_start'];
      }
      $result[$key]['start'] = $session['vks_date']. 'T' . $time;
      if ($session['vks_date'] < $now) {
        $result[$key]['color'] = 'red';
      } else {
        $result[$key]['color'] = '#dd6813';
      }
      $result[$key]['url'] = 'vks/sessions/view-up-session?id=' . $session['id'];
      $result[$key]['durationEditable'] = 'true';
    }
    return json_encode($result);
  }

}