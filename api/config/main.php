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
			'baseUrl'=>'/proj/supermarket/api',
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
			'baseUrl'=>'/proj/supermarket/api',
            'rules' => [
				['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
				['class' => 'yii\rest\UrlRule', 'controller' => ['v1/products'=>'v1/products'],
				'tokens' => [
						//'GetAll'=>'record/GetAll',
						//'{action}' => '<action:\\w+>',
                        //'{id}' => '<id:\\d+>'
                        '{id}' => '<id:\\d[\\d,]*>'
						//'{action}' => '<action:\\w+>',
						//'{action}' => '<action:[a-zA-Z0-9\\-]+>',
						
                    ],
					'pluralize' => false,
				'extraPatterns' => [
						//'POST record/get-all'=>'v1/record/get-all',
						//'OPTIONS <action:\\w+>' => 'options',
						//'GET,HEAD getAll'=>'getall',
						//'OPTIONS' => 'options',
						//'OPTIONS getAll'=>'options',
						
						//'OPTIONS' => 'options',
						//'GET GetAll' => 'GetAll', 
						//'OPTIONS <action:\w+>' => 'options',
						'GET get-comments/{id}' => 'get-comments',
						'POST add-comments/{id}' => 'add-comments',
						'GET get-category/{id}' => 'get-category',
						'GET get-product/{id}' => 'get-product',
						//'POST update/{id}' => 'update',
						//'DELETE delete/{id}' => 'delete',
					],],
			],        
        ]
    ],
    'params' => $params,
];