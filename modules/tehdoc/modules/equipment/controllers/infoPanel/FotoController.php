<?php

namespace app\modules\tehdoc\modules\equipment\controllers\infoPanel;

use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FotoController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_info.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    if ($id != 1122334455) {
      $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
      $model = $request[0];
      $photos = $model->images;
      $wikiCount = $model->countWikiPages;
      $imagesCount = $model->countImages;
      $docsCount = $model->countDocs;
      return $this->render('header', [
        'photos' => $photos,
        'docsCount' => $docsCount,
        'imagesCount' => $imagesCount,
        'wikiCount' => $wikiCount,
      ]);
    }
  }

}