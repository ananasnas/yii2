<?php

namespace app\models;

use Yii;
use app\models\organizations;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\persons;

/**
 * personsSearch represents the model behind the search form about `app\models\persons`.
 */
class personsSearch extends persons
{
    public $org;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_person', 'count_of_open_orders', 'Organizations_ID_organization', 'Groups_ID_group', 'Sessions_ID_session', 'WasDel'], 'integer'],
            [['surname', 'name', 'middle_name', 'login', 'password', 'mail', 'tel', 'not_availble_start', 'not_availble_finish', 'position', 'org'], 'safe'],
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
        $query;
        if(Yii::$app->user->can('managementEmployees')){
        $query = persons::find()->where(['persons.Groups_ID_group' => 8])->andWhere(['persons.WasDel'=>0]);
        }
         else if(Yii::$app->user->can('managementContactPersons')){
              $query = persons::find()->where(['persons.Groups_ID_group' => 9])->andWhere(['persons.WasDel'=>0]);
         }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
        'pageSize' => 5,  
        ]]);
        
         
        $dataProvider->setSort([
        'attributes' => [
            
            'surname', 
            'name',
            'middle_name',
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
            'ID_person' => $this->ID_person,
            'not_availble_start' => $this->not_availble_start,
            'not_availble_finish' => $this->not_availble_finish,
            'count_of_open_orders' => $this->count_of_open_orders,
            'Organizations_ID_organization' => $this->Organizations_ID_organization,
            'Groups_ID_group' => $this->Groups_ID_group,
            'Sessions_ID_session' => $this->Sessions_ID_session,
            'WasDel' => $this->WasDel, 
            'organizations.name' =>$this->org,
   
        ]);

        $query->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'persons.'.'name', $this->name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'position', $this->position]);

        return $dataProvider;
    }
}
