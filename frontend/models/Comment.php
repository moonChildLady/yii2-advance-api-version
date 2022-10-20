<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $user
 * @property string $comment
 * @property string|null $createdDate
 * @property int|null $record
 *
 * @property Record $record0
 * @property User $user0
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'comment'], 'required'],
            [['user', 'record'], 'integer'],
            [['comment'], 'string'],
            [['createdDate'], 'safe'],
            [['record'], 'exist', 'skipOnError' => true, 'targetClass' => Record::class, 'targetAttribute' => ['record' => 'id']],
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
            'user' => 'User',
            'comment' => 'Comment',
            'createdDate' => 'Created Date',
            'record' => 'Record',
        ];
    }

    /**
     * Gets query for [[Record0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecord0()
    {
        return $this->hasOne(Record::class, ['id' => 'record']);
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
}
