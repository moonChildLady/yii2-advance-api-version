<?php

namespace frontend\models;

use Yii;

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
            [['user', 'video', 'image'], 'required'],
            [['user'], 'integer'],
            [['video', 'image'], 'string'],
            [['createdDate'], 'safe'],
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
        ];
    }
}
