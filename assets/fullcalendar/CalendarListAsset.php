<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarListAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/list';
  public $sourcePath = '@bower/fullcalendar/packages/list/src';

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
