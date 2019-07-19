<?php

namespace app\modules\tehdoc\asset;

use yii\web\AssetBundle;

class TehFormAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/tehdoc/lib';
    public $css = [
    ];

    public $js = [
        'js/jquery.maskedinput.js',
    ];
}
