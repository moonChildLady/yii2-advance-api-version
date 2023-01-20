<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string|null $comment
 * @property string|null $rate
 * @property string|null $like
 * @property string|null $dislike
 * @property string|null $createdDate
 * @property int|null $user
 * @property int|null $product
 *
 * @property Products $product0
 * @property User $user0
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }
	
	public function fields()
	{
		$fields = parent::fields();
	
		// remove fields that contain sensitive information
		unset($fields['like'],$fields['dislike']);
		$fields['get_total_likes'] = 'totalLikes';
		$fields['get_total_dislikes'] = 'totalDislikes';
		$fields['isLike'] = 'isLike';
		$fields['isDislike'] = 'isDislike';
		$fields['userModel'] = 'user0';
		
		//$fields['albums'] = 'albums';
		//$fields['productSpecification'] = 'productSpecification';
		//$fields['isAdmin'] = false;
		//$fields['isStaff'] = false;
		return $fields;
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'string'],
            [['createdDate'], 'safe'],
            [['user', 'product'], 'integer'],
            [['rate', 'like', 'dislike'], 'string', 'max' => 45],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'rate' => 'Rate',
            'like' => 'Like',
            'dislike' => 'Dislike',
            'createdDate' => 'Created Date',
            'user' => 'User',
            'product' => 'Product',
        ];
    }

    /**
     * Gets query for [[Product0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Products::class, ['id' => 'product']);
    }

    /**
     * Gets query for [[User0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
	
	public function getTotalDislikes(){
		return null;
	}
	
	public function gettotalLikes(){
		return null;
	}
	
	public function getIsLike(){
		return ($this->like==1)?true:false;
	}
	public function getIsDislike(){
		return ($this->dislike==1)?true:false;
	}
}
