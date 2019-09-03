<?php

namespace app\modules\to\assets;

use yii\web\AssetBundle;

class ToAsset extends AssetBundle
{

  public $sourcePath = '@app/modules/to/lib';

  public $css = [
  ];

  public $js = [
    'js/bootstrap-datepicker.min.js',
    'js/bootstrap-datepicker.ru.min.js',
  ];

}
