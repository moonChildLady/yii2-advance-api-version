<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $image
 * @property string|null $images
 * @property float|null $price
 * @property int|null $category
 * @property string|null $createdDate
 *
 * @property Carts[] $carts
 * @property Category $category0
 * @property Comments[] $comments
 */
class Products extends \yii\db\ActiveRecord
{
	public $mediaUpload;
	public $mediaMultipleUpload;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keywords', 'images'], 'string'],
            [['price'], 'number'],
            [['category'], 'integer'],
            [['createdDate'], 'safe'],
			[['mediaUpload'], 'file', 'extensions' => 'png, jpg, jpeg'],
			[['mediaMultipleUpload'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
            [['title', 'description', 'image'], 'string', 'max' => 255],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category' => 'id']],
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
            'keywords' => 'Keywords',
            'description' => 'Description',
            'image' => 'Image',
            'images' => 'Images',
            'price' => 'Price',
            'category' => 'Category',
            'createdDate' => 'Created Date',
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Carts::class, ['product' => 'id']);
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['product' => 'id']);
    }
}
