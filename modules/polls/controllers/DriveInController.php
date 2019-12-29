<?php

namespace app\modules\polls\controllers;

use app\modules\polls\models\Answers;
use app\modules\polls\models\Questions;
use app\modules\polls\models\Xml;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use XMLReader;

use app\modules\polls\models\Polls;
use app\modules\polls\models\XmlFile;

class DriveInController extends Controller
{

  public $layout = 'ex_layout.php';

  const POLLS_TABLE = 'poll_main_tbl';
  const QUESTIONS_TABLE = 'poll_questions_tbl';
  const ANSWERS_TABLE = 'poll_answers_tbl';
  const RESPONDENTS_TABLE = 'poll_respondents_tbl';

/*  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $pollTable = self::POLLS_TABLE;
    $sql = "SELECT {$pollTable}.id, {$pollTable}.start_date, {$pollTable}.end_date, {$pollTable}.title, 
        {$pollTable}.code, {$pollTable}.sample, YEAR({$pollTable}.start_date) as year FROM {$pollTable}";
    $data["data"] = Polls::findBySql($sql)->asArray()->all();
    return $data;
  }*/


  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Опрос';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Rendering',
      ],
      'code' => 1,
    ];

  }

  public function actionGetPollInfo($id) {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $data = Polls::find()
      ->select(["id", "title", "code"])
      ->where(["id" => $id])
      ->with(['questions.answers'])
      ->asArray()
      ->all();
    return [
      'data' => [
        'success' => true,
        'data' => $data,
        'message' => 'Poll info - take it',
      ],
      'code' => 1,
    ];

  }

}