<?php

namespace app\assets;

use yii\web\AssetBundle;

class NotyAsset extends AssetBundle

// напоминалка !!!!

{
  public $sourcePath = '@bower/noty';

  public $css = [
    'lib/noty.css',
    'src/themes/metroui.scss'
  ];

  public $js = [
    'lib/noty.min.js',
  ];

}
