<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class FullYearController extends Controller
{
  public function actionIndex(){

    return $this->render('index');
  }
}