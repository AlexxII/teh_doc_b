<?php

//EquipmentAsset for DataTables tables;

namespace app\assets;

use yii\web\AssetBundle;

class TableBaseAsset extends AssetBundle
{
  public $css = [
      'vendor/datatable/css/datatable.all.css',
  ];

  public $js = [
      'vendor/datatable/js/datatable.all.js',
  ];

}