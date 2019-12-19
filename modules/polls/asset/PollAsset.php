<?php

namespace app\modules\polls\asset;

use yii\web\AssetBundle;

class PollAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/polls/lib';

  public $css = [
    'css/poll_style.css',
  ];

  public $js = [
    'js/poll.js',
    'js/drive.js'
  ];

  public $depends = [
  ];

}
