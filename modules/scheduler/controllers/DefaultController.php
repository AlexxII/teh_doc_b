<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

  public function actionEdit()
  {
    return $this->render('edit');
  }

  public function actionEventsList()
  {
    $data = $_POST['p'];
    return json_encode($data);
  }

}