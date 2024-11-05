<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MaintenanceChecklistLog;

/**
 * MaintenanceChecklistLogSearch represents the model behind the search form of `app\models\MaintenanceChecklistLog`.
 */
class MaintenanceChecklistLogSearch extends MaintenanceChecklistLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_equipment_id'], 'integer'],
            [['accomplished_by_name', 'accomplished_by_designation', 'accomplished_by_office', 'accomplished_by_date', 'endorsed_by_name', 'endorsed_by_designation', 'endorsed_by_office', 'endorsed_by_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = MaintenanceChecklistLog::find();
        $query->andWhere(['fic_equipment_id' => $params['id']]);
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
            'fic_equipment_id' => $this->fic_equipment_id,
            'accomplished_by_date' => $this->accomplished_by_date,
            'endorsed_by_date' => $this->endorsed_by_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'accomplished_by_name', $this->accomplished_by_name])
            ->andFilterWhere(['like', 'accomplished_by_designation', $this->accomplished_by_designation])
            ->andFilterWhere(['like', 'accomplished_by_office', $this->accomplished_by_office])
            ->andFilterWhere(['like', 'endorsed_by_name', $this->endorsed_by_name])
            ->andFilterWhere(['like', 'endorsed_by_designation', $this->endorsed_by_designation])
            ->andFilterWhere(['like', 'endorsed_by_office', $this->endorsed_by_office]);

        return $dataProvider;
    }
}
