<?php

namespace app\modules\vks\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

use app\modules\admin\models\User;
use app\modules\vks\models\VksLog;
use app\modules\vks\models\SSP;
use app\modules\vks\models\VksPlaces;
use app\modules\vks\models\VksSessions;
use app\modules\vks\models\VksSubscribes;
use app\modules\vks\models\VksTypes;


class SessionsController extends Controller
{
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::class,
        'rules' => [
          [
            'allow' => true,
            'actions' => ['sessions-ex', 'archive-ex', 'delete-completely', 'delete-single-completely'],
            'roles' => ['superAdmin']      // доступ только с ролью superAdmin
          ],[
            'allow' => false,
            'actions' => ['sessions-ex', 'delete-completely', 'delete-single-completely'],
            'roles' => ['@', "?"]
          ],
          [
            'allow' => true,
            'roles' => ['@']
          ]
        ],
      ],
    ];
  }

  public function actionServerSide($index)
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
      array('db' => 'important', 'dt' => 10)
    );
    $sql_details = \Yii::$app->params['sql_details'];
    if (empty($index)){
      $index = 0;
    }

    if (!empty($_GET['stDate'])){
      $startDate = $_GET['stDate'];
    } else {
      $startDate = "1970-01-01";
    }
    if (!empty($_GET['eDate'])){
      $endDate = $_GET['eDate'];
    } else {
      $endDate = "2099-12-31";
    }


