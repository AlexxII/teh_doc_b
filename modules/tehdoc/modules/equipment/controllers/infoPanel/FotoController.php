<?php

namespace app\modules\tehdoc\modules\equipment\controllers\infoPanel;

use app\modules\tehdoc\modules\equipment\models\Images;
use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class FotoController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_info.php';

  public function actionIndex()
  {
    $toolId = $_GET['id'];
    if ($toolId != 1122334455) {
      $model = Tools::findModel($toolId);
      $photoModels = $model->images;

      $wikiCount = $model->countWikiPages;
      $imagesCount = $model->countImages;
      $docsCount = $model->countDocs;

      return $this->render('header', [
        'photoModels' => $photoModels,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount,
      ]);
    }
  }

  public function actionCreate()
  {
    $toolId = $_GET['id'];
    $imageModel = new Images();
    $model = Tools::findModel($toolId);

    $wikiCount = $model->countWikiPages;
    $imagesCount = $model->countImages;
    $docsCount = $model->countDocs;

    if ($imageModel->load(Yii::$app->request->post())) {
      $imageModel->imageFiles = UploadedFile::getInstances($imageModel, 'imageFiles');
      if ($imageModel->uploadImage($toolId)) {
        Yii::$app->session->setFlash('success', 'Изображение добавлено');
      } else {
        Yii::$app->session->setFlash('error', 'Изображение не добавлено');
      }
      $imageModel = new Images();
      return $this->redirect(['tool/' . $toolId . '/foto/index']);
    }
    return $this->render('create', [
      'model' => $imageModel,
      'docsCount' => $docsCount,
      'imagesCount' => $imagesCount,
      'wikiCount' => $wikiCount
    ]);
  }

  public function actionDeletePhotos()
  {
    if (!empty($_POST['photosArray'])){
      $counter = 0;
      foreach ($_POST['photosArray'] as $photoId){
        $photo = $this->findModel($photoId);
        if (unlink(\Yii::$app->params['uploadImg'] . $photo->image_path)){
          $photo->delete();
          $counter++ ;
        }
      }
      return $counter;
    }
    return false;
  }

  protected function findModel($id)
  {
    if (($model = Images::findOne($id)) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }


}