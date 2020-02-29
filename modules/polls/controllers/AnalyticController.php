<?php

namespace app\modules\polls\controllers;

use Yii;
use yii\web\Controller;

class AnalyticController extends Controller
{

  public $layout = '@app/views/layouts/main_ex.php';

  public function actionIndex()
  {
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['bUrl'] = 'polls';
    Yii::$app->view->params['title'] = 'Статистка';
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Page load',
      ],
      'code' => 1,
    ];
  }

}