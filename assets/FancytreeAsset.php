<?php

namespace app\assets;

class FancytreeAsset extends \yii\web\AssetBundle
{
  public $sourcePath = '@bower/fancytree';
  public $skin = 'dist/skin-xp/ui.fancytree';                       // скин для дерева

  public $depends = [
    'yii\web\JqueryAsset',
    'yii\jui\JuiAsset'
  ];

  protected function setupAssets($type, $files = [])
  {
    $srcFiles = [];
    $minFiles = [];
    foreach ($files as $file) {
      $srcFiles[] = "{$file}.{$type}";
      $minFiles[] = "{$file}.min.{$type}";
    }
    if (empty($this->$type)) {
      $this->$type = YII_DEBUG ? $srcFiles : $minFiles;
    }
  }

  public function init()
  {
    $this->setupAssets('css', [$this->skin]);
    $this->setupAssets('js', [
      'dist/jquery.fancytree-all',
      'src/jquery.fancytree.table',
      'src/jquery.fancytree.gridnav',
      'src/jquery.fancytree.multi',
      'dist/modules/jquery.fancytree.childcounter'
    ]);
    parent::init();
  }
}
