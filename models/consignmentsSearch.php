<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\consignments;

/**
 * consignmentsSearch represents the model behind the search form about `app\models\consignments`.
 */
class consignmentsSearch extends consignments
{
    public $productName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [           
            [['ID_consignment', 'actually_in_stock', 'count_in_consignment', 'defective_products', 'Products_ID_product', 'WasDel'], 'integer'],
            [['arrived', 'storage_life', 'productName'], 'safe'],
            [['parish_price', 'product_price_in_consignment', 'shipping_price'], 'number'],
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
        if(isset( $params['ID_category']))
        {
            $query = consignments::find()->where(['consignments.Categories_ID_category' => $params['ID_category']])->andWhere(['consignments.WasDel'=>0]);
        }
        
       else{
$query = consignments::find()->where(['consignments.WasDel'=>0]);
        }
               
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
        'pageSize' => 5,      
    ],
        ]);
       
        $dataProvider->setSort([
        'attributes' => [
            
            'storage_life',
            'shipping_price',
            'personName' => [
                'asc' => ['products.name' => SORT_ASC],
                'desc' => ['products.name' => SORT_DESC],
            ],
            
        ]
    ]);     
         $query->joinWith(['productsIDProduct']);
         if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_consignment' => $this->ID_consignment,
            'actually_in_stock' => $this->actually_in_stock,
            'arrived' => $this->arrived,
            'count_in_consignment' => $this->count_in_consignment,
            'defective_products' => $this->defective_products,
            'parish_price' => $this->parish_price,
            'product_price_in_consignment' => $this->product_price_in_consignment,
            'shipping_price' => $this->shipping_price,
            'storage_life' => $this->storage_life,
            'Products_ID_product' => $this->Products_ID_product,
            'WasDel' => $this->WasDel,
            'products.name' => $this->productName,
        ]);

        return $dataProvider;
    }
}
