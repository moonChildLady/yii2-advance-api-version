<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','debug'],
    'controllerNamespace' => 'frontend\controllers',
	'name'=>'Lets Dance',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
			'baseUrl'=>'/proj/letsDance/',
			//'parsers' => [
			//	'application/json' => 'yii\web\JsonParser',
			//],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'urlManager' => [
			'enablePrettyUrl' => true,
			//'enableStrictParsing' => true,
			'showScriptName' => false,
			//'baseUrl'=>'https://demo.hikinginspire.com/proj/letsDance/',
			'baseUrl'=>'/proj/letsDance/',
			//'rules' => [
			//	['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
			//	['class' => 'yii\rest\UrlRule', 'controller' => 'record'],
			//],
		],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
