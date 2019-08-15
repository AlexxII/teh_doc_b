<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class ProductionController extends Controller
{

  public $layout = '@app/views/layouts/main_ex.php';

  public function actionIndex(){
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    Yii::$app->view->params['title'] = 'Производственный календарь';
    Yii::$app->view->params['bUrl'] = $_GET['back-url'];
    return [
      'data' => [
        'success' => true,
        'data' => $this->render('index'),
        'message' => 'Page load.',
      ],
      'code' => 1,
    ];
  }


}