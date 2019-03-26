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
      if (!empty($_GET['year'])){
        $year = $_GET['year'];
        $docModels = $model->docsYearFilter($year);
      } else {
        $docModels = $model->docs;
      }
      $yearArray = $model->yearArrayDocs;
      $wikiCount = $model->countWikiPages;
      $imagesCount = $model->countImages;
      $docsCount = $model->countDocs;
      return $this->render('header', [
        'docModels' => $docModels,
        'years' => $yearArray,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount
      ]);
    }
    return false;
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
      $year = strftime("%G", strtotime($docModel->doc_date));
      $model->year = $year;
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
      'wikiCount' => $wikiCount
    ]);
  }



}
