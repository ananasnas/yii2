<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form about `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public $org;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_order', 'number_of_delivered_units', 'Cars_ID_car', 'WasDel', 'Organizations_ID_organization'], 'integer'],
            [['comment', 'date_of_order', 'delivery_address', 'delivery_date', 'order_status', 'org'], 'safe'],
            [['prepayment'], 'number'],
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
        $query = Orders::find()->where(['orders.WasDel'=>0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination' => [
        'pageSize' => 5,  
        ]]);
        
        $dataProvider->setSort([
        'attributes' => [
            
            'date_of_order', 
            'delivery_date',
            'org' => [
                'asc' => ['organizations.name' => SORT_ASC],
                'desc' => ['organizations.name' => SORT_DESC],
            ],
        ]
    ]);

   $query->joinWith(['organizationsIDOrganization']);
         if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_order' => $this->ID_order,
            'date_of_order' => $this->date_of_order,
            'delivery_date' => $this->delivery_date,
            'number_of_delivered_units' => $this->number_of_delivered_units,
            'prepayment' => $this->prepayment,
            'Cars_ID_car' => $this->Cars_ID_car,
            'WasDel' => $this->WasDel,
            'Organizations_ID_organization' => $this->Organizations_ID_organization,
        'organizations.name' =>$this->org,
            ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'delivery_address', $this->delivery_address])
            ->andFilterWhere(['like', 'order_status', $this->order_status]);

        return $dataProvider;
    }
}
