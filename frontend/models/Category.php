<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property Products[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }
	public function fields()
	{
		$fields = parent::fields();
	
		// remove fields that contain sensitive information
		
		$fields['children'] = 'children';
		//$fields['isAdmin'] = false;
		//$fields['isStaff'] = false;
		return $fields;
	}
    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['category' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
	
	public function getChildren(){
		return array();
	}
}
