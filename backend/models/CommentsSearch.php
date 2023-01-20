<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comments;

/**
 * CommentsSearch represents the model behind the search form of `backend\models\Comments`.
 */
class CommentsSearch extends Comments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rate', 'like', 'dislike', 'user', 'product'], 'integer'],
            [['comment', 'createdDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comments::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'rate' => $this->rate,
            'like' => $this->like,
            'dislike' => $this->dislike,
            'createdDate' => $this->createdDate,
            'user' => $this->user,
            'product' => $this->product,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
