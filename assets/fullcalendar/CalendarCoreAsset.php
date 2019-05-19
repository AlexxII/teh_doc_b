<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarCoreAsset extends AssetBundle
{
  public $sourcePath = '@bower/fullcalendar/dist/core';

  public $css = [
    'main.min.css',
  ];

  public $js = [
    'main.min.js',
    'locales/ru.js'
  ];

  public $depends = [
    'yii\jui\JuiAsset'
  ];


}
