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
      $docModel = new Docs();
      $wikiCount = $model->countWikiPages;
      $imagesCount = $model->countImages;
      $docsCount = $model->countDocs;
      return $this->render('header', [
        'docModel' => $docModel,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount,
      ]);
    }
  }

  public function actionAddNew()
  {
    $docModel = new Docs();

    if ($docModel->load(Yii::$app->request->post())) {
      $docModel->docFiles = UploadedFile::getInstances($docModel, 'docFiles');
      $docModel->save();
      return true;
    }
    return false;
  }
}