<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarTimegridAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/timegrid';
  public $sourcePath = '@bower/fullcalendar/packages/timegrid/src';

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
