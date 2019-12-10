<?php

namespace app\modules\polls\controllers;

use Yii;
use yii\web\Controller;

use app\modules\polls\models\Polls;

class PollsController extends Controller
{

  const POLLS_TABLE = 'poll_main_tbl';
  const QUESTIONS_TABLE = 'poll_questions_tbl';
  const ANSWERS_TABLE = 'poll_answers_tbl';
  const RESPONDENTS_TABLE = 'poll_respondents_tbl';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $schTable = self::POLLS_TABLE;
    $sql = "SELECT * FROM {$schTable}";
    $data["data"] = Polls::findBySql($sql)->asArray()->all();
    return $data;
  }

  public function actionAddNewPoll()
  {
    $model = new Polls();
    if ($model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $userId = Yii::$app->user->identity->id;
      $model->created_user = $userId;
      $currentTime = new \DateTime();
      $model->poll_record_create = date('Y-m-d H:i:s');
      $model->poll_record_update = $currentTime->format('Y-m-d H:i:s');
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
    return $this->renderAjax('_form_create_poll', [
      'model' => $model
    ]);

  }

  public function actionIndexEx()
  {

    $schTable = self::POLLS_TABLE;
    $usersTable = self::ADMINS_TABLE;
    $toTable = self::TOTYPE_TABLE;
    $sql = "SELECT {$schTable}.id, {$schTable}.plan_date, {$schTable}.schedule_id,
              GROUP_CONCAT(DISTINCT {$schTable}.checkmark ORDER BY {$schTable}.checkmark ASC SEPARATOR ', ') as checkmark,
              GROUP_CONCAT(DISTINCT t1.name ORDER BY t1.name ASC SEPARATOR ',<br> ') as admins,
              GROUP_CONCAT(DISTINCT t2.name ORDER BY t2.name ASC SEPARATOR ',<br> ') as auditors,
              GROUP_CONCAT(DISTINCT t3.name ORDER BY t3.name ASC SEPARATOR ',<br> ') as to_type
            from {$schTable}
              LEFT JOIN {$usersTable} as t1 on {$schTable}.admin_id = t1.id
              LEFT JOIN {$usersTable} as t2 on {$schTable}.auditor_id = t2.id
              LEFT JOIN {$toTable} as t3 on {$schTable}.to_type = t3.id
            GROUP BY schedule_id";

    return $this->render('index', [
      'tos' => ToSchedule::findBySql($sql)->asArray()->all(),
      'month' => 1
    ]);
  }

}