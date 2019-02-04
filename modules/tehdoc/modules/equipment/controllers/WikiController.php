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

      $model = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_record_create')->limit(1)->all();
      if (!empty($model)) {
        $indexModel = $model[0];
      }
      return $this->renderPartial('index', [
        'model' => $indexModel,
        false,
        true
      ]);
    }
    return false;
  }

  public function actionUpdate()
  {
    if (!empty($_POST)) {
      $id = $_POST['id'];
      $model = $this->findModel($id);
      return $this->renderPartial('update', [
        'model' => $model, false, true
      ]);
    }
  }

  protected function findModel($id)
  {
    // TODO не ососбо правильный метод поиска

    if (($model = Wiki::find()->where(['id' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

}