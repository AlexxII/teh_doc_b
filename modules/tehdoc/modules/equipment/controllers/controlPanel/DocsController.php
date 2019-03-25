<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use app\modules\tehdoc\modules\equipment\models\Docs;
use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class DocsController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    if ($id != 1122334455) {
      $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
      $model = $request[0];
      $docModels = $model->docs;

      $yearArray = $model->yearArrayDocs;
      $monthArray = $model->monthsArrayDocs;

      $wikiCount = $model->countWikiPages;
      $imagesCount = $model->countImages;
      $docsCount = $model->countDocs;
      return $this->render('header', [
        'docModels' => $docModels,
        'years' => $yearArray,
        'months' => $monthArray,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount,
      ]);
    }
  }

  public function actionCreate()
  {
    $toolId = $_GET['id'];
    $docModel = new Docs();
    $request = Tools::find()->where(['ref' => $toolId])->limit(1)->all();
    $model = $request[0];
    $docModel = new Docs();
    $wikiCount = $model->countWikiPages;
    $imagesCount = $model->countImages;
    $docsCount = $model->countDocs;
    if ($docModel->load(Yii::$app->request->post())) {
      $docModel->docFiles = UploadedFile::getInstances($docModel, 'docFiles');
      $model = $docModel->uploadDoc($docModel, $toolId);
      $model->doc_date = $docModel->doc_date;
      $model->save();
      if ($model) {
        Yii::$app->session->setFlash('success', 'Документ добавлен');
      } else {
        Yii::$app->session->setFlash('error', 'Документ не добавлен');
      }
      $docModel = new Docs();
      return $this->redirect(['control-panel/' . $toolId . '/docs/index']);
    }
    return $this->render('create', [
      'model' => $docModel,
      'docsCount' => $docsCount,
      'imagesCount' => $imagesCount,
      'wikiCount' => $wikiCount,
    ]);
  }



}
