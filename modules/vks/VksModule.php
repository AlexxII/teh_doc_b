<?php

namespace app\modules\vks;

use yii\filters\AccessControl;

class VksModule extends \yii\base\Module
{

  public $layout = '@app/views/layouts/main.php';
//  public $layout = 'vks_layout.php';
//  public $defaultRoute = '/sessions';

  public function init()
  {
    \Yii::$app->view->title = 'Журнал ВКС';
    parent::init();
  }
}