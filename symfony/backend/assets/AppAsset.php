<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600',
        'plugins/pace-master/themes/blue/pace-theme-flash.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/fontawesome/css/font-awesome.css',
        'plugins/line-icons/simple-line-icons.css',
        'plugins/offcanvasmenueffects/css/menu_cornerbox.css',
        'plugins/waves/waves.min.css',
        'plugins/switchery/switchery.min.css',
        'plugins/3d-bold-navigation/css/style.css',
        'plugins/slidepushmenus/css/component.css',
        'plugins/weather-icons-master/css/weather-icons.min.css',
        'plugins/bootstrap/css/bootstrap.min.css',
        'plugins/metrojs/MetroJs.min.css',
        'plugins/toastr/toastr.min.css',
        'css/modern.min.css',
        'css/themes/green.css',
        'css/custom.css',
        'css/tables.css',

    ];
    public $js = [
        // 'plugins/jquery-ui/jquery-ui.min.js',
        'plugins/pace-master/pace.min.js',
        // 'plugins/jquery-blockui/jquery.blockui.js',
        'plugins/bootstrap/js/bootstrap.min.js',
        'plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'plugins/switchery/switchery.min.js',
        'plugins/offcanvasmenueffects/js/classie.js',
        'plugins/offcanvasmenueffects/js/main.js',
        'plugins/waves/waves.min.js',
        'plugins/3d-bold-navigation/js/main.js',
        'plugins/waypoints/jquery.waypoints.min.js',
        'plugins/jquery-counterup/jquery.counterup.min.js',
        'plugins/toastr/toastr.min.js',
        'plugins/flot/jquery.flot.min.js',
        'plugins/flot/jquery.flot.time.min.js',
        'plugins/flot/jquery.flot.symbol.min.js',
        'plugins/flot/jquery.flot.resize.min.js',
        'plugins/flot/jquery.flot.tooltip.min.js',
        'plugins/curvedlines/curvedLines.js',
        'plugins/metrojs/MetroJs.min.js',
        'js/modern.js',
        'js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\widgets\ActiveFormAsset',
    ];
}
