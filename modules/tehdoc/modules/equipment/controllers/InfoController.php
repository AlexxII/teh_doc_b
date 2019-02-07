<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class InfoController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $id = $_GET['id'];
    $request = ComplexEx::find()->where(['ref' => $id])->limit(1)->all();
    $model = $request[0];
    return $this->render('index', [
      'model' => $model,
      'key' => $id
    ]);
  }
}