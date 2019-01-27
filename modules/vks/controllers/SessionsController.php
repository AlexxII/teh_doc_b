<?php

namespace app\modules\vks\controllers;

use app\modules\vks\models\SSP;
use app\modules\vks\models\VksPlaces;
use app\modules\vks\models\VksSessions;
use app\modules\vks\models\VksSubscribes;
use app\modules\vks\models\VksTypes;
use Yii;
use yii\web\Controller;
use app\modules\vks\models\VksLog;

class SessionsController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionServerSide()
  {
    $table = 'vks_sessions_tbl';
    $primaryKey = 'id';
    $columns = array(
      array('db' => 'id', 'dt' => 0),
      array(
        'db' => 'vks_date',
        'dt' => 1,
        'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
          if ($d != null) {
            return date('d.m.Y', strtotime($d));
          } else {
            return '-';
          }
        }
      ),
      array(
        'db' => 'vks_date',
        'dt' => 2,
        'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
          if ($d != null) {
            $month = date('m', strtotime($d));
            $year = date('Y г.', strtotime($d));
            $dates = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
            return $dates[$month - 1] . ' ' . $year;
          } else {
            return '-';
          }
        }
      ),
      array(
        'db' => 'vks_teh_time_start',
        'dt' => 3
      ),
      array(
        'db' => 'vks_work_time_start',
        'dt' => 4
      ),
      array('db' => 'vks_type_text', 'dt' => 5),
      array('db' => 'vks_place_text', 'dt' => 6),
      array('db' => 'vks_subscriber_office_text', 'dt' => 7),
      array('db' => 'vks_subscriber_name', 'dt' => 8),
      array('db' => 'vks_order_text', 'dt' => 9),
      array('db' => 'combined', 'dt' => 10)
    );
    $sql_details = \Yii::$app->params['sql_details'];
    $where = 'vks_upcoming_session = 1';

    // TODO : если отсутствует таблица в бд или сама БД, то отправить соответствующее сообщение
    return json_encode(
      SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
    );
  }

  public function actionServerSideEx()
  {
    $table = 'vks_sessions_tbl';
    $primaryKey = 'id';
    $columns = array(
      array('db' => 'id', 'dt' => 0),
      array(
        'db' => 'vks_date',
        'dt' => 1,
        'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
          if ($d != null) {
            return date('d.m.Y', strtotime($d));
          } else {
            return '-';
          }
        }
      ),
      array(
        'db' => 'vks_date',
        'dt' => 2,
        'formatter' => function ($d, $row) { //TODO разобраться с форматом отображения даты
          if ($d != null) {
            $month = date('m', strtotime($d));
            $year = date('Y г.', strtotime($d));
            $dates = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
            return $dates[$month - 1] . ' ' . $year;
          } else {
            return '-';
          }
        }
      ),
      array('db' => 'vks_type_text', 'dt' => 4),
      array('db' => 'vks_place_text', 'dt' => 5),
      array('db' => 'vks_subscriber_office_text', 'dt' => 6),
      array('db' => 'vks_order_text', 'dt' => 7),

      array('db' => 'vks_subscriber_name', 'dt' => 14),
      array('db' => 'vks_teh_time_start', 'dt' => 15),
      array('db' => 'vks_teh_time_end', 'dt' => 16),
      array('db' => 'vks_work_time_start', 'dt' => 17),
      array('db' => 'vks_work_time_end', 'dt' => 18),
      array('db' => 'vks_duration_teh', 'dt' => 19),
      array('db' => 'vks_duration_work', 'dt' => 20)
    );
    $sql_details = \Yii::$app->params['sql_details'];
    $where = 'vks_upcoming_session = 0';

    // TODO : если отсутствует таблица в бд или сама БД, то отправить соответствующее сообщение
    return json_encode(
      SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
    );
  }

  public function actionCreateUpSession()
  {
    $model = new VksSessions(['scenario' => VksSessions::SCENARIO_CREATE]);
    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $result = false;
      $model->vks_record_create = $date;
      $model->vks_record_update = $date;
      $model->vks_upcoming_session = 1;
      $result = $model->save();
      $this->logVks($model->id, "Добавил запись о предстоящем сеансе ВКС");
      if (!empty($_POST['test-type'])) {
        foreach ($_POST['test-type'] as $key => $item) {
          $newModel = new VksSessions(['scenario' => VksSessions::SCENARIO_CREATE]);
          $newModel->load(Yii::$app->request->post());
          $newModel->vks_type = $item;
          $typeModel = VksTypes::findOne(['ref' => $item]);
          $newModel->vks_type_text = $typeModel->name;
          if (!empty($_POST['test-place'][$key])) {
            $placeId = $_POST['test-place'][$key];
            $newModel->vks_place = $placeId;
            $placeModel = VksPlaces::findOne(['ref' => $placeId]);
            $newModel->vks_place_text = $placeModel->name;
          }
          $newModel->vks_record_create = $date;
          $newModel->vks_record_update = $date;
          $newModel->vks_upcoming_session = 1;
          $newModel->combined = 1;
          $result = $newModel->save();
          $this->logVks($newModel->id, "Добавил запись о предстоящем сеансе ВКС");
        }
        $model->combined = 1;
        $result = $model->save();
      }
      if ($result) {
        Yii::$app->session->setFlash('success', 'Предстоящий сеанс видеосвязи добавлен!');
        return $this->redirect('index');
      } else {
        Yii::$app->session->setFlash('error', 'Что-то не так.');
      }
    }
    return $this->render('create', [
      'model' => $model
    ]);
  }

  public function actionUpdateUpSession($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CREATE;

    if ($model->load(Yii::$app->request->post())) {
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      if ($model->save()) {
        $this->logVks($model->id, "Обновил информацию о предстоящем сеансе ВКС");
        Yii::$app->session->setFlash('success', 'Запись успешно обновлена!');
        return $this->redirect('index');
      } else {
        Yii::$app->session->setFlash('error', 'Что-то не так.');
      }
    }
    return $this->render('update', [
      'model' => $model
    ]);
  }

  public function actionConfirm($id = null)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CONFIRM;
    if ($model->load(Yii::$app->request->post())) {
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "Подтвердил прошедший сеанс ВКС.");
        Yii::$app->session->setFlash('success', 'Запись успешно сохранена и добавлена в архив сеансов ВКС.');
        return $this->redirect('archive');
      } else {
        Yii::$app->session->setFlash('error', 'Что-то не так.');
      }
    }
    return $this->render('confirm', [
      'model' => $model
    ]);
  }

  public function actionCreateSession()
  {
    $model = new VksSessions(['scenario' => VksSessions::SCENARIO_CONFIRM]);
    if ($model->load(Yii::$app->request->post())) {
      $currentTime = new \DateTime();
      $model->vks_record_create = date('Y-m-d H:i:s');
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "Добавил запись о прошедшем сеансе ВКС.");
        Yii::$app->session->setFlash('success', 'Запись успешно сохранена и добавлена в архив сеансов ВКС.');
        return $this->redirect('archive');
      } else {
        Yii::$app->session->setFlash('error', 'Что-то не так');
      }
    }
    return $this->render('create_session', [
      'model' => $model
    ]);
  }

  public function actionUpdateSession($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CONFIRM;
    if ($model->load(Yii::$app->request->post())) {
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "Обновил запись о прошедшем сеансе ВКС.");
        Yii::$app->session->setFlash('success', 'Запись успешно сохранена и добавлена в архив сеансов ВКС.');
        return $this->redirect('archive');
      } else {
        Yii::$app->session->setFlash('error', 'Что-то не так.');
      }
    }
    return $this->render('update_session', [
      'model' => $model
    ]);
  }

  public function actionSubscribersMsk()
  {
    $sql = "SELECT ref as value, surnames as label FROM vks_subscribes_tbl where surnames IS NOT NULL and surnames != '' AND root = 1";
    $arrayOfNames = VksSubscribes::findBySql($sql)->asArray()->all();
    $newArrayOfNames = [];
    $tempArrayOfNames = [];
    $i = 0;
    foreach ($arrayOfNames as $fkey => $name) {
      $i = $i + $fkey;
      $tempArrayOfNames = explode('; ', $name['label']);
      foreach ($tempArrayOfNames as $key => $temp) {
        $i = $i + $key;
        $newArrayOfNames[$i]['value'] = $name['value'];
        $newArrayOfNames[$i]['label'] = $temp;
      }
    }
    return json_encode(array_splice($newArrayOfNames, 0));
  }

  public function actionSubscribersRegion()
  {
    $sql = "SELECT ref as value, surnames as label FROM vks_subscribes_tbl where surnames IS NOT NULL and surnames != '' AND root = 2";
    $arrayOfNames = VksSubscribes::findBySql($sql)->asArray()->all();
    $newArrayOfNames = [];
    $tempArrayOfNames = [];
    $i = 0;
    foreach ($arrayOfNames as $fkey => $name) {
      $i = $i + $fkey;
      $tempArrayOfNames = explode('; ', $name['label']);
      foreach ($tempArrayOfNames as $key => $temp) {
        $i = $i + $key;
        $newArrayOfNames[$i]['value'] = $name['value'];
        $newArrayOfNames[$i]['label'] = $temp;
      }
    }
    return json_encode(array_splice($newArrayOfNames, 0));
  }

  public function actionViewUpSession($id)
  {
    $logs = VksLog::find()->where(['=', 'session_id', $id])->all();
    return $this->render('view_up_session', [
      'model' => $this->findModel($id),
      'logs' => $logs
    ]);
  }

  public function actionViewSession($id)
  {
    $logs = VksLog::find()->where(['=', 'session_id', $id])->all();
    return $this->render('view_session', [
      'model' => $this->findModel($id),
      'logs' => $logs
    ]);
  }

  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $d) {
      $model = $this->findModel($d);
      $report = $model->delete();
    }
    if ($report) {
      return true;
    }
    return false;
  }

  public function actionDeleteSingle($id)
  {
    $model = $this->findModel($id);
    if ($model->delete()) {
      Yii::$app->session->setFlash('success', 'Запись удалена');
      return $this->redirect(['index']);
    }
    Yii::$app->session->setFlash('error', 'Удалить запись не удалось');
    return $this->redirect(['index']);
  }

  public function actionArchive()
  {
    return $this->render('archive');
  }

  public function actionAnalysis()
  {
    return $this->render('analysis');
  }

  protected function findModel($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    if (!empty($model)) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

  protected function logVks($sessionId, $text)
  {
    $userId = Yii::$app->user->identity->ref;
    $log = new VksLog();
    $log->session_id = $sessionId;
    $log->log_text = $text;
    $log->user_id = $userId;
    $log->log_time = date("Y-m-d H:i:s", time());;
    $log->save();
  }

  public function actionVksTypesList()
  {

  }

  public function actionVksPlacesList()
  {

  }

}