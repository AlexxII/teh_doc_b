<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarInteractionAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/interaction';
  public $sourcePath = '@bower/fullcalendar/packages/interaction/src';


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
