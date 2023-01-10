<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phoneNumber
 * @property int|null $department_id
 *
 * @property Department $department
 * @property User $user
 */
class Detail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
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
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
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
