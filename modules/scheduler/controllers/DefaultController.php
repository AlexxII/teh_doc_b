<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{


  public function actionIndex()
  {
    $this->layout = 'scheduler_layout_ex.php';
    return $this->render('index');
  }

  public function actionEdit()
  {
    return $this->render('edit');
  }


}