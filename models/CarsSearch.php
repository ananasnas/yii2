<?php

namespace app\models;
use app\models\persons;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cars;

/**
 * CarsSearch represents the model behind the search form about `app\models\Cars`.
 */
class CarsSearch extends Cars
{
    public $personSurname;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_car', 'freezer', 'freight', 'WasDel', 'Persons_ID_person'], 'integer'],
            [['not_availble_start', 'not_availble_finish', 'number', 'name', 'personSurname'], 'safe'],
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
        $query = Cars::find()->where(['cars.WasDel'=>0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
        'pageSize' => 5,      
    ],
        ]);
        
        $dataProvider->setSort([
        'attributes' => [
            
            'personSurname' => [
                'asc' => ['persons.surname' => SORT_ASC],
                'desc' => ['persons.surname' => SORT_DESC],
            ],
            'name', 
            'number',
        ]
    ]);     
         $query->joinWith(['personsIDPerson']);
         if (!($this->load($params) && $this->validate())) {
      
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ID_car' => $this->ID_car,
            'freezer' => $this->freezer,
            'freight' => $this->freight,
            'not_availble_start' => $this->not_availble_start,
            'not_availble_finish' => $this->not_availble_finish,
            'WasDel' => $this->WasDel,
            'Persons_ID_person' => $this->Persons_ID_person,
            'persons.surname'=>$this->personSurname,
            'number'=>$this->number,
//            'name'=>$this->name
        ]);

        $query->andFilterWhere(['like', 'cars.number', $this->number])
            ->andFilterWhere(['like', 'cars.name', $this->name]);

        return $dataProvider;
    }
}
