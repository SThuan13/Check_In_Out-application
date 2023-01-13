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

    public static function list()
    {
        $query = DetailGroup::find()
            ->joinWith('detail')
            ->joinWith('group')
            ->leftJoin('department', 'detail.department_id = department.id')
            ->leftJoin('user', 'user.id = detail.user_id');

        $user = Yii::$app->user->identity;

        $userId = $user->id;
        $auth = Yii::$app->authManager;

        $roleName = $auth->getRolesByUser($userId);
        if (array_key_exists('admin', $roleName)) {
        } else if ($auth->getAssignment('departmentManager', $userId) != Null) {
            $detail = Detail::findOne(['user_id' => $userId]);
            $departmentId = $detail->attributes['department_id'];

            $ids = User::findAll(['id' => $auth->getUserIdsByRole('admin')]);
            $strIds = '';
            foreach ($ids as $id) {
                $strIds .= $id->attributes['id'] . ',';
            }
            $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
            foreach ($ids as $id) {
                $strIds .= $id->attributes['id'] . ',';
            }
            $query = $query
                ->where(['detail.department_id' => $departmentId])
                ->andWhere(['<>', 'user.id', $userId])
                ->andWhere(['NOT IN', 'user.id', [$strIds]]);
        } else {
            $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
            $strIds = '';
            foreach ($ids as $id) {
                $strIds .= $id->attributes['id'] . ',';
            }
            $detail = Detail::findOne(['user_id' => $userId]);
            $groupId = $detail->getGroups()->one()->attributes['id'];

            $query = $query
                ->where(['detail_group.group_id' => $groupId])
                ->andWhere(['<>', 'user.id', $userId])
                ->andWhere(['NOT IN', 'user.id', [$strIds]]);
        }
        return $query;
    }
}
