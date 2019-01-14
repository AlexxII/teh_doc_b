<?php

namespace app\modules\tehdoc\modules\equipment\asset;

use yii\web\AssetBundle;

class EquipmentAsset extends AssetBundle
{

  public $sourcePath = '@app/modules/tehdoc/modules/equipment/lib';

  public $css = [
      'css/bootstrap-datepicker.min.css',
  ];

  public $js = [
      'js/bootstrap-datepicker.min.js',
      'js/bootstrap-datepicker.ru.min.js',
  ];

}
