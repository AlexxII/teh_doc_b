<?php

namespace app\modules\polls\asset;

use yii\web\AssetBundle;

class PollAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/polls/lib';

  public $js = [
    'js/vars.js',
    'js/default.js',
    'js/drive/worksheet.class.js',
    'js/drive/respondent.class.js',
    'js/drive/answer.class.js',
    'js/drive/question.class.js',
//    'js/checker.class.js',
    'js/drive/user.class.js',
    'js/poll.js',
    'js/drive/drive.js',
    'js/jquery.maskedinput.js',
//    'js/construct/constructPollInfo.js',
    'js/construct/pollconstructor.class.js',
    'js/construct/cquestion.class.js',
    'js/construct/canswer.class.js',
    'js/construct/construct.js'
  ];

  public $css = [
    'css/poll_style.css',
  ];

  public $depends = [
  ];

}
