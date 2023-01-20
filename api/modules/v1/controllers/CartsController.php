<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use common\components\JsonSerializer;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use frontend\models\Carts;
use frontend\models\Products;


class CartsController extends ActiveController
{
    public $modelClass = 'frontend\models\Carts';
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
			//'except'=>['index','view'],
        ];
		//$behaviors['authenticator']['except'] = ['index'];		
        return $behaviors;
    }
	
	public function actions(){
        $actions = parent::actions();
        //unset($actions['create']);
        //unset($actions['update']);
        //unset($actions['delete']);
        //unset($actions['view']);
        unset($actions['index']);
        return $actions;
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
			
			'index'=>['GET'],
			'add-quantity'=>['POST'],
			'delete-product'=>['POST'],
			'add-to-cart'=>['POST'],
			'delete-all'=>['POST'],
		];
		return $verbs;
    }
	
	
	
	public function actionIndex(){
		
		$user = \Yii::$app->user->identity->id;
		$model = Carts::findAll(['user'=>$user]);
		return $model;
	}
	
	public function actionAddQuantity(){
		$request = \Yii::$app->request;
		$user = \Yii::$app->user->identity->id;
		$quantity = $request->post("quantity");
		$id = $request->post("id");
		$model = Carts::findOne(['user'=>$user, 'id'=>$id]);
		if($model){
			$model->quantity = $quantity;
			//$model->user = $user;
			$model->save();
		}
		return $model;
	}
	
	public function actionAddToCart(){
		$request = \Yii::$app->request;
		$user = \Yii::$app->user->identity->id;
		//$quantity = $request->post("quantity");
		$id = $request->post("id");
		$model = Carts::findOne(['user'=>$user, 'product'=>$id]);
		if($model){
			$model->quantity = $model->quantity+1;
			//$model->user = $user;
			$model->save();
		}else{
			$model = new Carts;
			$model->user = $user;
			$model->product = $id;
			$model->quantity = 1;
			$model->amount = Products::findOne(["id"=>$id])->price;
			$model->save();
		}
		return $model;
	}
	public function actionDeleteProduct(){
		$request = \Yii::$app->request;
		$user = \Yii::$app->user->identity->id;
		//$quantity = $request->post("quantity");
		$id = $request->post("id");
		$model = Carts::findOne(['user'=>$user, 'id'=>$id]);
		if($model){
			$model->delete();
		}
		return true;
	}
	
	public function actionDeleteAll(){
		$request = \Yii::$app->request;
		$user = \Yii::$app->user->identity->id;
		//$quantity = $request->post("quantity");
		//$id = $request->post("id");
		$model = Carts::deleteAll(['user'=>$user]);
		if($model){
			//$model->deleteAll();
		}
		return true;
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