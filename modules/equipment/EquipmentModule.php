<?php

namespace app\modules\equipment;

use yii\filters\AccessControl;

class EquipmentModule extends \yii\base\Module
{
//    public $defaultRoute = '/tools';

  public $layout = '@app/views/layouts/main.php';

  public function init()
  {
    \Yii::$app->view->title = 'Техника';
    parent::init();
  }

}