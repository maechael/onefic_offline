<?php

namespace app\models;

use app\models\FicEquipment;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * FicEquipmentSearch represents the model behind the search form of `app\modules\ficModule\models\FicEquipment`.
 */
class FicEquipmentSearch extends FicEquipment
{
    public $equipment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'fic_id', 'equipment_id', 'status'], 'integer'],
            [['serial_number', 'equipment', 'created_at', 'updated_at'], 'safe'],
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
        $query = FicEquipment::find()->joinWith('equipment')->where(['fic_id' => Yii::$app->user->identity->userProfile->fic_affiliation]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['defaultPageSize'],
            ],
        ]);

        $dataProvider->sort->attributes['equipment'] = [
            'asc' => ['{{%equipment}}.model' => SORT_ASC],
            'desc' => ['{{%equipment}}.model' => SORT_DESC]
        ];

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
            'status' => $this->status,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'serial_number', $this->serial_number])
            ->andFilterWhere(['like', '{{%equipment}}.model', $this->equipment])
            ->andFilterWhere(['like', '{{%fic_equipment}}.created_at', $this->created_at])
            ->andFilterWhere(['like', '{{%fic_equipment}}.updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
