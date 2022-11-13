<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use common\models\LoginForm;
use common\models\User;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
	
	public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),  
			'except'=>['login','logout'],
        ]; 
        return $behaviors;
    }
	public function init()
	{
		parent::init();
		\Yii::$app->user->enableSession = false;
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
			'get-user'=>['GET'],
		];
		return $verbs;
    }
	public function actionLogin()
    {
        //if (!\Yii::$app->user->isGuest) {
        //    return $this->goHome();
        //}
		$request = \Yii::$app->request;
		$username = $request->post("username");
		$password = $request->post("password");
		$user = User::findByUsername($username);

            if ($user && $user->validatePassword($username, $password)) {
                return $user;
            }else{
                return $user;
            }
		//Yii::$app->getRequest()->getBodyParams()
		//return $request->post("username");
        //$model = new LoginForm();
        //if ($model->load(\Yii::$app->request->post()) && $model->login()) {
        //    return "1";
        //}
		//
        //$model->password = '';

        //return $this->render('login', [
        //    'model' => $model,
        //]);
    }
	public function actionGetUser(){
		$user = \Yii::$app->user->identity;
		return $user;
	}
}