<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
  public function actionIndex($id)
  {
    return $this->render('index', [
      'a' => $id
    ]);
  }


}