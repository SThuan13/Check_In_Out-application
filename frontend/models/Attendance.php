<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id	
 * @property int $user_id
 * @property string $date
 * @property string $timeIn
 * @property int $inStatus
 * @property string|null $timeOut
 * @property int|null $outStatus
 *
 * @property User $user
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'date', 'timeIn', 'inStatus'], 'required'],
            [['user_id', 'inStatus', 'outStatus'], 'integer'],
            [['date', 'timeIn', 'timeOut'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Mã nhân viên',
            'date' => 'Ngày',
            'timeIn' => 'Giờ vào',
            'inStatus' => 'Trạng thái vào ',
            'timeOut' => 'Giờ ra',
            'outStatus' => 'Trạng thái ra',
        ];
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
