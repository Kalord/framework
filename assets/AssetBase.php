<?php

namespace app\assets;

use app\framework\core\Asset;

class AssetBase extends Asset
{
    public $css = [
        'assets/css/main.css',
        'assets/css/media.css'
    ];

    public $js = [
        'assets/js/jquery.js',
        'assets/js/main.js'
    ];
}