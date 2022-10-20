<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "likeAction".
 *
 * @property int $id
 * @property int|null $user
 * @property string|null $createdDate
 * @property string|null $status
 * @property int|null $record
 *
 * @property Record $record0
 * @property User $user0
 */
class LikeAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likeAction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user', 'record'], 'integer'],
            [['createdDate'], 'safe'],
            [['status'], 'string', 'max' => 45],
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
            'createdDate' => 'Created Date',
            'status' => 'Status',
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
