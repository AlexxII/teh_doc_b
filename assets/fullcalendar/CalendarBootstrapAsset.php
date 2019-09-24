<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarBootstrapAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/bootstrap';
  public $sourcePath = '@bower/fullcalendar/packages/bootstrap/src';


  public $css = [
    'main.scss',
  ];

  public $js = [
    'main.ts'
  ];

  public $depends = [
    'app\assets\fullcalendar\CalendarCoreAsset'
  ];
}
