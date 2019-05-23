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
    foreach ($sessions as $key => $session) {
      $result[$key]['title'] = $session['vks_type_text'];
      $result[$key]['start'] = $session['vks_date'];

      if ($session['vks_type'] == 1982793808) {
        $result[$key]['color'] = '#f4e0f9';
      } else {
        $result[$key]['color'] = '#fdf3ce';
      }
      $result[$key]['url'] = 'vks/sessions/view-up-session?id=' . $session['id'];
    }
    return json_encode($result);
  }

}