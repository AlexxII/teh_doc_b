<?php

namespace app\modules\polls\asset;

use yii\web\AssetBundle;

class PollAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/polls/lib';

  public $js = [
    'js/vars.js',

    'js/drive/user.class.js',
    'js/drive/drive.js',
    'js/drive/worksheet.class.js',
    'js/drive/respondent.class.js',
    'js/drive/answer.class.js',
    'js/drive/question.class.js',
    'js/default.js',

    'js/jquery.maskedinput.js',
    'js/construct/pollconstructor.class.js',
    'js/construct/cquestion.class.js',
    'js/construct/canswer.class.js',
    'js/construct/construct.js',

    'js/batch/batch.class.js',
    'js/batch/banswer.class.js',
    'js/batch/bquestion.class.js',
    'js/batch/batch.js',

    'js/analytic/analytic.js'

  ];

  public $css = [
    'css/drivein.css',
    'css/poll_style.css',
    'css/construct.css',
    'css/batch.css',
    'css/analytics.css'
  ];

  public $depends = [
  ];

}
