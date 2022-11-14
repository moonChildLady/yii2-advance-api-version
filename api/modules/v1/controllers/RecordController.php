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
#use yii\helpers\ArrayHelper;
#use yii\web\BadRequestHttpException;

class RecordController extends ActiveController
{
    public $modelClass = 'frontend\models\Record';
	public $serializer = [
        //'class' => 'yii\rest\Serializer',
        'class' => 'common\components\JsonSerializer',
        //'collectionEnvelope' => 'items',
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
			'except'=>['index','view','get-all'],
        ];
		//$behaviors['authenticator']['except'] = ['index'];		
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
			'get-all'=>['GET'],
			'is-author'=>['GET'],
			'create'=>['POST'],
			'update'=>['POST'],
			'delete'=>['DELETE'],
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
	
	public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
		unset($actions['delete']);
        return $actions;
    }

	public function actionDelete($id){
		$model = $this->findModel($id);
		if($model){
			$model->status = "NON-ACTIVE";
			$model->save();
		}
		return $this->findModel($model->id);
	}
    public function actionCreate(){
        // implement here your code
		$model = new Record();
		$request = \Yii::$app->request;
		$user = \Yii::$app->user->identity;
		$title = $request->post("title");
		$body = $request->post("body");
		$uploadImg = UploadedFile::getInstanceByName('image');
		if($uploadImg){
			$filename = \Yii::$app->security->generateRandomString(22) . time();
            $extension = $uploadImg->extension;
			$path = \Yii::getAlias('@frontend') .'/web/upload/';
			//$uploadImg->path = $path;
			
			if($uploadImg->saveAs($path . $filename . "." . $extension)){
            //return true;
			$model->image = $filename.".".$extension;
        }else{
            return $uploadImg->getErrors();
        }
			}
		$uploadVideo = UploadedFile::getInstanceByName('video');
		if($uploadVideo){
			$filename = \Yii::$app->security->generateRandomString(21) . time();
            $extension = $uploadVideo->extension;
			$path = \Yii::getAlias('@frontend') .'/web/upload/';
			//$uploadImg->path = $path;
			
			if($uploadVideo->saveAs($path . $filename . "." . $extension)){
            //return true;
			$model->video = $filename.".".$extension;
        }else{
            return $uploadVideo->getErrors();
        }
			}
			//$password = $request->post("password");
			$model->title = $title;
			$model->description = $body;
			$model->user = $user->id;
			//$model->response = "created";
			//$model->slug = $mode->status;
			$model->dateUpdated = date('Y-m-d H:i:s');
			$model->save();
			//return $model;
			//return array("response"=>"updated", $model);
			return $this->findModel($model->id);
		//if ($this->request->isPost) {
		//	
		//}
    }
	
	public function actionUpdate($id){
        // implement here your code
		$model = $this->findModel($id);
		//if ($this->request->isPost) {
			$request = \Yii::$app->request;
			$title = $request->post("title");
			$body = $request->post("body");
			
			
			$uploadImg = UploadedFile::getInstanceByName('image');
			if($uploadImg){
			$filename = \Yii::$app->security->generateRandomString(22) . time();
            $extension = $uploadImg->extension;
			$path = \Yii::getAlias('@frontend') .'/web/upload/';
			//$uploadImg->path = $path;
			
			if($uploadImg->saveAs($path . $filename . "." . $extension)){
            //return true;
			$model->image = $filename.".".$extension;
        }else{
            return $uploadImg->getErrors();
        }
			}
			$uploadVideo = UploadedFile::getInstanceByName('video');
		if($uploadVideo){
			$filename = \Yii::$app->security->generateRandomString(21) . time();
            $extension = $uploadVideo->extension;
			$path = \Yii::getAlias('@frontend') .'/web/upload/';
			//$uploadImg->path = $path;
			
			if($uploadVideo->saveAs($path . $filename . "." . $extension)){
            //return true;
			$model->video = $filename.".".$extension;
        }else{
            return $uploadVideo->getErrors();
        }
			}
			//$password = $request->post("password");
			$model->title = $title;
			$model->description = $body;
			
			$model->save();
			//return $model;
			//return array("response"=>"updated", $model);
			return $model;
		//}
    }
	
	public function actionGetAll(){
		$user = \Yii::$app->user->identity;
		//$output = new \yii\db\Query();
		$output = Record::find()
		->joinWith(['userInfo'])
        ->where(['record.status'=>'ACTIVE']);
        //->andWhere(['record.id'=>1]);
        //->andWhere(['<=', 'population', $upper])
       
		return new ActiveDataProvider([
			'query' => $output,
		]);
		//return $output;
		//return $user->id;
	}
	
	public function actionIsAuthor($id){
		$user = \Yii::$app->user->identity;
		$output = Record::find()
        ->where(['status'=>'ACTIVE'])
        ->andWhere(['user'=>$user->id])
        ->andWhere(['id'=>$id]);
        //->andWhere(['<=', 'population', $upper])
       
		return new ActiveDataProvider([
			'query' => $output,
		]);
	}
	
	protected function findModel($id)
    {
        if (($model = Record::findOne(['id' => $id,'user'=>\Yii::$app->user->identity->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}