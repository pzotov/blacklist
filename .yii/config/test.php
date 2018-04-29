<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'blacklist66-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
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
	    'user' => [
		    'identityClass' => 'app\models\User',
		    'enableAutoLogin' => true,
	    ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
