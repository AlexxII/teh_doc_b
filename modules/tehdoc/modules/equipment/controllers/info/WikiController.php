<?php

namespace app\modules\tehdoc\modules\equipment\controllers\info;

use app\modules\tehdoc\modules\equipment\models\ComplexEx;
use app\modules\tehdoc\modules\equipment\models\Wiki;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WikiController extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    $model = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_title')->limit(1)->all();
    $list = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_title')->asArray()->all();
    if (!empty($model)) {
      $indexModel = $model[0];
      return $this->render('header', [
        'model' => $indexModel,
        'list' => $list
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
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_title')->asArray()->all();
        return $this->render('header', [
          'model' => $model,
          'list' => $list
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
        $id = $_GET['id'];
        $list = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_title')->asArray()->all();
        return $this->render('header', [
          'model' => $model,
          'list' => $list
        ]);
      }
    }
    return $this->render('update', [
      'model' => $model
    ]);
  }

  public function actionView($page)
  {
    if ($page){
      $id = $_GET['id'];
      $wikiPage = Wiki::findOne($page);
      $list = Wiki::find()->where(['eq_ref' => $id])->orderBy('wiki_title')->asArray()->all();
      return $this->render('header', [
        'model' => $wikiPage,
        'list' => $list
      ]);
    }
    return false;
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