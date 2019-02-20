<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\tehdoc\modules\equipment\models\ComplexEx;

class SettingsController extends Controller
{

  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    $model = $this->findModel($id);
    $wiki = $model->countWikiPages;
    $files = $model->countFiles;
    return $this->render('header', [
      'model' => $this->findModel($id),
      'wiki' => $wiki,
      'files' => $files
    ]);
  }

  protected function findModel($id)
  {
    if (($model = Tools::find()->where(['ref' => $id])->limit(1)->all()) !== null) {
      if (!empty($model)) {
        return $model[0];
      }
    }
    throw new NotFoundHttpException('The requested page does not exist.');
  }

}