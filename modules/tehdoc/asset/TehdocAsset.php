<?php

namespace app\modules\tehdoc\asset;

use yii\web\AssetBundle;

class TehdocAsset extends AssetBundle
{

  public $sourcePath = '@app/modules/tehdoc/lib';

  public $css = [
      'css/tehdoc.css',
  ];

  public $depends = [
      'app\assets\TableBaseAsset',
  ];

}
