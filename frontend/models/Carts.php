<?php

namespace frontend\models;

use Yii;
use common\models\User;
/**
 * This is the model class for table "carts".
 *
 * @property int $id
 * @property int|null $product
 * @property int|null $user
 * @property int|null $quantity
 * @property float|null $amount
 *
 * @property Products $product0
 * @property User $user0
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'user', 'quantity'], 'integer'],
            [['amount'], 'number'],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product' => 'id']],
            [['user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user' => 'id']],
        ];
    }
	
	public function fields()
	{
		$fields = parent::fields();
	
		// remove fields that contain sensitive information
		
		$fields['product'] = 'product0';
		//$fields['avaragereview'] = 'avaragereview';
		//$fields['albums'] = 'albums';
		//$fields['productSpecification'] = 'productSpecification';
		//$fields['commentAnalyzer'] = 'commentAnalyzer';
		//$fields['isAdmin'] = false;
		//$fields['isStaff'] = false;
		return $fields;
	}
	
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product' => 'Product',
            'user' => 'User',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
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
