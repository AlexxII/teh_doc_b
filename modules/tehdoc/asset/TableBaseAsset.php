<?php

//EquipmentAsset for DataTables tables;

namespace app\modules\tehdoc\asset;

use yii\web\AssetBundle;

class TableBaseAsset extends AssetBundle
{
  public $css = [
      'dataTable/css/datatable.all.css',
  ];

  public $js = [
      '/dataTable/js/datatable.all.js',
  ];

}