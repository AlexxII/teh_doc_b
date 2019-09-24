<?php

namespace app\assets\fullcalendar;

use yii\web\AssetBundle;

class CalendarDaygridAsset extends AssetBundle
{
//  public $sourcePath = '@bower/fullcalendar/dist/daygrid';
  public $sourcePath = '@bower/fullcalendar/packages/daygrid/src';

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
