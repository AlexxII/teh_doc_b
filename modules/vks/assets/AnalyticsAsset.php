<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\vks\assets;

use yii\web\AssetBundle;

class AnalyticsAsset extends AssetBundle
{
  public $sourcePath = '@app/modules/vks/lib';
  public $css = [
    'css/dtpicker.min.css'
  ];

  public $js = [
    'js/dtpicker.min.js'
  ];
}
