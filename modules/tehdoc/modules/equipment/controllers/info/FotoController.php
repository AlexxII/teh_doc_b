<?php

namespace app\modules\tehdoc\modules\equipment\controllers\info;

use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FotoController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_ex.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    if ($id != 1122334455) {
      $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
      $model = $request[0];
      $wiki = $model->countWikiPages;
      $files = $model->countFiles;
      return $this->render('header', [
        'wiki' => $wiki,
        'files' => $files
      ]);
    }
  }

  public function actionIndexEx()
  {
    $this->layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';
    $id = $_GET['id'];
    if ($id != 1122334455) {
      $request = Tools::find()->where(['ref' => $id])->limit(1)->all();
      $model = $request[0];
      $wiki = $model->countWikiPages;
      $files = $model->countFiles;
      return $this->render('header', [
        'wiki' => $wiki,
        'files' => $files
      ]);
    }
  }
}