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
		'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',        // class is required on custom named URL managers!
            //'hostInfo' => 'https://example.com',    // the full base domain name to use for the links
            // here is your frontend URL manager config
			'baseUrl'=>'/proj/letsDance',
			'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'urlManager' => [
			'class'=>'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
			//'baseUrl'=>'@app/modules/v1',
			'baseUrl'=>'/proj/letsDance/api',
            'rules' => [
				['class' => 'yii\rest\UrlRule', 
				'controller' => ['v1/user'=>'v1/user'],
				'pluralize' => false,
					
				],

				[
					'class' => 'yii\rest\UrlRule', 
					'controller' => ['v1/record'=>'v1/record'],
					//'prefix' => 'record/<id:\\w+>',
					'pluralize' => false,
					
					//'patterns' => [
					//	'GET GetAll'=>'GetAll',
					//	'OPTIONS GetAll' => 'options',
					//],
					'tokens' => [
						//'GetAll'=>'record/GetAll',
						//'{action}' => '<action:\\w+>',
                        //'{id}' => '<id:\\d+>'
                        '{id}' => '<id:\\d[\\d,]*>'
						//'{action}' => '<action:\\w+>',
						//'{action}' => '<action:[a-zA-Z0-9\\-]+>',
						
                    ],
					'extraPatterns' => [
						//'POST record/get-all'=>'v1/record/get-all',
						//'OPTIONS <action:\\w+>' => 'options',
						//'GET,HEAD getAll'=>'getall',
						//'OPTIONS' => 'options',
						//'OPTIONS getAll'=>'options',
						
						//'OPTIONS' => 'options',
						//'GET GetAll' => 'GetAll', 
						//'OPTIONS <action:\w+>' => 'options',
						'GET is-author/{id}' => 'is-author',
						'POST update/{id}' => 'update',
					],
					//
					//'except' => ['index', 'create', 'view', 'update', 'delete'],
				],
				//'record/<action:\w+>/<id:\d+>'=>'record/<action>',
				//'POST record/GetAll'=>'record/GetAll',
				//'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				
			],        
        ],
    ],
    'params' => $params,
];
