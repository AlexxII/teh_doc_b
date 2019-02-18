<?php

namespace app\modules\tehdoc\modules\equipment\controllers\controlPanel;

use yii\web\Controller;

class Control extends Controller
{

  public $layout = '@app/modules/tehdoc/modules/equipment/views/layouts/equipment_layout_control.php';

  public function actionIndex()
  {
    return $this->render('header');
  }
}