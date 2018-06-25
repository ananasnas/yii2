<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Basket;

/**
 * BasketSearch represents the model behind the search form about `app\models\Basket`.
 */
class BasketSearch extends Basket
{
    public $productName;
    public $productPrice;
   
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_basket', 'productPrice','productName' ,'Persons_ID_person', 'Consignments_ID_consignement', 'Products_ID_product', 'take_from_consignment'], 'integer'],
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
        $identity = Yii::$app->user->identity;
        $identity = $identity->ID_person;
        $query = Basket::find()->where(['basket.Persons_ID_person'=>$identity])->andWhere(['basket.WasDel'=>0]);

       
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query, 'pagination' => [
        'pageSize' => 5,      
    ],
        ]);

          $query->joinWith(['productsIDProduct']);
           $query->joinWith(['consignmentsIDConsignement']);
         if (!($this->load($params) && $this->validate())) {
      
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
//            'ID_basket' => $this->ID_basket,
//            'Persons_ID_person' => $this->Persons_ID_person,
//            'Consignments_ID_consignement' => $this->Consignments_ID_consignement,
//            'Products_ID_product' => $this->Products_ID_product,
        ]);

        return $dataProvider;
    }
}
