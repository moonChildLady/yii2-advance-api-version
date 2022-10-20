<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
	//require(__DIR__ . '/../../common/config/bootstrap.php'),
    //require(__DIR__ . '/params.php'),
    //require(__DIR__ . '/params-local.php')
);
//require(__DIR__ . '/../../common/config/bootstrap.php');
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [        
		'request' => [
            'csrfParam' => '_csrf-api',
			//'baseUrl'=>'@app/modules/v1',
			'baseUrl'=>'/proj/letsDance/api',
			'enableCookieValidation' => false,
			'enableCsrfValidation' => false,
			//'cookieValidationKey' => 'qlkwejq9018237jw*!(*&(@*!',
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
			'enableSession' => false,
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
            'enableStrictParsing' => false,
            'showScriptName' => false,
			//'baseUrl'=>'@app/modules/v1',
			'baseUrl'=>'/proj/letsDance/api',
            'rules' => [
				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				['class' => 'yii\rest\UrlRule', 'controller' => 'record'],
			],        
        ]
    ],
    'params' => $params,
];