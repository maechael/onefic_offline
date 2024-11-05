<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SupplierSearch extends Supplier
{
    public $region;
    public $province;
    public $municipalityCity;
    public $equipment;
    public $part;
    public $equipments;
    public $parts;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['municipalityCity', 'province', 'region', 'equipment', 'part', 'equipments', 'parts'], 'safe'],
            [['id', 'region_id', 'province_id', 'municipality_city_id', 'is_philgeps_registered', 'organization_status'], 'integer'],
            [['organization_name', 'form_of_organization', 'contact_person', 'cellNumber', 'email', 'telNumber', 'address', 'certificate_ref_num', 'created_at', 'updated_at'], 'safe'],
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
        $query = Supplier::find();
        $query->joinWith([
            'municipalityCity',
            'province',
            'region',
            'parts',
            'equipments'
        ]);
        $query->groupBy(['supplier.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['region'] = [
            'asc' => ['{{%region}}.number' => SORT_ASC],
            'desc' => ['{{%region}}.number' => SORT_DESC]
        ];
        $dataProvider->sort->attributes['province'] = [
            'asc' => ['{{%province}}.name' => SORT_ASC],
            'desc' => ['{{%province}}.name' => SORT_DESC]
        ];

        $dataProvider->sort->attributes['municipalityCity'] = [
            'asc' => ['{{%municipality_city}}.name' => SORT_ASC],
            'desc' => ['{{%municipality_city}}.name' => SORT_DESC]
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
            'region_id' => $this->region_id,
            'province_id' => $this->province_id,
            'municipality_city_id' => $this->municipality_city_id,
            'is_philgeps_registered' => $this->is_philgeps_registered,
            'organization_status' => $this->organization_status,
            // 'equipment.id' => $this->equipment,
            // 'part.id' => $this->part,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'form_of_organization', $this->form_of_organization])
            ->andFilterWhere(['like', 'contact_person', $this->contact_person])
            ->andFilterWhere(['like', 'cellNumber', $this->cellNumber])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'telNumber', $this->telNumber])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'certificate_ref_num', $this->certificate_ref_num])
            ->andFilterWhere(['like', '{{province}}.name', $this->province])
            ->andFilterWhere(['like', '{{region}}.code', $this->region])
            ->andFilterWhere(['{{equipment}}.id' => $this->equipments])
            ->andFilterWhere(['{{part}}.id' => $this->parts])
            ->andFilterWhere(['like', '{{municipality_city}}.name', $this->municipalityCity]);

        return $dataProvider;
    }
}
