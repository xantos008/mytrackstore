<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
	'sourceLanguage' => 'ru',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['AssetsMinify','log','languages'],
    'controllerNamespace' => 'frontend\controllers',
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
		'languages' => [
			'class' => 'common\modules\languages\Module',
			'languages' => [
				'English' => 'en',
				'Русский' => 'ru',
			],
			'default_language' => 'ru',
			'show_default' => false,
		],
	],
	'homeUrl' => '/',
    'components' => [
		'i18n' => [
			'translations' => [
				'app' => [
					'class' => 'yii\i18n\PhpMessageSource',
					//'forceTranslation' => true,
					'basePath' => '@common/messages',
				],
			],
		],
		'geoip' => ['class' => 'lysenkobv\GeoIP\GeoIP'],
        'request' => [
			'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
			'class' => 'common\components\Request',
        ],
		'AssetsMinify' =>
        [
            'class' => '\soladiem\autoMinify\AssetsMinify',
			'cssFileBottom' => false,
			'noIncludeJsFilesOnPjax' => false,
			'cssFileBottomLoadOnJs' => true,
			'htmlCompress' => true,
			'htmlCompressOptions' => [
				'extra' => true,
				'no-comments' => true
			],
			'readfileTimeout' => 20,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'class' => 'common\components\UrlManager',
			'rules' => [
				'languages' => 'languages/default/index', //для модуля мультиязычности
				'' => '/',
				'index' => '/',
				'download' => '/site/download',
				'tournaments' => '/tournaments',
				'newbies' => '/site/newbies',
				'media' => '/site/media',
				'about' => '/site/about',
				'contact' => '/site/contact',
				'signup' => '/site/signup',
				'login' => '/site/login',
				'compilation/<url>'=>'/site/compilation',
				'compilation'=>'/site/compilation',
				'page/<page:[\w-]+>' => 'pages/default/index',
				'<action:(contact|login|logout|language|about|signup|upsloan)>' => 'site/<action>',
			],
		],
    ],
    'params' => $params,
];
