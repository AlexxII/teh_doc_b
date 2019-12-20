<?php

namespace app\assets;

use yii\web\AssetBundle;

class SortableJSAsset extends AssetBundle
{
  public $sourcePath = '@bower/sortablejs';

  public $js = [
    'src',
  ];

}
