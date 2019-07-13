<?php

namespace app\modules\vks;

use yii\filters\AccessControl;

class VksModule extends \yii\base\Module
{

  public $layout = 'vks_layout_ex.php';

  public $defaultRoute = '/sessions';

  public function init()
  {
    parent::init();
  }
}