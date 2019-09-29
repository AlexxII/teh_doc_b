<?php

namespace app\modules\equipment\controllers;

use yii\web\Controller;
use Yii;

class ShowController extends Controller
{

  public $layout = '@app/views/layouts/main_ex.php';

  public function actionCategories()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    Yii::$app->view->params['title'] = 'По категориям';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('categories'),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

  public function actionPlacement()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    Yii::$app->view->params['title'] = 'По размещению';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('placements'),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }


}