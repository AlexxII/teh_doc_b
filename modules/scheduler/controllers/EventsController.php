<?php

namespace app\modules\scheduler\controllers;

use app\modules\scheduler\models\Event;
use app\modules\scheduler\models\Holiday;
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

    $luser = Yii::$app->user->identity->id;

    $events = Event::find()
//      ->where(['user_id' => $luser])
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

    foreach ($events as $key => $event) {
      $result[$key + $count]['title'] = $event->title;
      $result[$key + $count]['start'] = $event->start_date;
      $result[$key + $count]['end'] = $event->end_date;
      $result[$key + $count]['color'] = $event->color;
      $result[$key + $count]['exUrl'] = 'sub-event/' . $event->id;
      $result[$key + $count]['url'] = '#';
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

  public function actionVks($i)
  {
    $vksId = $i;
    $model = VksSessions::findOne($vksId);

    return $this->renderAjax('_vks_view', [
      'model' => $model, true
    ]);
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
  }

  public function actionSubEvent($i)
  {
    $sEventId = $i;
    $model = Event::findOne($sEventId);

    return $this->renderAjax('_sub_event_view', [
      'model' => $model, true
    ]);
  }

  public function actionEventForm($startDate, $endDate)
  {
    $model = new Event();
    $sDate = date('d.m.Y', strtotime($startDate));
    $eDate = date('d.m.Y', strtotime($endDate));
    $model->start_date = $sDate;
    $model->end_date = $eDate;
    return $this->renderAjax('_create_form', [
      'model' => $model
    ]);
  }

  public function actionSaveEvent()
  {
    if (isset($_POST['msg'])) {
      $userId = Yii::$app->user->identity->id;
      $msg = $_POST['msg'];
      $model = new Event();
      $model->start_date = date('Y-m-d', strtotime($msg['start']));
      $model->end_date = date('Y-m-d', strtotime($msg['end']));
      $model->title = $msg['title'];
      $model->description = $msg['desc'];
      $model->color = $msg['color'] ? $msg['color'] : null;
      $model->user_id = $userId;

      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionUpdateEvent($id)
  {
    $model = Event::findOne($id);
    if ($model) {
      return $this->renderAjax('_create_form', [
        'model' => $model
      ]);
    }
    return false;
  }

  public function actionSaveUpdatedEvent()
  {
    if (isset($_POST['id'])) {
      $eId = $_POST['id'];
      $model = Event::findOne($eId);
      $msg = $_POST['msg'];
      $model->start_date = date('Y-m-d', strtotime($msg['start']));
      $model->end_date = date('Y-m-d', strtotime($msg['end']));
      $model->title = $msg['title'];
      $model->description = $msg['desc'];
      $model->color = $msg['color'] ? $msg['color'] : null;
      if ($model->save()) {
        return true;
      }
      return false;
    }
    return false;
  }

  public function actionDeleteEvent()
  {
    if (isset($_POST['event'])) {
      $eId = $_POST['event'];
      $model = Event::findOne($eId);
      if ($model->delete()) {
        return true;
      }
      return false;
    }
    return false;
  }

}
