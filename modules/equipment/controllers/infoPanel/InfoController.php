<?php

namespace app\modules\equipment\controllers\infoPanel;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\modules\equipment\models\Tools;
use app\modules\equipment\models\Images;


class InfoController extends Controller
{

  public function actionIndex()
  {
    if (!empty($_GET['id'])) {
      $id = $_GET['id'];
      $model = Tools::findModel($id);
      $children = $model->children(1)->all();
      if ($model->complex) {
        $view = 'view_complex';
      } else {
        $view = 'view_single';
      }
      return $this->renderAjax('index', [
        'model' => $model,
        'view' => $view,
        'children' => $children,
      ]);
    }
    return $this->render('meeting');
  }

  public function actionUpdate()
  {
    $id = $_GET['id'];
    $tool = Tools::findModel($id);
    $fUpload = new Images();
    $tool->scenario = Tools::SCENARIO_UPDATE;
    if ($tool->load(Yii::$app->request->post())) {
      if ($tool->save()) {
        return $this->redirect(['control-panel/' . $tool->id . '/info/index']);
      } else {
        Yii::$app->session->setFlash('error', 'Изменения НЕ внесены');
      }
    }
    return $this->renderAjax('_form', [
      'model' => $tool,
      'fUpload' => $fUpload
    ]);
  }


  public function actionCounters()
  {
    if (!empty($_GET['id'])) {
      $result = [];
      $id = $_GET['id'];
      $model = Tools::findModel($id);
      $result['docsCount'] = $model->countDocs;
      $result['fotoCount'] = $model->countImages;
      $result['wikiCount'] = $model->countWikiPages;
      return json_encode($result);
    }
    return json_encode(false);
  }

}