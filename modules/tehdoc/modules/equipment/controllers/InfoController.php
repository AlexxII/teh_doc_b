<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class InfoController extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';
  public $defaultAction = 'index';

  public function actionIndex()
  {

//    $this->layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';

    $id = $_GET['id'];
    $request = ComplexEx::find()->where(['ref' => $id])->limit(1)->all();
    $model = $request[0];
    return $this->render('header', [
      'model' => $model
    ]);
  }
}