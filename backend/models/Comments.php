<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string|null $comment
 * @property int|null $rate
 * @property int|null $like
 * @property int|null $dislike
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'string'],
            [['rate', 'like', 'dislike', 'user', 'product'], 'integer'],
            [['createdDate'], 'safe'],
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
}
