<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $statusStr;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'statusStr'], 'safe'],
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
        $query = User::find()
            // ->leftJoin('detail','detail.user_id = user.id')
            ->joinWith('detail')
            ->leftJoin('department','detail.department_id = department.id')
        ;

        // add conditions that should always apply here

        // $user = Yii::$app->user->identity;
        // $userId = $user->id;
        // $employee = Employee::findOne(['user_id' => $userId]);
        // if ($employee != Null)
        // {
        //     $departmentId = $employee->attributes['department_id'];
        // }

        // $auth = Yii::$app->authManager;

        // $roleName = $auth->getRolesByUser($userId); 
        // if (array_key_exists('admin', $roleName)) 
        // { 
        //     //code
        // }
        // else if($auth->getAssignment('departmentManager', $userId) != Null )
        // {
        //     $query = $query
        //                 ->where(['department_id' => $departmentId])
        //                 ->andWhere(['<>','employee.id', $employee->attributes['id']])
        //             ;
        // }
        // else {
        //     $ids = Employee::findAll(['user_id' => $auth->getUserIdsByRole('departmentManager')]);
        //     $strIds = '';
        //     foreach($ids as $id)
        //     {
        //         $strIds .= $id->attributes['id']. ',';
        //     }

        //     $groupId = $employee->getGroups()->one()->attributes['id'];

        //     $query = $query
        //         ->leftJoin('employee_group', 'employee.id = employee_group.employee_id')
        //         ->where(['employee_group.group_id' => $groupId])
        //         ->andWhere(['<>','employee.id', $employee->attributes['id']])
        //         ->andWhere(['NOT IN', 'employee.id', [$strIds]])
        //     ;
        // }

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $status = '';
        if ($this->statusStr == 'Hoạt động' || $this->statusStr == 'Active') $this->status = 10;
        else if ($this->statusStr == 'Khoá' || $this->statusStr == 'Inactive') $this->status = 9;
        else if ($this->statusStr == 'Xóa' || $this->statusStr == 'Deleted') $this->status = 0;



        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['=', 'status', $this->status])
        ;

        return $dataProvider;
    }
}
