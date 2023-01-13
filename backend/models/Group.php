<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $department_id
 *
 * @property Department $department
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'department_id'], 'required'],
            [['department_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 255],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Tên nhóm',
            'description' => 'Miêu tả',
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

    public static function list()
    {
        $query = group::find()
            ->joinWith('department')
            ->leftJoin('detail_group', 'detail_group.group_id = group.id')
            ->leftJoin('detail', 'detail.id = detail_group.detail_id')
            ->leftJoin('user', 'user.id = detail.user_id');

        $user = Yii::$app->user->identity;

        $userId = $user->id;
        $auth = Yii::$app->authManager;

        $roleName = $auth->getRolesByUser($userId);
        if (array_key_exists('admin', $roleName)) {
        } 
        else if ($auth->getAssignment('departmentManager', $userId) != Null) {
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
                ->where(['department.id' => $departmentId]);
                // ->andWhere(['<>', 'user.id', $userId])
                // ->andWhere(['NOT IN', 'user.id', [$strIds]]);
        } 
        else {
            $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
            $strIds = '';
            foreach ($ids as $id) {
                $strIds .= $id->attributes['id'] . ',';
            }
            $detail = Detail::findOne(['user_id' => $userId]);
            $groupId = $detail->getGroups()->one()->attributes['id'];

            $query = $query
                ->where(['group.id' => $groupId]);
        }
        return $query;
    }
}
