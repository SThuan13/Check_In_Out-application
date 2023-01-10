<?php

namespace app\models;

use Yii;
use app\models\Department;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Attendance[] $attendances
 * @property Detail[] $details
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $password;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã',
            'username' => 'Tên tài khoản',
            'auth_key' => 'Auth Key',
            'password' => 'Mật khẩu',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'verification_token' => 'Verification Token',
        ];
    }



    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Details]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(Detail::class, ['user_id' => 'id']);
    }

    public function getDetail()
    {
        return $this->hasOne(Detail::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Employees]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getEmployees()
    // {
    //     return $this->hasMany(Employee::class, ['user_id' => 'id']);
    // }

    // public function getEmployee()
    // {
    //     return $this->hasOne(Employee::class, ['user_id' => 'id']);
    // }

    public function getDepartment()
    {
        // $user = Yii::$app->user->identity;
        // $userId = $user->id;

        // $auth = Yii::$app->authManager;

        // $roleName = $auth->getRolesByUser($userId);
        // if (array_key_exists('admin', $roleName)) {
        //     return;
        // } else 
        
        //return Department::find()->where(['id' => $this->getDetail()->one()->getAttribute('department_id')]);
        
        $department = Department::find()->where(['id' => $this->getDetail()->one()->getAttribute('department_id')]);
        
        if($department == NUll)
        return 0;
        else return $department;
        //$this->hasOne(Employee::class, ['user_id' => 'id']);
    }

}
