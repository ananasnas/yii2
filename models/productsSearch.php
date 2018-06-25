<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Products;

/**
 * productsSearch represents the model behind the search form about `app\models\Products`.
 */
class productsSearch extends Products
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_product', 'frozen', 'Categories_ID_category', 'WasDel', 'activate'], 'integer'],
            [['name', 'unit'], 'safe'],
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
        $query = Products::find()->where(['Categories_ID_category' => $params['ID_category']])->andWhere(['WasDel'=>0]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
        'pageSize' => 5,          
        ]]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_product' => $this->ID_product,
            'frozen' => $this->frozen,
            'Categories_ID_category' => $this->Categories_ID_category,
            'WasDel' => $this->WasDel,
            'activate' => $this->activate,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'unit', $this->unit]);

        return $dataProvider;
    }
}
