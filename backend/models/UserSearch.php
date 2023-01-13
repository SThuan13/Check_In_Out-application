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
        $query = User::list();
        // $query = User::find()
        //     // ->leftJoin('detail','detail.user_id = user.id')
        //     ->joinWith('detail')
        //     ->leftJoin('department','detail.department_id = department.id')
        // ;

        // // add conditions that should always apply here

        // $user = Yii::$app->user->identity;
        
        // $userId = $user->id;
        // // $employee = Employee::findOne(['user_id' => $userId]);
        // // if ($employee != Null)
        // // {
        // //     $departmentId = $employee->attributes['department_id'];
        // // }
        // $auth = Yii::$app->authManager;

        // $roleName = $auth->getRolesByUser($userId); 
        // if (array_key_exists('admin', $roleName)) 
        // { 
        //     //
        //     //echo 'yes a';

        // }
        // else if($auth->getAssignment('departmentManager', $userId) != Null )
        // {
        //     $detail = Detail::findOne(['user_id' => $userId]);
        //     $departmentId = $detail->attributes['department_id'];
            
        //     $ids = User::findAll(['id' => $auth->getUserIdsByRole('admin')]);
        //     $strIds = '';
        //     foreach($ids as $id)
        //     {
        //         //echo
        //         $strIds .= $id->attributes['id']. ',';
        //     }
        //     $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
        //     foreach($ids as $id)
        //     {
        //         //echo
        //         $strIds .= $id->attributes['id']. ',';
        //     }
        //     //
        //     //echo 'yes d M';
        //     $query = $query
        //                 ->where(['detail.department_id' => $departmentId])
        //                 ->andWhere(['<>','user.id', $userId])
        //                 ->andWhere(['NOT IN', 'user.id', [$strIds]])
        //             ;
        // }
        // else {
        //     //echo "<pre>";
        //     //print_r($auth->getUserIdsByRole('departmentManager'));
        //     $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
        //     $strIds = '';
        //     foreach($ids as $id)
        //     {
        //         //echo
        //         $strIds .= $id->attributes['id']. ',';
        //     }
        //     //echo $strIds;
        //     //print_r($ids);
        //     //die();
        //     $detail = Detail::findOne(['user_id' => $userId]);
        //     $groupId = $detail->getGroups()->one()->attributes['id'];
        //     // $query = (new Query())
        //     //     ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
        //     //     ->from(['attendance', 'employee_group'])
        //     //     ->where(['attendance.employee_id = employee_group.employee_id','employee_group.group_id' => $groupId])
        //     //     ->all()
        //     //     ;
        //     // $query = (new Query())
        //     // ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
        //     //     ->from(['attendance'])
        //     //     ->leftJoin('employee_group', 'attendance.employee_id = employee_group.employee_id')
        //     //     ->where(['employee_group.group_id' => $groupId])
        //     //     //->all()
        //     // ;
        //     //echo "<prev>";
        //     //echo $groupId;
        //     //print_r($query);

        //     $query = $query
        //         ->where(['detail_group.group_id' => $groupId])
        //         ->andWhere(['<>','user.id', $userId])
        //         ->andWhere(['NOT IN', 'user.id', [$strIds]])
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

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'detail.name',
                'detail.email',
                'detail.phoneNumber',
                //'department.name',
                'status',
                'created_at',
                'updated_at',
            ]
        ]);

        return $dataProvider;
    }
}
