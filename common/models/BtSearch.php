<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MovieBt;

/**
 * BtSearch represents the model behind the search form about `common\models\MovieBt`.
 */
class BtSearch extends MovieBt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mid', 'created_at'], 'integer'],
            [['bt', 'title', 'fmt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = MovieBt::find();

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
            'mid' => $this->mid,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bt', $this->bt])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'fmt', $this->fmt]);

        return $dataProvider;
    }
}
