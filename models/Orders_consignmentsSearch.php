<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders_consignments;

/**
 * Orders_consignmentsSearch represents the model behind the search form about `app\models\Orders_consignments`.
 */
class Orders_consignmentsSearch extends Orders_consignments
{
    public $productName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productName'],'safe'],
            [['ID_orders_consignments', 'Consignments_ID_consignment', 'Orders_ID_order', 'Products_ID_product', 'take_from_consignment'], 'integer'],
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

        $query = Orders_consignments::find()->where(['orders_consignments.Orders_ID_order' => $params]);;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $query->joinWith(['productsIDproduct']);
         if (!($this->load($params) && $this->validate())) {

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_orders_consignments' => $this->ID_orders_consignments,
            'Consignments_ID_consignment' => $this->Consignments_ID_consignment,
            'Orders_ID_order' => $this->Orders_ID_order,
            'Products_ID_product' => $this->Products_ID_product,
            'take_from_consignment' => $this->take_from_consignment,
        ]);

        return $dataProvider;
    }
}
}
