<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarCoreAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/core';
  public $sourcePath = '@bower/fullcalendar/packages/core/src';

  public $css = [
    'main.scss',
  ];

  public $js = [
    'main.ts',
    'locales/ru.js'
  ];

  public $depends = [
    'yii\jui\JuiAsset'
  ];


}
