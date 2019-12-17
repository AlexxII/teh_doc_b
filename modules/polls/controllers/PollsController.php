<?php

namespace app\modules\polls\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use XMLReader;

use app\modules\polls\models\Polls;
use app\modules\polls\models\XmlFile;

class PollsController extends Controller
{

  const POLLS_TABLE = 'poll_main_tbl';
  const QUESTIONS_TABLE = 'poll_questions_tbl';
  const ANSWERS_TABLE = 'poll_answers_tbl';
  const RESPONDENTS_TABLE = 'poll_respondents_tbl';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $pollTable = self::POLLS_TABLE;
    $sql = "SELECT {$pollTable}.id, {$pollTable}.start_date, {$pollTable}.end_date, {$pollTable}.title, 
        {$pollTable}.code, {$pollTable}.sample, YEAR({$pollTable}.start_date) as year FROM {$pollTable}";
    $data["data"] = Polls::findBySql($sql)->asArray()->all();
    return $data;
  }

  public function actionAddNewPoll()
  {
    $model = new Polls();
    $xml = new XmlFile();
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      $userId = Yii::$app->user->identity->id;
      $model->created_user = $userId;
      $currentTime = new \DateTime();
      $model->poll_record_create = date('Y-m-d H:i:s');
      $model->poll_record_update = $currentTime->format('Y-m-d H:i:s');

      $xml->xmlFile = UploadedFile::getInstances($xml, 'xmlFile');
      $name = $model->code . "_" . $model->id . ".xml";
      $xml->upload($name);
      $result = false;
      if ($result = $xml->upload($name)) {
        $result = $xml->parseAndLoadToDb();
        return $result;
      } else {
        return [
          'data' => [
            'success' => false,
            'data' => $result,
            'message' => 'Could`t save and parse config xml file. Check access rights to upload dir (@app/web/upload/polls/xml/) 
              or file extension',
          ],
          'code' => 1,
        ];
      }
      if ($model->save()) {
//        Polls::log($model->id, "info", "Добавил новый опрос.");
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
            'message' => 'Could`t save poll model',
          ],
          'code' => 0,
        ];
      }
    }
    return $this->renderAjax('_form_create_poll', [
      'model' => $model,
      'xml' => $xml
    ]);
  }

  public function actionSavePoll()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

      $postData = Yii::$app->request->post("formData");
      return $postData;
      $model = new Polls();
      $userId = Yii::$app->user->identity->id;
      $model->created_user = $userId;
      $model->title = $postData['Polls[title]'];
      $model->start_date = $postData['Polls[start_date]'];
      $model->end_date = $postData['Polls[end_date]'];
      $model->code = $postData['Polls[code]'];
      $model->sample = $postData['Polls[sample]'];
      $model->elections = $postData['Polls[elections]'];
      return $model;
      $currentTime = new \DateTime();
      $model->poll_record_create = date("Y-m-d H:i:s");
      $model->poll_record_update = $currentTime->format("Y-m-d H:i:s");
      return [
        'data' => [
          'success' => true,
          'data' => 'Poll saved',
          'message' => 'Poll saved',
        ],
        'code' => 1,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Is not ajax',
        'message' => 'An error occured',
      ],
      'code' => 0,
    ];
  }

  public function actionUpdatePoll($id)
  {
    $model = Polls::findOne(['id' => $id]);

    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $currentTime = new \DateTime();
      $model->poll_record_update = $currentTime->format('Y-m-d H:i:s');
      if ($model->save()) {
//        $this->logVks($model->id, "info","Обновил информацию о предстоящем сеансе ВКС");
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
    return $this->renderAjax('_form_create_poll', [
      'model' => $model,
      'xml' => new XmlFile()
    ]);
  }

  public function actionViewPoll($id)
  {
//    $logs = VksLog::find()->where(['=', 'session_id', $id])->orderBy('log_time')->all();
    return $this->renderAjax('view_poll', [
      'model' => Polls::findModel($id)
    ]);
  }

  public function actionDelete()
  {
    $report = true;
    foreach ($_POST['jsonData'] as $pollId) {
      $models = Polls::findOne($pollId);
      foreach ($models as $m) {
        $result = $m->delete();
      }
    }
    if ($report) {
      return true;
    }
    return false;
  }

  public function actionIndexEx()
  {
    $pollTable = self::POLLS_TABLE;
    $usersTable = self::ADMINS_TABLE;
    $toTable = self::TOTYPE_TABLE;
    $sql = "SELECT {$pollTable}.id, {$pollTable}.plan_date, {$pollTable}.schedule_id,
              GROUP_CONCAT(DISTINCT {$pollTable}.checkmark ORDER BY {$pollTable}.checkmark ASC SEPARATOR ', ') as checkmark,
              GROUP_CONCAT(DISTINCT t1.name ORDER BY t1.name ASC SEPARATOR ',<br> ') as admins,
              GROUP_CONCAT(DISTINCT t2.name ORDER BY t2.name ASC SEPARATOR ',<br> ') as auditors,
              GROUP_CONCAT(DISTINCT t3.name ORDER BY t3.name ASC SEPARATOR ',<br> ') as to_type
            from {$pollTable}
              LEFT JOIN {$usersTable} as t1 on {$pollTable}.admin_id = t1.id
              LEFT JOIN {$usersTable} as t2 on {$pollTable}.auditor_id = t2.id
              LEFT JOIN {$toTable} as t3 on {$pollTable}.to_type = t3.id
            GROUP BY schedule_id";

    return $this->render('index', [
      'tos' => ToSchedule::findBySql($sql)->asArray()->all(),
      'month' => 1
    ]);
  }

}