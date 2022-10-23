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
#use yii\helpers\ArrayHelper;
#use yii\web\BadRequestHttpException;

class RecordController extends ActiveController
{
    public $modelClass = 'frontend\models\Record';
	public $serializer = [
        //'class' => 'yii\rest\Serializer',
        'class' => 'common\components\JsonSerializer',
        'collectionEnvelope' => 'items',
    ];
	
	public function init()
	{
		parent::init();
		\Yii::$app->user->enableSession = false;
	}
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),  
        ]; 
        return $behaviors;
    }
	//public function behaviors()
    //{
    //    $behaviors = parent::behaviors();
    //    $behaviors['verbs'] = [
    //            'class' => \yii\filters\VerbFilter::className(),
    //            'actions' => [
    //                'GetAll'  => ['GET'],
    //            ],
    //    ];
    //    
    //    //$behaviors['authenticator'] = [
    //    //'except' => 'myCustomAction',
    //    //    'class' => HttpBasicAuth::className(),
    //    //];
    //  
    //    return $behaviors;
    //}
	
	protected function verbs(){
        //return [
        //    'create' => ['POST'],
        //    'update' => ['PUT', 'PATCH','POST'],
        //    'delete' => ['DELETE'],
        //    'view' => ['GET'],
        //    'index'=>['GET'],
        //    'GetAll'=>['POST'],
        //];
		$verbs = parent::verbs();
		//$verbs['index'][] = 'OPTIONS';
		//$verbs['GetAll'] = ['OPTIONS'];
		$verbs = [
			'get-all'=>['POST'],
		];
		return $verbs;
    }
	//protected function verbs() {
    //    return [
    //        'get-all' => [ 'POST' ],
    //    ];
    //}
	//public function actions()
    //{
    //    $actions = parent::actions();
	//	
    //    //unset(
    //    //    $actions[ 'index' ],
    //    //    $actions[ 'view' ],
    //    //    $actions[ 'create' ],
    //    //    $actions[ 'update' ],
    //    //    $actions[ 'delete' ],
    //    //    $actions[ 'options' ]
    //    //);
	//	//$actions['index']['GetAll'] = [$this, 'GetAll'];
	//	$actions['GetAll'][] = [$this, 'GetAll'];
    //    //unset($actions['create']);
	//	//$actions['options'] = [
    //    //'class' => 'yii\rest\OptionsAction',
    //    ////// optional:
    //    ////'collectionOptions' => ['GET', 'POST', 'HEAD', 'OPTIONS'],
    //    ////'resourceOptions' => ['GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
	//	//];
    //    return $actions;
    //}
	//public function behaviors()
	//{
    //$behaviors = parent::behaviors();
	////
    ////unset($behaviors['authenticator']);
	////
    ////$behaviors['corsFilter'] = [
    ////    'class' => Cors::className(),
    ////    'cors' => [
    ////        'Origin' => ['*'],
    ////        'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
    ////        'Access-Control-Request-Headers' => ['*'],
    ////        'Access-Control-Allow-Credentials' => true,
    ////    ],
    ////];
	//
    ////$behaviors['authenticator'] = [
    ////    'class' =>  HttpBearerAuth::className(),
    ////    'except' => ['options','login'],
    ////];
	//
    //return $behaviors;
	//}
	public function actionGetAll(){
		$user = \Yii::$app->user->identity;
		$output = Record::find()
        ->where(['status'=>'ACTIVE'])
        ->andWhere(['user'=>$user->id]);
        //->andWhere(['<=', 'population', $upper])
       
		return new ActiveDataProvider([
			'query' => $output,
		]);
		//return $output;
		//return $user->id;
	}
}