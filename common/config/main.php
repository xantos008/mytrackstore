<?php
return [
	'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'bootstrap' => ['AssetsMinify'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
    	'request' => [
          'enableCsrfValidation'=>false,
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
        'eauth' => [
            'class' => 'nodge\eauth\EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'cache' => false, // Cache component name or false to disable cache. Defaults to 'cache' on production environments.
            'cacheExpire' => 0, // Cache lifetime. Defaults to 0 - means unlimited.
            'httpClient' => [
                // uncomment this to use streams in safe_mode
                //'useStreamsFallback' => true,
            ],
            'services' => [ // You can change the providers and their classes.
                'twitter' => [
                    // register your app here: https://dev.twitter.com/apps/new
                    'class' => 'nodge\eauth\services\TwitterOAuth1Service',
                    'key' => 'ND6OZv6b7X4mJHRJZmHmAiQHy',
                    'secret' => 'zGqBgSX9gemOQKGSKXJShgSEiEIAEo0oxIMS7ATg8NLi0S1ma5',
                ],
                'google_oauth' => [
                    // register your app here: https://code.google.com/apis/console/
                    'class' => 'nodge\eauth\services\GoogleOAuth2Service',
                    'clientId' => '195168922412-hv8uj53he9g287tbfu2peacga8gh4l4g.apps.googleusercontent.com',
                    'clientSecret' => '8QToD37OjiecoNSLTIFa95mt',
                    'title' => 'Google (OAuth)',
                ],
                'facebook' => [
                    // register your app here: https://developers.facebook.com/apps/
                    'class' => 'nodge\eauth\services\FacebookOAuth2Service',
                    'clientId' => '1170252806442390',
                    'clientSecret' => '675f2bc4e165caf8ecc6bdf35fcbd127',
                ],
            ],
		],
		'i18n' => [
            'translations' => [
                'eauth' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@eauth/messages',
                ],
            ],
        ],
		'formatter' => [
               'class' => 'yii\i18n\Formatter',
               'defaultTimeZone' => 'Europe/Moscow',
               'timeZone' => 'GMT+3',
               'dateFormat' => 'd MMMM yyyy',
               'datetimeFormat' => 'd-M-Y H:i:s',
               'timeFormat' => 'H:i:s', 
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login/<service:google_oauth|facebook|twitter>' => 'site/login',
				'tournaments/<id:[\d]+>'=>'tournaments/turnir',
				'tournaments/<id:[\d]+>/<action:[\w]+>'=>'tournaments/zayavka',
				'tournaments/<id:[\d]+>/show/team/<team:[\d]+>'=>'tournaments/team',
				'tournaments/<id:[\d]+>/team/create'=>'tournaments/teamecreate',
				'news/<id:[\d]+>'=>'site/news',
				'akcii/<id:[\d]+>'=>'site/akcii',
				'newbies/<id:[\d]+>'=>'site/rukovodstvo',
				'/'=>'site/index',
				'compilation'=>'/site/compilation',
            ],
        ],
 
        // (optionally) you can configure logging
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@app/runtime/logs/eauth.log',
                    'categories' => array('nodge\eauth\*'),
                    'logVars' => array(),
                ],
            ],
        ],
    ],
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
	],
];
