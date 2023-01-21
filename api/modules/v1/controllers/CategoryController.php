<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\components\JsonSerializer;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use frontend\models\Record;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use \yii\web\UploadedFile;

class CategoryController extends ActiveController
{
    public $modelClass = 'frontend\models\Category';
	//public $serializer = [
    //    //'class' => 'yii\rest\Serializer',
    //    'class' => 'common\components\JsonSerializer',
    //    //'collectionEnvelope' => 'items',
    //];
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),  
			'except'=>['index','view','get-all'],
        ];
        $behaviors['corsFilter'] = [
			'class' => '\yii\filters\Cors',
			'cors' => [
				'Origin' => ['*'],
				'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
				'Access-Control-Request-Headers' => ['*'],
			],
		];
		//$behaviors['authenticator']['except'] = ['index'];		
        return $behaviors;
    }
}