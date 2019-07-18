<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'filemanager' => [
            'class' => 'pendalf89\filemanager\Module',
            // Upload routes
            'routes' => [
                // Base absolute path to web directory
                'baseUrl' => '',
                // Base web directory url
                'basePath' => '@www',
                // Path for uploaded files in web directory
                'uploadPath' => 'uploads',
            ],
            // Thumbnails info
            'thumbs' => [
                'small' => [
                    'name' => 'Small',
                    'size' => [100, 100],
                ],
                'medium' => [
                    'name' => 'Medium',
                    'size' => [300, 200],
                ],
                'large' => [
                    'name' => 'Large',
                    'size' => [500, 400],
                ],
            ],
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'assetManager' => [
            'bundles' => [
                // 'yii\web\JqueryAsset' => [
                //     'js'=>[]
                // ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js'=>[]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
    ],
];
