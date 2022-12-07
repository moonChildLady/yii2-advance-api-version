<?php

namespace api\modules\v1\controllers;
use yii;
use yii\rest\ActiveController;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use common\models\LoginForm;
use common\models\User;
use frontend\models\SignupForm;
use common\components\JsonSerializer;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
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
			'except'=>['login','logout','signup'],
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
			'signup'=>['POST'],
			'get-user'=>['GET'],
			'change-password'=>['PUT'],
		];
		return $verbs;
    }
	
	public function actionChangePassword(){
		$user = \Yii::$app->user->identity;
		$model = User::findIdentityByAccessToken($user->auth_key);
		if(!$model){
			return array("response"=>0);
		}else{
			
			$request = \Yii::$app->request;
			if($model->validatePassword($request->post("old_password"))){
				$model->Password = $request->post("new_password");
				$model->save();
				$model->response = 1;
				return $model;
			}else{
				return array("response"=>0);
			}
		}

	}
	
	public function actionSignup()
    {
        $model = new SignupForm();
		$request = \Yii::$app->request;
		$model->username = $request->post("username");
		$model->password = $request->post("password");
		$model->email = $request->post("email");
		$model->display_name = $request->post("displayname");
		//$model->signupapi();
		//$SignupForm['username'] = $username;
		//$SignupForm['password'] = $password;
		//$SignupForm['email'] = $email;
        if ($model->signupapi()) {
            //Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            //return $this->goHome();
			$user = User::findByUsername($request->post("username"));
			
		//	$output = User::find()
        //->where(['status'=>'10'])
        //->andWhere(['id'=>$user->id]);
        //->andWhere(['id'=>$id]);
        //->andWhere(['<=', 'population', $upper])
		return $user;
       //$output->response = 1;
		/* return new ActiveDataProvider([
			'query' => $output,
		]); */
        }else{
			//return $model->errors;
			$new_array = [];
			foreach ($model->errors as $key => $value){
				$new_array[$key] = is_array($value) ? implode(",", $value) : $value;
			}
			return array("response"=>"Error",'error_message'=>implode("\n",$new_array));
		}
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

            if ($user && $user->validatePassword($password)) {
                return $user;
            }else{
               return array("response"=>0,'error_message'=>"Invalid credentials");
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