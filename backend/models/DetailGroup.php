<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detail_group".
 *
 * @property int $detail_id
 * @property int $group_id
 *
 * @property Detail $detail
 * @property Group $group
 */
class DetailGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail_id', 'group_id'], 'required'],
            [['detail_id', 'group_id'], 'integer'],
            [['detail_id', 'group_id'], 'unique', 'targetAttribute' => ['detail_id', 'group_id']],
            [['detail_id'], 'exist', 'skipOnError' => true, 'targetClass' => Detail::class, 'targetAttribute' => ['detail_id' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => 'Detail ID',
            'group_id' => 'Group ID',
        ];
    }

    /**
     * Gets query for [[Detail]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetail()
    {
        return $this->hasOne(Detail::class, ['id' => 'detail_id']);
    }

    /**
     * Gets query for [[Group]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
