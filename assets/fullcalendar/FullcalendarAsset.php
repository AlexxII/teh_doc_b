<?php

namespace app\assets\FullCalendar;

use yii\web\AssetBundle;

class CalendarCoreAsset extends AssetBundle
{
  public $sourcePath = '@bower/fullcalendar';

  public $css = [
    'dist/css/datepicker.min.css',
  ];

  public $js = [
    'dist/js/datepicker.min.js',
  ];

}
