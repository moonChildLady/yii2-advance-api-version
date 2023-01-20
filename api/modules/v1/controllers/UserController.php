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
use yii\web\NotFoundHttpException;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';
	public $serializer = [
        //'class' => 'yii\rest\Serializer',
        'class' => 'common\components\JsonSerializer',
        //'collectionEnvelope' => 'items',
    ];
	
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
		$model->username = $request->post("email");
		$model->email = $request->post("email");
		$model->password = $request->post("password");
		
		$model->display_name = $request->post("name");

        if ($model->signupapi()) {
			$user = User::findByEmail($request->post("email"));

		$output = User::find()
				//->joinWith(['userInfo'])
				->where(['id'=>$user->id]);

       
		return new ActiveDataProvider([
			'query' => $output,
		]);

        }else{
			//return $model->errors;
			$new_array = [];
			foreach ($model->errors as $key => $value){
				$new_array[$key] = is_array($value) ? implode(",", $value) : $value;
			}
			//return array("response"=>"Error",'error_message'=>implode("\n",$new_array));
			throw new NotFoundHttpException('Invalid credentials');
		}
    }
	
	public function actionLogin()
    {
        //if (!\Yii::$app->user->isGuest) {
        //    return $this->goHome();
        //}
		$request = \Yii::$app->request;
		$email = $request->post("email");
		$password = $request->post("password");
		$user = User::findByEmail($email);

            if ($user && $user->validatePassword($password)) {
                //return array("user"=>$user, "token"=>$user->auth_key);
				$output = User::find()
				//->joinWith(['userInfo'])
				->where(['id'=>$user->id]);
				//->andWhere(['record.id'=>1]);
				//->andWhere(['<=', 'population', $upper])
       
		return new ActiveDataProvider([
			'query' => $output,
		]);
                //return $user;
            }else{
               //return array("response"=>0,'error_message'=>"Invalid credentials");
			   throw new NotFoundHttpException('Invalid credentials');
            }

    }
	public function actionGetUser(){
		$user = \Yii::$app->user->identity;
		$output = User::find()
				->where(['id'=>$user->id]);
       
		return new ActiveDataProvider([
			'query' => $output,
		]);
	}
}