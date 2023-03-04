<?php

namespace app\assets;

use yii\web\AssetBundle;

class DarkAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/dark.css',
    ];
    public $js = [
        "css/dark.js"
    ];
    public $depends = [
    ];
}