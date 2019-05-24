<?php

namespace app\modules\scheduler;

class SchedulerModule extends \yii\base\Module
{

  public $defaultRoute = 'scheduler';
  public $layout = 'scheduler_layout.php';

  public function init()
  {
    parent::init();
  }

}