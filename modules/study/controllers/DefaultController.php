<?php

namespace app\modules\study\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
  public $layout = 'study_layout.php';

  public function actionIndex()
  {
    return $this->render('index');
  }

}