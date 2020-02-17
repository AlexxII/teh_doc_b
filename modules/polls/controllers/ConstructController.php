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

class ConstructController extends Controller
{

  public $layout = 'ex_layout.php';

  const POLLS_TABLE = 'poll_main_tbl';
  const QUESTIONS_TABLE = 'poll_questions_tbl';
  const ANSWERS_TABLE = 'poll_answers_tbl';
  const RESPONDENTS_TABLE = 'poll_respondents_tbl';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Редактор анкет';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Rendering',
      ],
      'code' => 1,
    ];

  }

  public function actionGetPollInfo($id)
  {
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

  public function actionHideToFill()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $question = Questions::findModel($id);
      $question->visible = 0;
      if ($question->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $id,
            'message' => 'Hidden successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $question->errors,
          'message' => 'Can`t save',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];
  }

  public function actionRestoreQuestion()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $question = Questions::findModel($id);
      $question->visible = 1;
      if ($question->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $id,
            'message' => 'Hidden successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $question->errors,
          'message' => 'Can`t save',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];
  }

  public function actionHideAnswer()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $answer = Answers::findModel($id);
      $answer->visible = 0;
      if ($answer->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $id,
            'message' => 'Hidden successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $answer->errors,
          'message' => 'Can`t save',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];
  }

  public function actionRestoreAnswer()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $answer = Answers::findModel($id);
      $answer->visible = 1;
      if ($answer->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $id,
            'message' => 'Restored successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $answer->errors,
          'message' => 'Can`t save',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];
  }

  public function actionUniqueAnswer()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $bool = $_POST['bool'];
      $answer = Answers::findModel($id);
      $answer->unique = $bool;
      if ($answer->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $bool,
            'message' => 'Unique successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $answer->errors,
          'message' => 'Can`t save unique parameter',
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];
  }

  public function actionSetQuestionLimit()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $limit = $_POST['limit'];
      $question = Questions::findModel($id);
      $question->limit = $limit;
      if ($question->save()) {
        return [
          'data' => [
            'success' => true,
            'data' => $limit,
            'message' => 'Limit set successfully',
          ],
          'code' => 1,
        ];
      }
      return [
        'data' => [
          'success' => false,
          'data' => $question->limit,                                                   // значение из БД
          'message' => 'Can`t save limit parameter' + $question->errors,
        ],
        'code' => 0,
      ];
    }
    return [
      'data' => [
        'success' => false,
        'data' => 'Poor',
        'message' => '$_POST - empty',
      ],
      'code' => 0,
    ];

  }

  public function actionReorderQuestions()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    if (!empty($_POST)) {
      $arrayOfIds = $_POST['questions'];
      $transaction = Yii::$app->db->beginTransaction();
      foreach ($arrayOfIds as $key => $id) {
        $question = Questions::findModel($id);
        $question->order = $key + 1;
        if (!$question->save()) {
          $transaction->rollback();
          return [
            'data' => [
              'success' => false,
              'data' => $question->errors,
              'message' => 'Не удалось сохранить очередность. Ошибка - ',
            ],
            'code' => 0,
          ];
        }
      }
      $transaction->commit();
      return [
        'data' => [
          'success' => true,
          'data' => 'Good work',
          'message' => 'Limit set successfully',
        ],
        'code' => 1,
      ];
    }
  }

}