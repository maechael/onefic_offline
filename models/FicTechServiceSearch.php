<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FicTechService;

/**
 * FicTechServiceSearch represents the model behind the search form of `app\models\FicTechService`.
 */
class FicTechServiceSearch extends FicTechService
{
    public $techService;
    public $equipment;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_id', 'equipment_id', 'tech_service_id'], 'integer'],
            [['charging_type', 'created_at', 'updated_at', 'techService', 'equipment'], 'safe'],
            [['charging_fee'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = FicTechService::find();
        $query->joinWith(['techService', 'equipment']);


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
            'id' => $this->id,
            'fic_id' => $this->fic_id,
            'equipment_id' => $this->equipment_id,
            'tech_service_id' => $this->tech_service_id,
            'charging_fee' => $this->charging_fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'charging_type', $this->charging_type])->andFilterWhere(['like', '{{%tech_service}}.name', $this->techService])->andFilterWhere(['like', '{{%equipment}}.model', $this->equipment]);


        return $dataProvider;
    }
}
