<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FilesController extends Controller
{
  public $defaultAction = 'index';
  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    if ($_GET['id'] != 1122334455){
      return $this->render('header');
    }
  }
}