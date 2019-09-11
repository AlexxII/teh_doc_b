<?php

namespace app\modules\opros\controllers;

use Yii;
use yii\web\Controller;

class AnaliticController extends Controller
{

  public function actionIndex()
  {
    return $this->render('index');
  }

}