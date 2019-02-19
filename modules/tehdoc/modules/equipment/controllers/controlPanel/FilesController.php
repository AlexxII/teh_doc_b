<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use app\modules\tehdoc\modules\equipment\models\Tools;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FilesController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    $id = $_GET['id'];
    if ($id != 1122334455){
      $model = Tools::findOne($id);
      return $this->render('header');
    }
  }

  public function actionIndexEx()
  {
    $id = $_GET['id'];
    if ($id != 1122334455){
      $model = Tools::findOne($id);
      return $this->render('header');
    }
  }
}