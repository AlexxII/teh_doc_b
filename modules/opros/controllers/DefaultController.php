<?php

namespace app\modules\opros\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{

  public function actionIndex()
  {
    return $this->render('default');
  }

  public function actionExtended()
  {
    return $this->render('extended');
  }

}