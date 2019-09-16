<?php

namespace app\modules\opros\asset;

use yii\web\AssetBundle;

class OprosAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/opros/lib';

  public $css = [
    'css/opros_style.css',
  ];

  public $js = [
  ];

  public $depends = [
  ];

}
