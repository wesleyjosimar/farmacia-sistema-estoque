<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class StockMovementSearch extends StockMovement
{
    public function rules()
    {
        return [
            [['id', 'product_id', 'user_id', 'quantity', 'created_at'], 'integer'],
            [['type', 'reason'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StockMovement::find()->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['product_id' => $this->product_id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['quantity' => $this->quantity]);
        $query->andFilterWhere(['created_at' => $this->created_at]);
        $query->andFilterWhere(['like', 'type', $this->type]);
        $query->andFilterWhere(['like', 'reason', $this->reason]);
        return $dataProvider;
    }
} 