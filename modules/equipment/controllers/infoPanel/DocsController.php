<?php

namespace app\modules\equipment\controllers\infoPanel;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\modules\equipment\models\Docs;
use app\modules\equipment\models\Tools;


class DocsController extends Controller
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $id = $_GET['id'];
    if ($id != 1122334455) {
      $model = Tools::findModel($id);
      $docModels = $model->docsOrder;
      $yearArray = $model->yearArrayDocs;
      return $this->renderAjax('index', [
        'docModels' => $docModels,
        'years' => $yearArray
      ]);
    }
    return false;
  }

  public function actionCreate()
  {
    $toolId = $_GET['id'];
    $model = Tools::findModel($toolId);
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
      return $this->redirect(['tool/' . $toolId . '/docs/index']);
    }
    return $this->render('create', [
      'model' => $docModel,
      'docsCount' => $docsCount,
      'imagesCount' => $imagesCount,
      'wikiCount' => $wikiCount
    ]);
  }

  public function actionCreateAjax()
  {
    $toolId = $_GET['id'];
    $model = Tools::findModel($toolId);
    $docModel = new Docs();
    if ($docModel->load(Yii::$app->request->post())) {
      $docModel->docFiles = UploadedFile::getInstances($docModel, 'docFiles');
      $model = $docModel->uploadDoc($docModel, $toolId);
      $year = strftime("%G", strtotime($docModel->doc_date));
      $model->year = $year;
      $model->doc_date = $docModel->doc_date;
      $model->save();
      if ($model) {
        return true;
      } else {
        return $model->errors;
      }
//      $docModel = new Docs();
//      return $this->redirect(['tool/' . $toolId . '/docs/index']);
    }
    return $this->renderAjax('_form', [
      'model' => $docModel
    ]);
  }

  public function actionDeleteDocs()
  {
    if (!empty($_POST['docsArray'])){
      $counter = 0;
      foreach ($_POST['docsArray'] as $docId){
        $doc = Docs::findModel($docId);
        $fileName = Yii::$app->params['uploadDocs'] . $doc->doc_path;
        if (is_file($fileName)) {
          if (unlink($fileName)) {
            $doc->delete();
            $counter++;
            continue;
          }
        }
        $doc->delete();
        $counter++;
      }
      return $counter;
    }
    return false;
  }

}
