<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FilesController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    if ($_GET['id'] != 1122334455){
      return $this->render('index');
    }
  }
}