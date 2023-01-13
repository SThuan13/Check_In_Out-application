<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Group;

/**
 * GroupSearch represents the model behind the search form of `app\models\Group`.
 */
class GroupSearch extends Group
{
    public $departmentName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'department_id'], 'integer'],
            [['name', 'description', 'departmentName'], 'safe'],
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

        // $query = $query
        //         ->from(['attendance'])
        //         ->leftJoin('employee_group', 'attendance.employee_id = employee_group.employee_id')
        //         ->where(['employee_group.group_id' => $groupId])
        //         ->andWhere(['<>','attendance.employee_id', $employee->attributes['id']])
        //         ->andWhere(['NOT IN', 'attendance.employee_id', [$strIds]])
        //     ;
        $query = Group::list()
            //->leftJoin('department', 'department.id = group.department_id')
        ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
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
            'department_id' => $this->department_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'group.description', $this->description])
            ->andFilterWhere(['like', 'department.name', $this->departmentName]);
        
        return $dataProvider;
    }
}
