<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property Group[] $groups
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Mã',
            'name' => 'Tên phòng ban',
            'description' => 'Miêu tả',
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['department_id' => 'id']);
    }

    public static function list ()
    {
        $query = Department::find()
            ->leftJoin('detail', 'detail.department_id = department.id')
            ->leftJoin('user', 'user.id = detail.user_id')
            ->leftJoin('detail_group', 'detail_group.detail_id = detail.id');

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
                ->where(['detail.department_id' => $departmentId]);
                // ->andWhere(['<>', 'user.id', $userId])
                // ->andWhere(['NOT IN', 'user.id', [$strIds]]);
        } 
        // else {
        //     $ids = User::findAll(['id' => $auth->getUserIdsByRole('departmentManager')]);
        //     $strIds = '';
        //     foreach ($ids as $id) {
        //         $strIds .= $id->attributes['id'] . ',';
        //     }
        //     $detail = Detail::findOne(['user_id' => $userId]);
        //     $groupId = $detail->getGroups()->one()->attributes['id'];

        //     $query = $query
        //         ->where(['detail_group.group_id' => $groupId])
        //         ->andWhere(['<>', 'user.id', $userId])
        //         ->andWhere(['NOT IN', 'user.id', [$strIds]]);
        // }
        return $query;
    }
}
