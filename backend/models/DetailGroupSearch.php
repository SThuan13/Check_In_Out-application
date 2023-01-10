<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DetailGroup;

/**
 * DetailGroupSearch represents the model behind the search form of `app\models\DetailGroup`.
 */
class DetailGroupSearch extends DetailGroup
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail_id', 'group_id'], 'integer'],
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
        $query = DetailGroup::find();

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
            'detail_id' => $this->detail_id,
            'group_id' => $this->group_id,
        ]);

        return $dataProvider;
    }
}
