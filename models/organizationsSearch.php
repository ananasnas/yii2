<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\organizations;

/**
 * organizationsSearch represents the model behind the search form about `app\models\organizations`.
 */
class organizationsSearch extends organizations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_organization', 'WasDel'], 'integer'],
            [['name', 'address', 'bank_account', 'inn', 'comment', 'ownership'], 'safe'],
            [['discount'], 'number'],
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
        $query = organizations::find()->where(['organizations.WasDel'=>0]);;

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
            'ID_organization' => $this->ID_organization,
            'discount' => $this->discount,
            'WasDel' => $this->WasDel,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'bank_account', $this->bank_account])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'ownership', $this->ownership]);

        return $dataProvider;
    }
}
