<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
		'page' => [
			'class' => 'bupy7\pages\Module',
			'tableName' => '{{%page}}',
			'imperaviLanguage' => 'ru',
			
			'pathToImages' => '@webroot/images',
			'urlToImages' => '@web/images',
			'pathToFiles' => '@webroot/files',
			'urlToFiles' => '@web/files',
			'uploadImage' => true,
			'uploadFile' => true,
			'addImage' => true,
			'addFile' => true,
		],
		'gii' => [
            'class' => 'yii\gii\Module',
			'allowedIPs' => ['*'],
        ],
	],
	'homeUrl' => '/admin',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
			'baseUrl' => '/admin',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'mailer' => [
	        'class' => 'yii\swiftmailer\Mailer',
	        'useFileTransport' => false,
			'messageConfig' => [
				'charset' => 'UTF-8',
				'from' => ['robot-search@mytrackstore.com' => 'Mytrackstore'],
			],
	        'transport' => [
	            'class' => 'Swift_SmtpTransport',
	            'host' => 'ssl://smtp.yandex.ru',
	            'username' => 'robot-search@mytrackstore.com',
	            'password' => '',
	            'port' => '465',
	        ],
	    ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
				'/pages' => '/pages/index',
				'/akcii' => '/site/akcii',
				'/sendmails' => '/site/sendmails',
				'/cronstats' => '/site/cronstats',
				'page/<page:[\w-]+>' => 'pages/default/index',
            ],
        ],
    ],
    'params' => $params,
];
