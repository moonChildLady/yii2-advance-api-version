<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "record".
 *
 * @property int $id
 * @property int $user
 * @property string $video
 * @property string $image
 * @property string|null $createdDate
 */
class Record extends \yii\db\ActiveRecord
{
	
	public $mediaUpload;
	//public $response;
	//public $slug;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['user', 'video', 'image','title','description'], 'required'],
            [['title'], 'required'],
            [['user'], 'integer'],
            [['video', 'image'], 'string'],
            [['createdDate','status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'video' => 'Video',
            'image' => 'Image',
            'createdDate' => 'Created Date',
            'dateUpdated' => 'Updated Date',
            'status' => 'status',
        ];
    }
	
	public function fields(){
    $fields = parent::fields();
    $fields['body'] = 'description';
    $fields['pk'] = 'id';
	$fields['image'] = 'imageURL';
	$fields['video'] = 'videoURL';
    $fields['response'] = 'response';
    $fields['dateUpdated'] = 'dateUpdated';
    $fields['slug'] = 'slug';
    $fields['username'] = 'user';
    $fields['userid'] = 'user';
    $fields['displayname'] = 'displayname';
    return $fields;
	}
	
	
	
	public function extraFields() 
	{
    return [
      //'postcode',
      'displayname'=>function($model){
         return $model->userInfo->display_name;
       },
	   //'pk'=>function($model){
       //  return $model->id;
       //},
	   //'response'=>function($model){
		//   
       //  return "updated";
       //}
    ];
	}
	
	public function getUserInfo()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
	
	public function getImageURL(){
		$url = \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/").'upload/';
		return $url.$this->image;
	}
	
	public function getVideoURL(){
		$url = \Yii::$app->urlManagerFrontend->createAbsoluteUrl("/").'upload/';
		return $url.$this->video;
	}
	
	public function getSlug(){
		return $this->status;

	}
	public function getResponse(){
		return "1";
	}
	public function getDisplayname(){
		return $this->userInfo->display_name;
	}
	
	//public function getDateUpdated(){
	//	return $this->
	//}
}
