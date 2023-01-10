<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phoneNumber
 * @property int $user_id
 * @property int $department_id
 *
 * @property Attendance[] $attendances
 * @property Department $department
 * @property EmployeeGroup[] $employeeGroups
 * @property Group[] $groups
 * @property User $user
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phoneNumber', 'user_id', 'department_id'], 'required'],
            [['user_id', 'department_id'], 'integer'],
            [['name', 'email'], 'string', 'max' => 255],
            [['phoneNumber'], 'string', 'max' => 11],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã',
            'name' => 'Tên nhân viên',
            'email' => 'Email',
            'phoneNumber' => 'Số điện thoại',
            'user_id' => 'Mã người dùng',
            'department_id' => 'Mã phòng ban',
        ];
    }

    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::class, ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[EmployeeGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeGroups()
    {
        return $this->hasMany(EmployeeGroup::class, ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['id' => 'group_id'])->viaTable('employee_group', ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
