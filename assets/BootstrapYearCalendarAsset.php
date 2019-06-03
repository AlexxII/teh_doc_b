<?php

namespace app\assets;

use yii\web\AssetBundle;

class BootstrapYearCalendarAsset extends AssetBundle
{
  public $sourcePath = '@bower/bootstrap-year-calendar';

  public $css = [
    'css/bootstrap-year-calendar.min.css',
  ];

  public $js = [
    'js/bootstrap-year-calendar.min.js',
    'js/languages/bootstrap-year-calendar.ru.js'
  ];

}
