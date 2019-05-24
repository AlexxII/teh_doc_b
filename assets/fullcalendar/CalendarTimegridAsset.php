<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarTimegridAsset extends AssetBundle
{
  public $sourcePath = '@bower/fullcalendar/dist/timegrid';

  public $css = [
    'main.min.css',
  ];

  public $js = [
    'main.min.js'
  ];

  public $depends = [
    'app\assets\fullcalendar\CalendarCoreAsset'
  ];
}
