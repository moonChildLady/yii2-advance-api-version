<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "sentiment".
 *
 * @property int $id
 * @property string|null $text
 * @property float|null $score
 */
class Sentiment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sentiment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['score'], 'number'],
            [['text'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'score' => 'Score',
        ];
    }
}