//    $where = 'vks_upcoming_session = 1 AND vks_cancel = ' . $index;
    $where = ' ' . $table . '.vks_upcoming_session = 1 AND Date(vks_date) >= "' . $startDate . '" AND Date(vks_date) <= "' . $endDate . '" AND vks_cancel = ' . $index;

    return json_encode(
      SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
    );
  }

  public function actionServerSideEx($index)
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
      array('db' => 'vks_duration_work', 'dt' => 20),
      array('db' => 'vks_subscriber_reg_office_text', 'dt' => 21),
      array('db' => 'vks_subscriber_reg_name', 'dt' => 22)
    );
    $sql_details = \Yii::$app->params['sql_details'];

    if (empty($index)){
      $index = 0;
    }

    $where = 'vks_upcoming_session = 0 AND vks_cancel = '. $index;

    return json_encode(
      SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, NULL, $where)
    );
  }

  public function actionCreateUpSessionAjax($vks_date = null)
  {
    $model = new VksSessions(['scenario' => VksSessions::SCENARIO_CREATE]);
    if ($vks_date) {
      $model->vks_date = $vks_date;
    }
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $date = date('Y-m-d H:i:s');
      $model->vks_record_create = $date;
      $model->vks_record_update = $date;
      $model->vks_upcoming_session = 1;
      $userId = Yii::$app->user->identity->id;
      $user = User::findOne($userId);
      $model->vks_employee_receive_msg = $user->username;
      $result = $model->save();                                                             // TODO нет проверки на ошибки!
      $this->logVks($model->id, "info", "Добавил запись о предстоящем сеансе ВКС");
      if (!empty($_POST['test-type'])) {
        foreach ($_POST['test-type'] as $key => $item) {
          $newModel = new VksSessions(['scenario' => VksSessions::SCENARIO_CREATE]);
          $newModel->load(Yii::$app->request->post());
          $newModel->vks_type = $item;
          $typeModel = VksTypes::findModel($item);
          $newModel->vks_type_text = $typeModel->name;
          if (!empty($_POST['test-place'][$key])) {
            $placeId = $_POST['test-place'][$key];
            $newModel->vks_place = $placeId;
            $placeModel = VksPlaces::findModel($placeId);
            $newModel->vks_place_text = $placeModel->name;
          }
          $newModel->vks_record_create = $date;
          $newModel->vks_record_update = $date;
          $newModel->vks_upcoming_session = 1;
          $newModel->vks_employee_receive_msg = $user->username;
          $newModel->important = 1;
          $result = $newModel->save();
          $this->logVks($newModel->id, "info","Добавил запись о предстоящем сеансе ВКС");
        }
        $model->important = 1;
        $result = $model->save();
      }
      if ($result) {
        return [
          'data' => [
            'success' => true,
            'data' => 'model save',
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $model->errors,
            'message' => 'Page load',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_ajax', [
      'model' => $model
    ]);
  }

  public function actionUpdateUpSessionAjax($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CREATE;

    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      if ($model->save()) {
        $this->logVks($model->id, "info","Обновил информацию о предстоящем сеансе ВКС");
        return [
          'data' => [
            'success' => true,
            'data' => 'Model save',
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $model->errors,
            'message' => 'Page load',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_ajax', [
      'model' => $model
    ]);
  }

  public function actionConfirmAjax($id = null)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CONFIRM;
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "info", "Подтвердил прошедший сеанс ВКС.");
        return [
          'data' => [
            'success' => true,
            'data' => 'Model save',
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $model->errors,
            'message' => 'Page load',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_confirm_ajax', [
      'model' => $model
    ]);
  }

  public function actionCreateSessionAjax()
  {
    $model = new VksSessions(['scenario' => VksSessions::SCENARIO_CONFIRM]);
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $currentTime = new \DateTime();
      $model->vks_record_create = date('Y-m-d H:i:s');
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "info", "Добавил запись о прошедшем сеансе ВКС.");
        return [
          'data' => [
            'success' => true,
            'data' => 'Model save',
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $model->getErrors(),
            'message' => 'Page load',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_confirm_ajax', [
      'model' => $model
    ]);
  }

  public function actionUpdateSessionAjax($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    $model->scenario = VksSessions::SCENARIO_CONFIRM;
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $currentTime = new \DateTime();
      $model->vks_record_update = $currentTime->format('Y-m-d H:i:s');
      $model->vks_upcoming_session = 0;
      if ($model->save()) {
        $this->logVks($model->id, "info","Обновил запись о прошедшем сеансе ВКС.");
        return [
          'data' => [
            'success' => true,
            'data' => 'Model save',
            'message' => 'Page load',
          ],
          'code' => 1,
        ];
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $model->errors,
            'message' => 'Page load',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_confirm_ajax', [
      'model' => $model
    ]);
  }

  public function actionSubscribersMsk()
  {
    $sql = "SELECT id as value, surnames as label 
              FROM vks_subscribes_tbl where surnames IS NOT NULL and surnames != '' AND list = 1";
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
    $sql = "SELECT id as value, surnames as label 
              FROM vks_subscribes_tbl where surnames IS NOT NULL and surnames != '' AND list = 2";
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

  public function actionViewUpSessionAjax($id)
  {
    $logs = VksLog::find()->where(['=', 'session_id', $id])->orderBy('log_time')->all();
    return $this->renderAjax('view_up_session', [
      'model' => $this->findModel($id),
      'logs' => $logs
    ]);
  }

  public function actionViewSessionAjax($id)
  {
    $logs = VksLog::find()->where(['=', 'session_id', $id])->orderBy('log_time')->all();
    return $this->renderAjax('view_session', [
      'model' => $this->findModel($id),
      'logs' => $logs
    ]);
  }

  public function actionArchive()
  {
    $this->layout = '@app/views/layouts/main_ex.php';

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Архив';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('archive'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }

  // на удалении выставляется флаг vks_cancel
  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $d) {
      $model = $this->findModel($d);
      $this->logVks($model->id, "danger", " Удалил запись о сеансе ВКС.");
      $model->vks_cancel = 1;
      $report = $model->save();
    }
    if ($report) {
      return true;
    }
    return false;
  }

  public function actionDeleteSingle()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = $this->findModel($id);
      $model->vks_cancel = 1;
      if ($model->save()) {
        $this->logVks($model->id, "danger", " Удалил запись о сеансе ВКС.");
        return true;
      }
      return false;
    }
    return false;
  }

  protected function findModel($id)
  {
    $model = VksSessions::findOne(['id' => $id]);
    if (!empty($model)) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

  protected function logVks($sessionId, $status, $text)
  {
    $userId = Yii::$app->user->identity->id;
    $log = new VksLog();
    $log->status = $status;
    $log->session_id = $sessionId;
    $log->log_text = $text;
    $log->user_id = $userId;
    $log->log_time = date("Y-m-d H:i:s", time());;
    $log->save();
  }

}
