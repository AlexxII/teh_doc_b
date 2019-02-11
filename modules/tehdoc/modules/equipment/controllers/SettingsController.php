<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\tehdoc\modules\equipment\models\ComplexEx;

class SettingsController extends Controller
{

  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    return $this->render('header', [
      'model' => $this->findModel($id),
    ]);
  }

  /*  public function actionIndex()
    {
      if (!empty($_POST)) {
        $id = $_POST['id'];
        return $this->render('index', [
          'model' => $this->findModel($id),
        ]);
      }
      return false;
    }*/

  protected function findModel($id)
  {
    if (($model = ComplexEx::find()->where(['ref' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

}