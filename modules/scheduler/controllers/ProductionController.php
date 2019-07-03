<?php

namespace app\modules\scheduler\controllers;

use Yii;
use yii\web\Controller;

class ProductionController extends Controller
{

  public $layout = 'scheduler_layout_exx.php';

  public function actionIndex(){

    return $this->render('index');
  }

}