<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$mail = require __DIR__ . '/mail.php';

$config = [
    'id' => 'blacklist66',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'D2_HiJYv-CdvZyJAE3eN54lA49LtBUOl',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
	        'transport' => $mail,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
        	'baseUrl' => '/',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
	            '/' => 'site/index',
	            'profile' => 'site/profile',
	            'logout' => 'site/logout',
	            'login' => 'site/login',
	            '<controller:\w+>' => '<controller>/index',
	            '<controller:\w+>/<id:\d+>' => '<controller>/edit',
	            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],
	    'assetManager' => [
		    'bundles' => [
			    'yii\web\JqueryAsset' => [
				    'sourcePath' => null,
				    'basePath' => '@webroot',
				    'baseUrl' => '@web',
				    'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
				    'js' => [
					    "tpl/assets/js/common.min.js",
				    ]
			    ],
			    'yii\bootstrap\BootstrapAsset' => [
				    'css' => [],
				    'js' => [],
			    ],
			    'yii\bootstrap\BootstrapPluginAsset' => [
				    'css' => [],
				    'js' => [],
			    ],
		    ],
		    'appendTimestamp' => true,
	    ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
