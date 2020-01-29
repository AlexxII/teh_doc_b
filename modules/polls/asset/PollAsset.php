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
    'js/vars.js',
    'js/default.js',
    'js/worksheet.class.js',
    'js/respondent.class.js',
    'js/question.class.js',
    'js/user.class.js',
    'js/poll.js',
    'js/drive.js',
    'js/jquery.maskedinput.js',
    'js/construct.js',
    'js/constructPollInfo.js'
  ];

  public $depends = [
  ];

}
