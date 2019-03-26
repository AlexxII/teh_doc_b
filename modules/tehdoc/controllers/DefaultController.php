<?php

namespace app\modules\tehdoc\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }


}