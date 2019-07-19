<?php

namespace app\modules\tehdoc;

use yii\filters\AccessControl;

class TehdocModule extends \yii\base\Module
{

  public $layout = 'tehdoc_layout.php';

//  public $defaultRoute = '/equipment';

  public function init()
  {
    parent::init();
    // подключение дочернего модуля
    $this->modules = [
        'to' => [
            'class' => 'app\modules\tehdoc\modules\to\ToModule',
        ],
    ];
  }

}