<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/bootstrap/css/bootstrap.min.css',
        'css/modern.min.css',
        'css/themes/green.css',
    ];
    public $js = [
        'plugins/jquery-ui/jquery-ui.min.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'plugins/waves/waves.min.js',
        'plugins/flot/jquery.flot.min.js',
        'plugins/flot/jquery.flot.tooltip.min.js',
        'js/modern.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
    ];
}
