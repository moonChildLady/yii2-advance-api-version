<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\components\JsonSerializer;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use frontend\models\Record;
use frontend\models\Comments;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use \yii\web\UploadedFile;
use frontend\models\Products;

class ProductsController extends ActiveController
{
    public $modelClass = 'frontend\models\Products';
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
			'except'=>['index','view','get-comments','get-category', 'get-product'],
        ];
		//$behaviors['authenticator']['except'] = ['index'];		
        return $behaviors;
    }
	
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
			'login'=>['POST'],
			'signup'=>['POST'],
			'get-comments'=>['GET'],
			'get-product'=>['GET'],
			'add-comments'=>['POST'],
			'change-password'=>['PUT'],
		];
		return $verbs;
    }
	
	public function actionGetProduct($id){
		//$output = Products::find()
		//		//->joinWith(['userInfo'])
		//		->where(['id'=>$id])->comments;
		//		
		//		//->andWhere(['record.id'=>1]);
		//		//->andWhere(['<=', 'population', $upper])
		//
		//return new ActiveDataProvider([
		//	'query' => $output,
		//]);
		//return Products::comments();
		$model = Products::findAll(['id'=>$id]);
		return $model;
	}
	
	public function actionGetComments($id){
		//$output = Products::find()
		//		//->joinWith(['userInfo'])
		//		->where(['id'=>$id])->comments;
		//		
		//		//->andWhere(['record.id'=>1]);
		//		//->andWhere(['<=', 'population', $upper])
		//
		//return new ActiveDataProvider([
		//	'query' => $output,
		//]);
		//return Products::comments();
		$model = Products::findOne(['id'=>$id])->comments;
		return $model;
	}
	
	public function actionGetCategory($id){
		//$output = Products::find()
		//		//->joinWith(['userInfo'])
		//		->where(['id'=>$id])->comments;
		//		
		//		//->andWhere(['record.id'=>1]);
		//		//->andWhere(['<=', 'population', $upper])
		//
		//return new ActiveDataProvider([
		//	'query' => $output,
		//]);
		//return Products::comments();
		$model = Products::findAll(['category'=>$id]);
		return $model;
	}
	
	public function actionAddComments($id){
		//$output = Products::find()
		//		//->joinWith(['userInfo'])
		//		->where(['id'=>$id])->comments;
		//		
		//		//->andWhere(['record.id'=>1]);
		//		//->andWhere(['<=', 'population', $upper])
		//
		//return new ActiveDataProvider([
		//	'query' => $output,
		//]);
		//return Products::comments();
		$comment = new Comments;
		$request = \Yii::$app->request;
		$comment->comment = $request->post("comment");
		$comment->user = \Yii::$app->user->identity->id;
		$comment->product = $id;
		$comment->save();
		$model = Products::findOne(['id'=>$id])->comments;
		
		return $model;
	}
}