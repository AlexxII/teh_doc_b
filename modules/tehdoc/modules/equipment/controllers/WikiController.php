<?php

namespace app\modules\tehdoc\modules\equipment\controllers;

use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use app\modules\tehdoc\modules\equipment\models\Wiki;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WikiController extends Controller
{
  public function actionIndex()
  {
    $id = $_GET['id'];
    $model = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_record_create')->limit(1)->all();
    if (!empty($model)) {
      $indexModel = $model[0];
      return $this->render('index', [
        'model' => $indexModel,
      ]);
    }
    return $this->render('_index');
  }

  public function actionCreate()
  {
    $model = new Wiki();
    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $model->eq_ref = $_GET['id'];
      $model->wiki_record_create = $date;
      $model->wiki_record_update = $date;
      $model->wiki_created_user = Yii::$app->user->identity->ref;
      if ($model->save()) {
        return $this->render('index', [
          'model' => $model
        ]);
      }
    }
    return $this->render('create', [
      'model' => $model
    ]);
  }

  public function actionUpdate($page)
  {
    $model = $this->findModel($page);
    if ($model->load(Yii::$app->request->post())) {
      $date = date('Y-m-d H:i:s');
      $model->wiki_record_update = $date;
      if ($model->save()) {
        return $this->render('index', [
          'model' => $model
        ]);
      }
    }
    return $this->render('update', [
      'model' => $model
    ]);
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