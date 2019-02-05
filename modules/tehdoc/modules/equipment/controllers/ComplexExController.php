<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\base\ModelEx;
use app\modules\tehdoc\models\Images;
use app\modules\tehdoc\modules\equipment\models\Complex;
use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use app\modules\tehdoc\modules\equipment\models\SSP;
use app\modules\tehdoc\modules\equipment\models\Tools;
use yii\base\DynamicModel;
use yii\web\Controller;
use Yii;
use app\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class ComplexExController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index');
  }

}