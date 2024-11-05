<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EquipmentMaintenanceLog;

/**
 * EquipmentMaintenanceLogSearch represents the model behind the search form of `app\models\EquipmentMaintenanceLog`.
 */
class EquipmentMaintenanceLogSearch extends EquipmentMaintenanceLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_equipment_id'], 'integer'],
            [['maintenance_date', 'time_started', 'time_ended', 'conclusion_recommendation', 'inspected_checked_by', 'noted_by', 'created_at', 'updated_at'], 'safe'],
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
        $query = EquipmentMaintenanceLog::find()->orderBy(['maintenance_date' => SORT_DESC, 'time_started' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 12
            ]
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
            'maintenance_date' => $this->maintenance_date,
            'time_started' => $this->time_started,
            'time_ended' => $this->time_ended,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'conclusion_recommendation', $this->conclusion_recommendation])
            ->andFilterWhere(['like', 'inspected_checked_by', $this->inspected_checked_by])
            ->andFilterWhere(['like', 'noted_by', $this->noted_by]);

        return $dataProvider;
    }
}
