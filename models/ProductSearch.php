<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ProductSearch extends Product
{
    public function rules()
    {
        return [
            [['id', 'quantity', 'minimum_stock'], 'integer'],
            [['name', 'description', 'category', 'manufacturer', 'batch', 'barcode', 'expiry_date'], 'safe'],
            [['price'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Product::find();
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
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'category', $this->category]);
        $query->andFilterWhere(['like', 'manufacturer', $this->manufacturer]);
        $query->andFilterWhere(['like', 'batch', $this->batch]);
        $query->andFilterWhere(['like', 'barcode', $this->barcode]);
        $query->andFilterWhere(['quantity' => $this->quantity]);
        $query->andFilterWhere(['minimum_stock' => $this->minimum_stock]);
        $query->andFilterWhere(['price' => $this->price]);
        $query->andFilterWhere(['expiry_date' => $this->expiry_date]);
        return $dataProvider;
    }
} 