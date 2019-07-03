<?php

namespace app\modules\study\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
//  public $layout = 'study_layout_ex.php';

  public function actionIndex()
  {
    return $this->render('index');
  }

}