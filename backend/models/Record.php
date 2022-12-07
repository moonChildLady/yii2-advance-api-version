<?php

namespace backend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "record".
 *
 * @property int $id
 * @property int $user
 * @property string|null $video
 * @property string|null $image
 * @property string|null $createdDate
 * @property string|null $title
 * @property string|null $description
 * @property string|null $status
 * @property string|null $dateUpdated
 *
 * @property Comment[] $comments
 * @property LikeAction[] $likeActions
 */
class Record extends \yii\db\ActiveRecord
{
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
            [['user'], 'required'],
            [['user'], 'integer'],
            [['video', 'image', 'description'], 'string'],
            [['createdDate', 'dateUpdated'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 45],
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
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'dateUpdated' => 'Date Updated',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['record' => 'id']);
    }

    /**
     * Gets query for [[LikeActions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLikeActions()
    {
        return $this->hasMany(LikeAction::class, ['record' => 'id']);
    }
	
	public function getUser0()
    {
        return $this->hasOne(User::class, ['id' => 'user']);
    }
}
