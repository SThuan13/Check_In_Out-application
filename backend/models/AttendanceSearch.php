<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Attendance;

/**
 * AttendanceSearch represents the model behind the search form of `app\models\Attendance`.
 */
class AttendanceSearch extends Attendance
{
    public $fromDate;
    public $toDate;
    public $employeeName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id',  'inStatus', 'outStatus'], 'integer'],
            [['employeeName', 'date', 'fromDate', 'toDate', 'timeIn', 'timeOut'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Mã nhân viên',
            'employeeName' => 'Tên nhân viên',
            'date' => 'Ngày',
            'fromDate' => 'Từ ngày',
            'toDate' => 'Đến ngày',
            'timeIn' => 'Giờ vào',
            'inStatus' => 'Trạng thái vào',
            'timeOut' => 'Giờ ra',
            'outStatus' => 'Trạng thái ra',
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
        //$query = $query->joinWith('employee');
        //
        // echo "<pre>";
        // print_r($params);
        // die();
        // add conditions that should always apply here

        $query = Attendance::find()
            ->joinWith('user')
            //->joinWith('detail')
            ->leftJoin('detail', 'detail.user_id = user.id')
            ->leftJoin('detail_group', 'detail.id = detail_group.detail_id')
            //>joinWith('department')
            ->leftJoin('department', 'detail.department_id = department.id')
        ;

        $user = Yii::$app->user->identity;
        
        $userId = $user->id;
        // $employee = Employee::findOne(['user_id' => $userId]);
        // if ($employee != Null)
        // {
        //     $departmentId = $employee->attributes['department_id'];
        // }
        $auth = Yii::$app->authManager;

        $roleName = $auth->getRolesByUser($userId); 
        if (array_key_exists('admin', $roleName)) 
        { 
            //
            //echo 'yes a';

        }
        else if($auth->getAssignment('departmentManager', $userId) != Null )
        {
            $detail = Detail::findOne(['user_id' => $userId]);
            $departmentId = $detail->attributes['department_id'];
            //
            //echo 'yes d M';
            $query = $query
                        ->where(['detail.department_id' => $departmentId])
                        ->andWhere(['<>','attendance.user_id', $userId])
                    ;
        }
        else {
            //echo "<pre>";
            //print_r($auth->getUserIdsByRole('departmentManager'));
            $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
            $strIds = '';
            foreach($ids as $id)
            {
                //echo
                $strIds .= $id->attributes['id']. ',';
            }
            //echo $strIds;
            //print_r($ids);
            //die();
            $detail = Detail::findOne(['user_id' => $userId]);
            $groupId = $detail->getGroups()->one()->attributes['id'];
            // $query = (new Query())
            //     ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
            //     ->from(['attendance', 'employee_group'])
            //     ->where(['attendance.employee_id = employee_group.employee_id','employee_group.group_id' => $groupId])
            //     ->all()
            //     ;
            // $query = (new Query())
            // ->select(['attendance.id', 'department_id', 'attendance.employee_id', 'date', 'timeIn', 'inStatus', 'timeOut', 'outStatus' ])
            //     ->from(['attendance'])
            //     ->leftJoin('employee_group', 'attendance.employee_id = employee_group.employee_id')
            //     ->where(['employee_group.group_id' => $groupId])
            //     //->all()
            // ;
            //echo "<prev>";
            //echo $groupId;
            //print_r($query);

            $query = $query
                ->where(['detail_group.group_id' => $groupId])
                ->andWhere(['<>','attendance.user_id', $userId])
                ->andWhere(['NOT IN', 'attendance.user_id', [$strIds]])
            ;
        }

        // $query =  $query->leftJoin('employee', 'attendance.employee_id = employee.id') ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
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
            //'user_id' => $this->employee_id,
            'date' => $this->date,
            'timeIn' => $this->timeIn,
            'inStatus' => $this->inStatus,
            'timeOut' => $this->timeOut,
            'outStatus' => $this->outStatus,
        ]);

        $query->andFilterWhere(['like', 'detail.name', $this->employeeName]);
        if ($this->date == Null && $this->fromDate != Null && $this->toDate != Null)
        {
            $query->andFilterWhere(['between', 'date', $this->fromDate, $this->toDate]);
        }

        $dataProvider->setSort([
            'attributes' => [
                'id',
                //'detail.name',
                'date',
                'timeIn',
                'inStatus',
                'timeOut',
                'outStatus'
            ]
        ]);

        return $dataProvider;
    }
}
