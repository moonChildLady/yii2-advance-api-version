<?php

namespace frontend\models;
//namespace Sentiment\Analyzer;

use Yii;
use Sentiment\Analyzer;
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
 * @property Category $category0
 * @property Comments[] $comments
 */
class Products extends \yii\db\ActiveRecord
{
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

	public function fields()
	{
		$fields = parent::fields();
	
		// remove fields that contain sensitive information
		
		$fields['category'] = 'category0';
		$fields['avaragereview'] = 'avaragereview';
		$fields['albums'] = 'albums';
		$fields['productSpecification'] = 'productSpecification';
		$fields['commentAnalyzer'] = 'commentAnalyzer';
		//$fields['isAdmin'] = false;
		//$fields['isStaff'] = false;
		return $fields;
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
	
	public function getAvaragereview(){
		//$scores = array();
		
		$compond = 0;
		if($this->comments){
		$sentiment = new Analyzer();
		//new words not in the dictionary
		$newWords = array();
		$wordsentiment = Sentiment::find()->all();
		foreach($wordsentiment as $i=>$word){
		//new words not in the dictionary
		$newWords[$word->text] = $word->score;
		}
		
		//Dynamically update the dictionary with the new words
		$sentiment->updateLexicon($newWords);
		
		foreach($this->comments as $i=>$comment){
			$scores = $sentiment->getSentiment($comment->comment);
			//$scores["comment"]["compound"] = $comment->comment;
			$compond += $scores["compound"];
		}
		}
		
		return $this->rating(floatval($compond));
		//return $compond;
	}
	
	public function getcommentAnalyzer(){
		$scores = array();
		$sentiment = new Analyzer();
		//$compond = 0;
		$newWords = array();
		$wordsentiment = Sentiment::find()->all();
		foreach($wordsentiment as $i=>$word){
		//new words not in the dictionary
		$newWords[$word->text] = $word->score;
		}
		
		//Dynamically update the dictionary with the new words
		$sentiment->updateLexicon($newWords);
		foreach($this->comments as $i=>$comment){
			$scores[$i]["comment"] = $comment->comment;
			$scores[$i]["score"] = $sentiment->getSentiment($comment->comment);
			
			//$compond += $scores["compound"];
		}
		return $scores;
	}
	
	public function getAlbums(){
		$array = array();
		foreach(explode(",",$this->images) as $i=>$iamge){
			$array[$i]["image"] = $iamge;
		}
		//return array("image"=>explode(",",$this->images)[0]);
		return $array;
	}
	
	public function getProductSpecification(){
		return array();
	}
	
	/**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['product' => 'id'])->orderBy(['comments.createdDate'=>SORT_DESC]);
    }

	
	
	public function rating($score){
		//switch ($score) {
		//case ($score >= 0.5 && $score <= 1):
		//	$result = 5;
		//	break;
		//case ($score >= 0.1 && $score <= 0.5):
		//	$result = 4;
		//	break;
		//case ($score >= -0.1 && $score <= 0.1):
		//	$result = 3;
		//	break;
		//case ($score >= -0.5&& $score <= -0.1):
		//	$result = 2;
		//	break;
		//case ($score >= -1 && $score <= -0.5):
		//	$result = 1;
		//	break;
		//}
		$result = 0;
		switch ($score) {
		case ($score === 0):
			$result = 3;
			break;
		case ($score >= 0.75):
			$result = 5;
			break;
		case ($score >= 0.5):
			$result = 4.5;
			break;
		case ($score >= 0.25):
			$result = 4;
			break;
		case ($score > 0 && $score < 0.25):
			$result = 3.5;
			break;
		
		
		case ($score > 0 && $score < -0.25):
			$result = 2.5;
			break;
		
		case ($score >= -0.25):
			$result = 2;
			break;
		
		case ($score > -0.5):
			$result = 1.5;
			break;
		
		case ($score >= -0.75):
			$result = 1;
			break;
		
		case ($score > -1):
			$result = 0.5;
			break;
		}
		
		
		
		
		return $result;
	}
}
