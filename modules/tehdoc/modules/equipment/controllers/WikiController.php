<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\modules\equipment\models\Wiki;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WikiController extends Controller
{
  public function actionIndex()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      return $this->renderPartial('index', [
        'model' => $this->findModel($id),
      ]);
    }
    return false;
  }

  protected function findModel($id)
  {
    if (($model = Wiki::find()->where(['eq_ref' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

}